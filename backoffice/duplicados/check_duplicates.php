<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert_data'])) {

    require "../verifica.php"; 
    require "../config/basedados.php"; 

    // SQL para buscar dados das publicações e dos emails dos investigadores
    $sql = "
        SELECT 
            p.idPublicacao as id, 
            i.email as email, 
            REGEXP_SUBSTR(dados, 'title = {(.*?)}') as title,
            REGEXP_SUBSTR(dados, 'journal = {(.*?)}') as journal,
            REGEXP_SUBSTR(dados, 'volume = {(.*?)}') as volume,
            REGEXP_SUBSTR(dados, 'number = {(.*?)}') as pnumber,
            REGEXP_SUBSTR(dados, 'pages = {(.*?)}') as pages,
            REGEXP_SUBSTR(dados, 'year = {(.*?)}') as pyear,
            REGEXP_SUBSTR(dados, 'url = {(.*?)}') as purl,
            REGEXP_SUBSTR(dados, 'author = {(.*?)}') as author,
            REGEXP_SUBSTR(dados, 'keywords = {(.*?)}') as keywords
        FROM 
            publicacoes AS p 
            JOIN publicacoes_investigadores AS pi2 ON p.idPublicacao = pi2.publicacao
            JOIN investigadores AS i ON pi2.investigador = i.id;
    ";

    // SQL para buscar os IDs das publicações que já foram verificadas como duplicadas
    $sql_checked_ids = "
        SELECT
            JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(publicacoes, '$[0]'), '$.id1')) AS id1
        FROM
            technart.publicacoes_duplicados;
    ";

    
    $result = mysqli_query($conn, $sql);
    $result_checked_ids = mysqli_query($conn, $sql_checked_ids);

 
    if ($result && $result_checked_ids) {
        $rows = $result->fetch_all(MYSQLI_ASSOC); 
        $checked_ids = array_column($result_checked_ids->fetch_all(MYSQLI_ASSOC), 'id1'); // Extrai os IDs já verificados

        // Percorre todas as publicações
        foreach ($rows as $i => $row1) {
            if (in_array($row1['id'], $checked_ids)) continue; // Se a publicação já foi verificada, passa à seguinte

            // Compara cada publicação com todas as seguintes
            for ($j = $i + 1; $j < count($rows); $j++) {
                $row2 = $rows[$j];

                $similarities = []; // Array para guardar as similaridades
                // Calcula a similaridade para cada campo relevante
                foreach (['title', 'journal', 'volume', 'pnumber', 'pages', 'pyear', 'purl', 'author', 'keywords'] as $field) {
                    if (isset($row1[$field]) && isset($row2[$field])) {
                        similar_text(trim(strtolower($row1[$field])), trim(strtolower($row2[$field])), $percent);
                        $similarities[$field] = $percent;
                    }
                }

                // Se a similaridade do título for maior que 80%, considera como possível duplicado DEFINIR AQUI O QUE ATINGIR MELHOR RESULTADO
                if ($similarities['title'] > 80) {
                    $status = 'Por Verificar'; // Estado inicial da verificação

                    // Prepara os dados para inserção na tabela de duplicados como um json dos dois elementos comparados mais a percentagem obtida
                    // Pode-se usar esta percentagem para implementar um algoritmo que limpa de bd ou bloqueia da api do cienciaID duplicados claros
                    $data_to_insert = [
                        'status' => $status,
                        'publicacoes' => json_encode([['id1' => $row1['id'], 'id2' => $row2['id']]], JSON_UNESCAPED_UNICODE),
                        'email' => json_encode([['email1' => $row1['email'], 'email2' => $row2['email']]], JSON_UNESCAPED_UNICODE),
                        'title' => json_encode([['title1' => $row1['title'], 'title2' => $row2['title'], 'percenttitle' => $similarities['title']]], JSON_UNESCAPED_UNICODE),
                        'journal' => json_encode([['journal1' => $row1['journal'], 'journal2' => $row2['journal'], 'percentjournal' => $similarities['journal']]], JSON_UNESCAPED_UNICODE),
                        'volume' => json_encode([['volume1' => $row1['volume'], 'volume2' => $row2['volume'], 'percentvolume' => $similarities['volume']]], JSON_UNESCAPED_UNICODE),
                        'numbers' => json_encode([['number1' => $row1['pnumber'], 'number2' => $row2['pnumber'], 'percentnumber' => $similarities['pnumber']]], JSON_UNESCAPED_UNICODE),
                        'pages' => json_encode([['page1' => $row1['pages'], 'pages2' => $row2['pages'], 'percentpage' => $similarities['pages']]], JSON_UNESCAPED_UNICODE),
                        'years' => json_encode([['year1' => $row1['pyear'], 'year2' => $row2['pyear'], 'percentyear' => $similarities['pyear']]], JSON_UNESCAPED_UNICODE),
                        'url' => json_encode([['url1' => $row1['purl'], 'url2' => $row2['purl'], 'percenturl' => $similarities['purl']]], JSON_UNESCAPED_UNICODE),
                        'authors' => json_encode([['author1' => $row1['author'], 'author2' => $row2['author'], 'percentauthor' => $similarities['author']]], JSON_UNESCAPED_UNICODE),
                        'keywords' => json_encode([['keyword1' => $row1['keywords'], 'keyword2' => $row2['keywords'], 'percentkeyword' => $similarities['keywords']]], JSON_UNESCAPED_UNICODE)
                    ];

                    // Prepara e executa a inserção na tabela de duplicados
                    $sql_insert = "
                        INSERT INTO publicacoes_duplicados 
                        (status, publicacoes, email, title, journal, volume, numbers, pages, years, url, authors, keywords) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ";

                    $stmt = mysqli_prepare($conn, $sql_insert);
                    mysqli_stmt_bind_param($stmt, 'ssssssssssss', ...array_values($data_to_insert));
                    mysqli_stmt_execute($stmt);
                }
            }
        }
    }
}