<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert_data'])) {

    require "../verifica.php";
    require "../config/basedados.php";

    $sql =
        "SELECT idPublicacao as id, i.email as email, 
        REGEXP_SUBSTR(dados, 'title = {(.*?)}') as title,
        REGEXP_SUBSTR(dados, 'journal = {(.*?)}') as journal,
        REGEXP_SUBSTR(dados, 'volume = {(.*?)}') as volume,
        REGEXP_SUBSTR(dados, 'number = {(.*?)}') as pnumber,
        REGEXP_SUBSTR(dados, 'pages = {(.*?)}') as pages,
        REGEXP_SUBSTR(dados, 'year = {(.*?)}') as pyear,
        REGEXP_SUBSTR(dados, 'url = {(.*?)}') as purl,
        REGEXP_SUBSTR(dados, 'author = {(.*?)}') as author,
        REGEXP_SUBSTR(dados, 'keywords = {(.*?)}') as keywords
        FROM publicacoes AS p 
        JOIN publicacoes_investigadores AS pi2 ON p.idPublicacao = pi2.publicacao
        JOIN investigadores AS i ON pi2.investigador = i.id;";

    $sqlid =
        "SELECT
        JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(publicacoes , '$[0]'), '$.id1')) AS id1
        FROM
        technart.publicacoes_duplicados;";

    $resultid = mysqli_query($conn, $sqlid);
    $result = mysqli_query($conn, $sql);

    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $ids = array_column($rows, 'id');
    $emails = array_column($rows, 'email');
    $titles = array_column($rows, 'title');
    $journals = array_column($rows, 'journal');
    $volumes = array_column($rows, 'volume');
    $numbers = array_column($rows, 'pnumber');
    $pages = array_column($rows, 'pages');
    $years = array_column($rows, 'pyear');
    $urls = array_column($rows, 'purl');
    $authors = array_column($rows, 'author');
    $keywords = array_column($rows, 'keywords');

    $rowsid = $resultid->fetch_all(MYSQLI_ASSOC);
    $rowschecked = array_column($rowsid, 'id1');

    for ($i = 0; $i < count($titles); $i++) {

        $id1 = $ids[$i];
        $isChecked = false;

        for ($k = 0; $k < count($rowschecked); $k++) {
            if ($id1 == $rowschecked[$k]) {
                $isChecked = true;
            }
        }

        if (!$isChecked) {
            for ($j = $i + 1; $j < count($titles); $j++) {

                $id2 = $ids[$j];

                $email1 = $emails[$i];
                $email2 = $emails[$j];

                $title1 = substr(substr($titles[$i], strpos($titles[$i], '{') + 1), 0, strpos(substr($titles[$i], strpos($titles[$i], '{') + 1), '}'));;
                $journal1 = substr(substr($journals[$i], strpos($journals[$i], '{') + 1), 0, strpos(substr($journals[$i], strpos($journals[$i], '{') + 1), '}'));;
                $volume1 = substr(substr($volumes[$i], strpos($volumes[$i], '{') + 1), 0, strpos(substr($volumes[$i], strpos($volumes[$i], '{') + 1), '}'));;
                $number1 = substr(substr($numbers[$i], strpos($numbers[$i], '{') + 1), 0, strpos(substr($numbers[$i], strpos($numbers[$i], '{') + 1), '}'));;
                $page1 = substr(substr($pages[$i], strpos($pages[$i], '{') + 1), 0, strpos(substr($pages[$i], strpos($pages[$i], '{') + 1), '}'));;
                $year1 = substr(substr($years[$i], strpos($years[$i], '{') + 1), 0, strpos(substr($years[$i], strpos($years[$i], '{') + 1), '}'));;
                $url1 = substr(substr($urls[$i], strpos($urls[$i], '{') + 1), 0, strpos(substr($urls[$i], strpos($urls[$i], '{') + 1), '}'));;
                $author1 = substr(substr($authors[$i], strpos($authors[$i], '{') + 1), 0, strpos(substr($authors[$i], strpos($authors[$i], '{') + 1), '}'));;
                $keyword1 = substr(substr($keywords[$i], strpos($keywords[$i], '{') + 1), 0, strpos(substr($keywords[$i], strpos($keywords[$i], '{') + 1), '}'));;

                $title2 = substr(substr($titles[$j], strpos($titles[$j], '{') + 1), 0, strpos(substr($titles[$j], strpos($titles[$j], '{') + 1), '}'));;
                $journal2 = substr(substr($journals[$j], strpos($journals[$j], '{') + 1), 0, strpos(substr($journals[$j], strpos($journals[$j], '{') + 1), '}'));;
                $volume2 = substr(substr($volumes[$j], strpos($volumes[$j], '{') + 1), 0, strpos(substr($volumes[$j], strpos($volumes[$j], '{') + 1), '}'));;
                $number2 = substr(substr($numbers[$j], strpos($numbers[$j], '{') + 1), 0, strpos(substr($numbers[$j], strpos($numbers[$j], '{') + 1), '}'));;
                $page2 = substr(substr($pages[$j], strpos($pages[$j], '{') + 1), 0, strpos(substr($pages[$j], strpos($pages[$j], '{') + 1), '}'));;
                $year2 = substr(substr($years[$j], strpos($years[$j], '{') + 1), 0, strpos(substr($years[$j], strpos($years[$j], '{') + 1), '}'));;
                $url2 = substr(substr($urls[$j], strpos($urls[$j], '{') + 1), 0, strpos(substr($urls[$j], strpos($urls[$j], '{') + 1), '}'));;
                $author2 = substr(substr($authors[$j], strpos($authors[$j], '{') + 1), 0, strpos(substr($authors[$j], strpos($authors[$j], '{') + 1), '}'));;
                $keyword2 = substr(substr($keywords[$j], strpos($keywords[$j], '{') + 1), 0, strpos(substr($keywords[$j], strpos($keywords[$j], '{') + 1), '}'));;

                $percenttitle = $percentjournal = $percentvolume = $percentnumber = $percentpage = $percentyear = $percenturl = $percentauthor = $percentkeyword = 0;

                if (strlen($title1) > 0 && strlen($title2) > 0) {
                    similar_text(trim(strtolower($title1)), trim(strtolower($title2)), $percenttitle);
                }
                if (strlen($journal1) > 0 && strlen($journal2) > 0) {
                    similar_text(trim(strtolower($journal1)), trim(strtolower($journal2)), $percentjournal);
                }
                if (strlen($volume1) > 0 && strlen($volume2) > 0) {
                    similar_text(trim(strtolower($volume1)), trim(strtolower($volume2)), $percentvolume);
                }
                if (strlen($number1) > 0 && strlen($number2) > 0) {
                    similar_text(trim(strtolower($number1)), trim(strtolower($number2)), $percentnumber);
                }
                if (strlen($page1) > 0 && strlen($page2) > 0) {
                    similar_text(trim(strtolower($page1)), trim(strtolower($page2)), $percentpage);
                }
                if (strlen($year1) > 0 && strlen($year2) > 0) {
                    similar_text(trim(strtolower($year1)), trim(strtolower($year2)), $percentyear);
                }
                if (strlen($url1) > 0 && strlen($url2) > 0) {
                    similar_text(trim(strtolower($url1)), trim(strtolower($url2)), $percenturl);
                }
                if (strlen($author1) > 0 && strlen($author2) > 0) {
                    similar_text(trim(strtolower($author1)), trim(strtolower($author2)), $percentauthor);
                }
                if (strlen($keyword1) > 0 && strlen($keyword2) > 0) {
                    similar_text(trim(strtolower($keyword1)), trim(strtolower($keyword2)), $percentkeyword);
                }

                $status = 'Por Verificar';

                $idObject = ['id1' => $id1, 'id2' => $id2];
                $idJSON = json_encode([$idObject], JSON_UNESCAPED_UNICODE);

                $idObject = ['email1' => $email1, 'email2' => $email2];
                $emailJSON = json_encode([$idObject], JSON_UNESCAPED_UNICODE);

                $idObject = ['title1' => $title1, 'title2' => $title2, 'percenttitle' => $percenttitle];
                $titleJSON = json_encode([$idObject], JSON_UNESCAPED_UNICODE);

                $idObject = ['journal1' => $journal1, 'journal2' => $journal2, 'percentjournal' => $percentjournal];
                $journalJSON = json_encode([$idObject], JSON_UNESCAPED_UNICODE);

                $idObject = ['volume1' => $volume1, 'volume2' => $volume2, 'percentvolume' => $percentvolume];
                $volumeJSON = json_encode([$idObject], JSON_UNESCAPED_UNICODE);

                $idObject = ['number1' => $number1, 'number2' => $number2, 'percentnumber' => $percentnumber];
                $numbersJSON = json_encode([$idObject], JSON_UNESCAPED_UNICODE);

                $idObject = ['page1' => $page1, 'pages2' => $page2, 'percentpage' => $percentpage];
                $pagesJSON = json_encode([$idObject], JSON_UNESCAPED_UNICODE);

                $idObject = ['year1' => $year1, 'year2' => $year2, 'percentyear' => $percentyear];
                $yearsJSON = json_encode([$idObject], JSON_UNESCAPED_UNICODE);

                $idObject = ['url1' => $url1, 'url2' => $url2, 'percenturl' => $percenturl];
                $urlJSON = json_encode([$idObject], JSON_UNESCAPED_UNICODE);

                $idObject = ['author1' => $author1, 'author2' => $author2, 'percentauthor' => $percentauthor];
                $authorsJSON = json_encode([$idObject], JSON_UNESCAPED_UNICODE);

                $idObject = ['keyword1' => $keyword1, 'keyword2' => $keyword2, 'percentkeyword' => $percentkeyword];
                $keywordsJSON = json_encode([$idObject], JSON_UNESCAPED_UNICODE);

                if ($_SERVER["REQUEST_METHOD"] == "POST" && $percenttitle > 80) {

                    $sql = "INSERT INTO publicacoes_duplicados (status, publicacoes, email, title, journal, volume, numbers, pages, years, url, authors, keywords) " .
                        "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'ssssssssssss', $status, $idJSON, $emailJSON, $titleJSON, $journalJSON, $volumeJSON, $numbersJSON, $pagesJSON, $yearsJSON, $urlJSON, $authorsJSON, $keywordsJSON);
                    mysqli_stmt_execute($stmt);
                }
            }
        }
    }
}
