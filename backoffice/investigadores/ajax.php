<?php
require "../config/basedados.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST["anoRelatorio"])) {
    // Verifica se o campo "anoRelatorio" que foi submetido via POST está vazio
    if ($_POST["anoRelatorio"] != "") {
        $ano = $_POST["anoRelatorio"];
        $msg = 'Foi selecionado o ano ' . $ano;
    } else {
        // Se "anoRelatorio" estiver vazio, verifica se existe já um ano selecionado na sessão
        if (isset($_SESSION["anoRelatorio"]) && $_SESSION["anoRelatorio"] != "") {
            //Se existir usa o ano já selecionado
            $ano = $_SESSION["anoRelatorio"];
        } else {
            // Se não existir na sessão, usa o ano atual
            $ano = date("Y");
        }
        $msg = "Campo submetido vazio! (Ano: " . $ano . ")";
    }

    // Armazena o valor de $ano na sessão
    $_SESSION["anoRelatorio"] = $ano;

    // Cria um array com o ano e a mensagem
    $resultadoAno = array(
        "ano" => $ano,
        "msg" => $msg
    );

    // Define o tipo de conteúdo da resposta como JSON
    header('Content-Type: application/json');
    // Envia a resposta em formato JSON
    echo json_encode($resultadoAno);

} else if (isset($_POST["idGerar"])) {
    // Verifica se a variável de sessão "anoRelatorio" está definida
    if (isset($_SESSION["anoRelatorio"])) {
        // Se estiver definida, utiliza o ano da variável de sessão
        $year = $_SESSION["anoRelatorio"];
    } else {
        // Caso contrário, usa o ano atual
        $year = date("Y");
    }
    // Define um array para armazenar os resultados
    $reportData = array();

    // Prepara e executa a consulta SQL para 'publicacoes'
    $sql = "SELECT p.dados, p.pais, p.cidade, p.tipo
        FROM publicacoes p
        INNER JOIN publicacoes_investigadores pi ON p.idPublicacao = pi.publicacao
        WHERE pi.investigador = ? AND visivel = 1 AND YEAR(data) = ?";

    $stmt = mysqli_prepare($conn, $sql);
    $investigatorId = $_POST["idGerar"];
    mysqli_stmt_bind_param($stmt, "ii", $investigatorId, $year);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $publicacoes = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Armazena 'publicacoes' no array reportData
        $reportData['publicacoes'] = $publicacoes;
    } else {
        die("Execução falhou: " . mysqli_error($conn));
    }

    // Prepara e executa a consulta SQL para 'patent'
    $sql = "SELECT p.dados
        FROM publicacoes p
        INNER JOIN publicacoes_investigadores pi ON p.idPublicacao = pi.publicacao
        WHERE pi.investigador = ? AND p.visivel = 1 AND YEAR(p.data) = ? AND p.tipo = 'patent'";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $investigatorId, $year);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $patents = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Armazena 'patents' no array reportData
        $reportData['patents'] = $patents;
    } else {
        die("Execução falhou: " . mysqli_error($conn));
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);

    // Retorna reportData
    header('Content-Type: application/json');
    echo json_encode($reportData);
}
