<?php
require "../verifica.php";
require "../config/basedados.php";
require_once "../config/credentials.php";
//Se o utilizador não é um administrador ou o proprio não tem permissão para alterar as publicações
if ($_SESSION["autenticado"] != 'administrador' && $_SESSION["autenticado"] != $_GET["id"]) {
    header("Location: index.php");
}

function formatAuthors($authors)
{
    $authorList = [];
    if (isset($authors->author)) {
        foreach ($authors->author as $author) {
            //Colocar os nomes dos autores no array authorList
            if (isset($author->value)) {
                $authorList[] = $author->value;
            }
        }
    }
    //Devolver uma string com todos os nomes de autores separados um do outro pelo um ' and '
    return implode(' and ', $authorList);
}


function getFormatType($type)
{
    //Obter o tipo correspondente para tornar a publicação numa referência APA com citation.js
    $aliases = array(
        'journal-article' => 'article',
        'journal-issue' => 'periodical',
        'book' => 'book',
        'edited-book' => 'book',
        'book-chapter' => 'inbook',
        'book-review' => 'review',
        'translation' => 'book',
        'dissertation' => 'thesis',
        'newspapper-article' => 'article',
        'newsletter-article' => 'article',
        'encyclopedia-entry' => 'inreference',
        'magazine-article' => 'article',
        'dictionary-entry' => 'inreference',
        'report' => 'report',
        'working-paper' => 'report',
        'manual' => 'book',
        'online-resource' => 'online',
        'test' => 'misc',
        'website' => 'online',
        'conference-paper' => 'inproceedings',
        'conference-abstract' => 'article',
        'conference-poster' => 'inproceedings',
        'exhibition-catalogue' => 'book',
        'preface-postface' => 'incollection',
        'preprint' => 'article'
    );

    $entryStyle = isset($aliases[$type]) ? $aliases[$type] : 'misc';
    return $entryStyle;
}

// Função para gerar a publicação formartada de forma a poder utilizar o citacion.js para criar a referençia APA
function generatePublicationEntry($type,  $id, $fields)
{
    $formattedFields = [];
    foreach ($fields as $fieldName => $fieldValue) {
        $formattedFields[] = "  $fieldName = {" . addcslashes(addslashes($fieldValue), '{}') . "}";
    }
    return "@" . getFormatType($type) . "{" . $id . "," . implode(", ", $formattedFields) . "}";
}

function generatePageRange($dataOutput, $fromField, $toField)
{
    $pageRange = isset($dataOutput->{$fromField})
        ? $dataOutput->{$fromField} . (isset($dataOutput->{$toField}) ? "--" . $dataOutput->{$toField} : "")
        : (isset($dataOutput->{$toField}) ? $dataOutput->{$toField} : "");

    return $pageRange;
}

//Função que processa a publicação dependo do tipo 
//Retorna as informações a adicionar à BD, a data, o país e a cidade, e um array com os campos no formato que o citacion.js utiliza
function getPublicationInfo($dataOutput, $typeOutput)
{
    $date = null;
    $location = null;
    $year = null;
    //Lidar com os dados dependendo do tipo de publicação
    switch ($typeOutput) {
        case 'journal-article':
            $formatedData = array(
                "title" => $dataOutput->{"article-title"},
                "journal" => $dataOutput->journal,
                "volume" => $dataOutput->volume,
                "number" => $dataOutput->issue,
                "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                "url" => $dataOutput->{"url"},
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );

            break;
        case 'journal-issue':
            $formatedData = array(
                "title" => addslashes($dataOutput->{"issue-title"}),
                "journal" => addslashes($dataOutput->journal),
                "volume" => $dataOutput->volume,
                "number" => $dataOutput->{"issue-number"},
                "pages" => $dataOutput->{"number-of-pages"},
                "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                "editor" => formatAuthors($dataOutput->{"editors"}),
                "url" => $dataOutput->{"url"},
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            if (isset($dataOutput->{"publication-date"}->day)) {
                $data["date"] = $dataOutput->{"publication-date"}->year  . "-" . $dataOutput->{"publication-date"}->month . "-" . $dataOutput->{"publication-date"}->day;
            }
            break;
        case 'book':
            $formatedData = array(
                "title" => $dataOutput->{"title"},
                "volume" => $dataOutput->volume,
                "edition" => $dataOutput->edition,
                "pages" => $dataOutput->{"number-of-pages"},
                "year" => $dataOutput->{"publication-year"},
                "publisher" => addslashes($dataOutput->{"publisher"}),
                "url" => $dataOutput->{"url"},
                "author" => formatAuthors($dataOutput->{"authors"}),
                "editor" => formatAuthors($dataOutput->{"editors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'edited-book':
            $formatedData = array(
                "title" => $dataOutput->{"title"},
                "volume" => $dataOutput->volume,
                "edition" => $dataOutput->edition,
                "pages" => $dataOutput->{"number-of-pages"},
                "year" => $dataOutput->{"publication-year"},
                "publisher" => addslashes(addslashes($dataOutput->{"publisher"})),
                "url" => addslashes($dataOutput->url),
                "author" => formatAuthors($dataOutput->{"authors"}),
                "editor" => formatAuthors($dataOutput->{"editors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'book-chapter':
            $formatedData = array(
                "title" => addslashes($dataOutput->{"chapter-title"}),
                "booktitle" => addslashes($dataOutput->{"book-title"}),
                "volume" => $dataOutput->{"book-volume"},
                "edition" => $dataOutput->{"book-edition"},
                "pages" => generatePageRange($dataOutput, "chapter-page-range-from", "chapter-page-range-to"),
                "year" => $dataOutput->{"publication-year"},
                "publisher" => addslashes($dataOutput->{"book-publisher"}),
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "editor" => formatAuthors($dataOutput->{"editors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'book-review':
            $date = $dataOutput->{"date-of-review-publication"};
            $location = $dataOutput->{"book-publication-location"};
            $formatedData = array(
                "title" => addslashes($dataOutput->{"review-title"}),
                "journal" => addslashes($dataOutput->{"published-in"}),
                "volume" => $dataOutput->{"review-volume"},
                "number" => $dataOutput->{"review-issue"},
                "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                "year" => isset($dataOutput->{"date-of-review-publication"}) ? $dataOutput->{"date-of-review-publication"}->year : "",
                "publisher" => $dataOutput->{"review-publisher"},
                "url" => $dataOutput->url,
                "booktitle" => addslashes($dataOutput->{"book-title"}),
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'translation':
            $formatedData = array(
                "title" => $dataOutput->{"title"},
                "booktitle" => addslashes($dataOutput->{"series-title"}),
                "volume" => $dataOutput->{"volume"},
                "edition" => $dataOutput->{"edition"},
                "pages" => $dataOutput->{"number-of-pages"},
                "year" => $dataOutput->{"publication-year"},
                "publisher" => $dataOutput->{"publisher"},
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'dissertation':
            $date = $dataOutput->{"completion-date"};
            //Obter a localização da primeira instituição
            $institution =  isset($dataOutput->institutions) ? $dataOutput->institutions->institution[0] : null;
            $location = isset($institution) ? $institution->{'institution-address'} : null;

            $formatedData = array(
                "title" => $dataOutput->{"title"},
                "school" => implode(' and ', array_map(function ($institution) {
                    return $institution->{"institution-name"};
                }, isset($dataOutput->institutions->institution) ? $dataOutput->institutions->institution : array())),
                "year" => isset($dataOutput->{"completion-date"}) ? $dataOutput->{"completion-date"}->year : "",
                "month" => isset($dataOutput->{"completion-date"}) ? $dataOutput->{"completion-date"}->month : "",
                "type" => isset($dataOutput->{"degree-type"}) ? $dataOutput->{"degree-type"}->value : "",
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'newspapper-article':
            $formatedData = array(
                "title" => $dataOutput->{"article-title"},
                "journal" => $dataOutput->{"newspaper"},
                "volume" => $dataOutput->{"volume"},
                "number" => $dataOutput->{"edition"},
                "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'newsletter-article':
            $formatedData = array(
                "title" => $dataOutput->{"article-title"},
                "journal" => $dataOutput->{"newsletter"},
                "volume" => $dataOutput->{"volume"},
                "number" => $dataOutput->{"issue"},
                "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'encyclopedia-entry':
            $formatedData = array(
                "title" => $dataOutput->{"entry-title"},
                "booktitle" => addslashes($dataOutput->{"encyclopedia-title"}),
                "volume" => $dataOutput->{"volume"},
                "number" => $dataOutput->{"edition"},
                "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                "year" => $dataOutput->{"publication-year"},
                "publisher" => $dataOutput->{"publisher"},
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "editor" => formatAuthors($dataOutput->{"editors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'magazine-article':
            $formatedData = array(
                "title" => $dataOutput->{"article-title"},
                "journal" => $dataOutput->{"magazine"},
                "volume" => $dataOutput->{"volume"},
                "number" => $dataOutput->{"issue"},
                "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "editor" => formatAuthors($dataOutput->{"editors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'dictionary-entry':
            $formatedData = array(
                "title" => $dataOutput->{"entry-title"},
                "booktitle" => $dataOutput->{"dictionary-title"},
                "volume" => $dataOutput->{"volume"},
                "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                "year" => $dataOutput->{"publication-year"},
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "editor" => formatAuthors($dataOutput->{"editors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'report':
            $date = $dataOutput->{"date-submitted"};
            //Obter a localização da primeira instituição
            $institution = isset($dataOutput->institutions) ?  $dataOutput->institutions->institution[0] : null;
            $location = isset($institution) ? $institution->{'institution-address'} : null;

            $formatedData = array(
                "title" => $dataOutput->{"report-title"},
                "volume" => $dataOutput->{"volume"},
                "pages" => $dataOutput->{"number-of-pages"},
                "institution" => implode(" and ", array_map(function ($institution) {
                    return $institution->{"institution-name"};
                }, isset($dataOutput->{"institutions"}->institution) ? $dataOutput->{"institutions"}->institution : array())),
                "year" => isset($dataOutput->{"date-submitted"}) ? $dataOutput->{"date-submitted"}->year : "",
                "author" => formatAuthors($dataOutput->{"authors"}),
                "url" => $dataOutput->url,
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'working-paper':
            $formatedData = array(
                "title" => $dataOutput->{"title"},
                "volume" => $dataOutput->volume,
                "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                "month" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->month : "",
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'manual':
            $formatedData = array(
                "title" => $dataOutput->{"title"},
                "series" => $dataOutput->{"series-title"},
                "volume" => $dataOutput->volume,
                "edition" => $dataOutput->edition,
                "pages" => $dataOutput->{"number-of-pages"},
                "year" => $dataOutput->{"publication-year"},
                "address" => isset($dataOutput->{"publication-location"}) ? ($dataOutput->{"publication-location"}->city . ", " . $dataOutput->{"publication-location"}->country->value) : "",
                "publisher" => $dataOutput->publisher,
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'online-resource':
            $date = $dataOutput->{"creation-date"};
            $formatedData = array(
                "title" => $dataOutput->{"title"},
                "year" => isset($dataOutput->{"creation-date"}) ? $dataOutput->{"creation-date"}->year : "",
                "month" => isset($dataOutput->{"creation-date"}) ? $dataOutput->{"creation-date"}->month : "",
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'test':
            $date = $dataOutput->{"date-first-used"};
            $formatedData = array(
                "title" => $dataOutput->{"title"},
                "year" => isset($dataOutput->{"date-first-used"}) ? $dataOutput->{"date-first-used"}->year : "",
                "month" => isset($dataOutput->{"date-first-used"}) ? $dataOutput->{"date-first-used"}->month : "",
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'website':
            $date = $dataOutput->{"launch-date"};
            $formatedData = array(
                "title" => $dataOutput->{"title"},
                "description" => $dataOutput->description,
                "year" => isset($dataOutput->{"launch-date"}) ? $dataOutput->{"launch-date"}->year : "",
                "month" => isset($dataOutput->{"launch-date"}) ? $dataOutput->{"launch-date"}->month : "",
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'conference-paper':
            $date = $dataOutput->{"conference-date"};
            $location = $dataOutput->{"conference-location"};
            $formatedData = array(
                "title" => $dataOutput->{"paper-title"},
                "booktitle" => addslashes($dataOutput->{"proceedings-title"}),
                "year" => isset($dataOutput->{"conference-date"}) ? $dataOutput->{"conference-date"}->year : "",
                "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                "publisher" => $dataOutput->{"proceedings-publisher"},
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            if (isset($dataOutput->{"conference-name"})) {
                $data["maintitle"] = $dataOutput->{"conference-name"};
            }
            break;
        case 'conference-abstract':
            $date = $dataOutput->{"publication-date"};
            $location = $dataOutput->{"conference-location"};
            $formatedData = array(
                "title" => $dataOutput->{"article-title"},
                "journal" => $dataOutput->{"conference-name"},
                "volume" => $dataOutput->{"volume"},
                "number" => $dataOutput->{"issue"},
                "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'conference-poster':
            $date = $dataOutput->{"conference-date"};
            $formatedData = array(
                "title" => $dataOutput->{"title"},
                "booktitle" => $dataOutput->{"conference-name"},
                "year" => isset($dataOutput->{"conference-date"}) ? $dataOutput->{"conference-date"}->year : "",
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'exhibition-catalogue':
            $formatedData = array(
                "title" => $dataOutput->{"title"},
                "pages" => $dataOutput->{"number-of-pages"},
                "year" => $dataOutput->{"publication-year"},
                "publisher" => addslashes($dataOutput->{"gallery-or-publisher"}),
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'preface-postface':
            $formatedData = array(
                "title" => addslashes($dataOutput->{"preface-postface-title"}),
                "booktitle" => addslashes($dataOutput->{"book-title"}),
                "volume" => $dataOutput->{"book-volume"},
                "edition" => $dataOutput->{"book-edition"},
                "pages" => generatePageRange($dataOutput, "preface-postface-page-range-from", "preface-postface-page-range-to"),
                "refereed" => ($dataOutput->refereed ? "true" : "false"),
                "year" => $dataOutput->{"publication-year"},
                "address" => isset($dataOutput->{"publication-location"}) ? $dataOutput->{"publication-location"}->city . ", " . $dataOutput->{"publication-location"}->country->value : "",
                "publisher" => addslashes($dataOutput->{"book-publisher"}),
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "editor" => formatAuthors($dataOutput->{"editors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        case 'preprint':
            $date = $dataOutput->{"date-submitted"};
            $location = $dataOutput->{"submission-location"};
            $formatedData = array(
                "title" => $dataOutput->title,
                "volume" => $dataOutput->volume,
                "journal" => $dataOutput->journal,
                "address" => isset($dataOutput->{"submission-location"}) ? $dataOutput->{"submission-location"}->city . ", " . $dataOutput->{"submission-location"}->country->value : "",
                "year" => isset($dataOutput->{"date-submitted"}) ? $dataOutput->{"date-submitted"}->year : "",
                "url" => $dataOutput->url,
                "author" => formatAuthors($dataOutput->{"authors"}),
                "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
            );
            break;
        default:
            return null;
    }
    if ($date == null && isset($dataOutput->{"publication-date"})) {
        $date = $dataOutput->{"publication-date"};
    }
    if ($location == null && isset($dataOutput->{"publication-location"})) {
        $location = $dataOutput->{"publication-location"};
    }
    if ($year == null && isset($dataOutput->{"publication-year"})) {
        $year = $dataOutput->{"publication-year"};
    }
    if (isset($date->year)) {
        $year = $date->year;
    }

    $fullDate = null;
    if (isset($year)) { //Apenas utilizar a data se o ano estiver defenido senão colocar null
        $month = isset($date->month) ? $date->month : '01'; // Por defeito é janeiro, se o mês não for fornecido
        $day = isset($date->day) ? $date->day : '01'; // Por defeito é o primeiro dia, se o dia não for fornecido         
        $fullDate = "$year-$month-$day";
    }

    $country = null;
    $city = null;
    if (isset($location)) {
        $country = isset($location->country) ? $location->country->value : null;
        $city = $location->city;
    }
    $result = [
        "data" => $fullDate,
        "dados" => $formatedData,
        "pais" =>  $country,
        "cidade" => $city,
        "tipo" => $typeOutput
    ];
    return  $result;
}

$sql = "SELECT nome, ciencia_id from investigadores WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
$id = $_GET["id"];

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$nome = $row["nome"];
$cienciaId = $row["ciencia_id"];

$sql = "SELECT p.idPublicacao, p.dados, p.data, p.pais, p.cidade, p.tipo
        FROM publicacoes p
        INNER JOIN publicacoes_investigadores pi ON p.idPublicacao = pi.publicacao
        WHERE pi.investigador = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
// Array que irá conter todas as publicações do investigador
$publications = array();
if ($result !== false) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Guardar a row como um array no array publicações com a key sendo o seu id
        $publications[$row["idPublicacao"]] = $row;
    }
}
mysqli_stmt_close($stmt);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["publicacao"]) && is_array($_POST["publicacao"])) {
        // Preparar comando SQL
        $sql = "UPDATE publicacoes SET visivel = ? WHERE idPublicacao = ?";
        $stmt = mysqli_prepare($conn, $sql);

        // Vincular parâmetros
        mysqli_stmt_bind_param($stmt, "is", $visibility, $checkboxId);

        //Obter as os ids de todas as publicações do investigador
        $existingIds = array_keys($publications);

        // Percorrer publicações existentes
        foreach ($existingIds as $checkboxId) {
            // Verificar se o idCheckbox está presente nos dados POST
            if (isset($_POST["publicacao"][$checkboxId])) {
                // Checkbox está selecionado, definir visivel como 1
                $visibility = 1;
            } else {
                // Checkbox não está selecionado, definir visivel como 0
                $visibility = 0;
            }
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    }


    if (isset($_POST['updateData'])) {
        //Login e password da API da Ciência Vitae definidos em ../config/credentials.php
        $loginAPI = USERCIENCIA;
        $passwordAPI = PASSWORDCIENCIA;

        $url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/" . $cienciaId . "/output?lang=User%20defined";
        $ch = curl_init();
        $headers = array(
            "Content-Type: application/json",
            "Accept: application/json",
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$loginAPI:$passwordAPI");
        $result_curl = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result_curl);
        if (isset($data->{"output"})) {

            $idPublicAPI = array();
            foreach ($data->{"output"} as $output) {
                //Se o output não for uma publicação, definida por P1, passa para a próxima iteração
                if (!(isset($output->{"output-category"}) && isset($output->{"output-category"}->{"code"}) && $output->{"output-category"}->{"code"} === "P1")) {
                    continue;
                }

                //Encontrar o campo que contém os dados da publicação
                foreach ($output as $field => $value) {
                    if ($field !== "output-category" && $field !== "output-type" && !is_null($value)) {
                        $typeOutput = $field;
                        $dataOutput = $value;
                        break;
                    }
                }
                //Se foi encontrado a publicação sem ocorrer nenhum erro
                if (!(isset($typeOutput) && isset($dataOutput))) {
                    echo "ERRO: Não foram encontrados os dados da publicação";
                } else {
                    //Encontrar o identificador da publicação , especificamente o source-work-id'
                    $publicId = '';
                    if (isset($dataOutput->identifiers->identifier)) {
                        foreach ($dataOutput->identifiers->identifier as $identifier) {
                            if (isset($identifier->{'identifier-type'}->code) && $identifier->{'identifier-type'}->code === 'source-work-id') {
                                $publicId = $identifier->identifier;
                                break;
                            }
                        }
                    }
                    $result = getPublicationInfo($dataOutput, $typeOutput);
                    if (isset($result)) {
                        $result['dados'] = generatePublicationEntry($typeOutput, $publicId, $result['dados']);
                        $result['idPublicacao'] = $publicId;
                        $idPublicAPI[] = $publicId;

                        // Se não existe a publicação associada ao investigador insere
                        if (!isset($publications[$publicId])) {
                            //Insere a publicação e quase exista atualiza-a
                            $queryInsert = "INSERT INTO publicacoes (";
                            $queryInsert .= implode(", ", array_keys($result));
                            $queryInsert .= ") VALUES (";
                            $queryInsert .= implode(", ", array_fill(0, count($result), "?"));
                            $queryInsert .= ") ON DUPLICATE KEY UPDATE ";
                            $queryInsert .= implode(", ", array_map(function ($field) {
                                return "$field = VALUES($field)";
                            }, array_keys($result)));

                            $stmtInsert = mysqli_prepare($conn, $queryInsert);

                            $types = str_repeat('s', count($result));
                            mysqli_stmt_bind_param($stmtInsert, $types, ...array_values($result));

                            //Caso tenha inserido com sucesso a publicação
                            if (mysqli_stmt_execute($stmtInsert)) {
                                mysqli_stmt_close($stmtInsert);

                                //Inserir a relação do investigador e esta publicação
                                $queryInsertInves = "INSERT INTO publicacoes_investigadores (publicacao, investigador) VALUES (?, ?)";
                                $stmtInsertInvest = mysqli_prepare($conn, $queryInsertInves);

                                mysqli_stmt_bind_param($stmtInsertInvest, 'si', $publicId, $id);

                                if (!mysqli_stmt_execute($stmtInsertInvest)) {
                                    echo "Erro ao inserir registo " . $publicId . " em publicacoes_investigadores: " . mysqli_error($conn) . "<br>";
                                }

                                mysqli_stmt_close($stmtInsertInvest);
                            } else {
                                echo "Erro ao inserir registo " . $publicId . " em publicações: " . mysqli_error($conn) . "<br>";
                            }
                        } else if ($publications[$publicId] != $result) {


                            // Supondo que $result é um array associativo contendo seus dados
                            $updateQuery = "UPDATE publicacoes SET ";
                            $updateQuery .= implode(" = ?, ", array_keys($result)) . " = ?";
                            $updateQuery .= " WHERE idPublicacao = ?"; // Assuming idPublicacao is the column name

                            $stmt = mysqli_prepare($conn, $updateQuery);

                            // Supondo que $result contém seus valores na mesma ordem das chaves
                            $bindValues = array_values($result);
                            // Definir tipos de parâmetro para o bind (todos os strings seguidos de uma string)
                            $bindTypes = str_repeat("s", count($bindValues)) . "s";
                            $bindValues[] = $publicId;

                            // Criar um array com referências para os valores a serem vinculados
                            $bindParams = array();
                            $bindParams[] = &$bindTypes;
                            foreach ($bindValues as $key => $value) {
                                $bindParams[] = &$bindValues[$key];
                            }

                            mysqli_stmt_bind_param($stmt, $bindTypes, ...$bindValues);
                            if (!mysqli_stmt_execute($stmt)) {
                                echo "Erro ao atualizar registro " . $publicId . " em publicacoes " . mysqli_error($conn) . "<br>";
                            }
                            mysqli_stmt_close($stmt);
                        }
                        unset($result);
                        //print_r($result);
                    } else {
                        echo "$typeOutput não é um tipo de publicação reconhecido";
                    }
                }
            }
        }

        // Identificar IDs do array com todos os IDS actuais da API e os da BD
        $missingKeys  = array_diff(array_keys($publications), $idPublicAPI);
        $idsToDelete = array_intersect($missingKeys, array_keys($publications));

        // Se houver IDs para excluir, realizar uma operação de eliminar
        if (!empty($idsToDelete)) {
            // Criar uma lista separada por vírgulas de espaços reservados, os ?, para os IDs 
            $placeholders = str_repeat('?,', count($idsToDelete) - 1) . '?';

            // Preparar o comando de DELETE
            $deleteQuery = "DELETE FROM publicacoes_investigadores WHERE publicacao IN ($placeholders) and investigador = $id";
            $deleteStatement = mysqli_prepare($conn, $deleteQuery);

            if ($deleteStatement) {
                // Vincular parâmetros e executar o comando
                $types = str_repeat('s', count($idsToDelete));
                mysqli_stmt_bind_param($deleteStatement, $types, ...$idsToDelete);

                if (mysqli_stmt_execute($deleteStatement)) {
                    echo "Registos eliminados com sucesso.<br>";
                } else {
                    echo "Erro ao eliminar registos: " . mysqli_error($conn) . "<br>";
                }

                mysqli_stmt_close($deleteStatement);
            } else {
                echo "Erro ao preparar o comando de eliminação: " . mysqli_error($conn) . "<br>";
            }
        }

        // Correr o comnado que eliminar registos da tabela publicacoes que não têm entrada correspondente em publicacoes_investigadores
        $deleteQuery = "DELETE FROM publicacoes WHERE idPublicacao NOT IN (SELECT publicacao FROM publicacoes_investigadores)";
        $deleteResult = mysqli_query($conn, $deleteQuery);
        if ($deleteResult) {
            $numRowsAffected = mysqli_affected_rows($conn);
            if ($numRowsAffected > 0) {
                echo "Registos eliminados com sucesso na tabela publicacoes. Foram eliminados $numRowsAffected registos.<br>";
            }
        } else {
            echo "Erro ao eliminar registos da tabela publicacoes: " . mysqli_error($conn) . "<br>";
        }
    }
}

// Consulta para buscar todas as publicações do investigador
$sql = "SELECT p.idPublicacao, p.dados, p.visivel 
        FROM publicacoes p
        INNER JOIN publicacoes_investigadores pi ON p.idPublicacao = pi.publicacao
        WHERE pi.investigador = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Preencher o array $publicacoesData diretamente com os resultados da consulta
$publicacoesData = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fechar a conexão com o banco de dados
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>




<style>
    .container {
        max-width: 550px;
    }

    label {
        overflow: auto;
        max-width: 100%;
    }


    .has-error label,
    .has-error input,
    .has-error textarea {
        color: red;
        border-color: red;
    }

    .list-unstyled li {
        font-size: 13px;
        padding: 4px 0 0;
        color: red;
    }

    textarea {
        min-height: 100px;
    }
</style>


<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</link>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<script src="../assets/js/citation-js-0.6.8.js"></script>

<div class="container-xl mt-5">
    <div class="card">
        <h5 class="card-header text-center">Selecionar Publicações do Investigador <?php echo $nome ?></h5>
        <div class="card-body">

            <!-- Botão de Atualizar Dados com a API -->
            <form id="updateForm" method="post">
                <button type="submit" name="updateData" class="btn btn-warning btn-block">Atualizar Dados</button>
            </form>

            <form method="post">
                <div class="mb-3" id="publicacoes">

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Gravar</button>
                </div>

                <div class="form-group">
                    <button type="button" onclick="window.location.href = 'index.php'" class="btn btn-danger btn-block">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    const Cite = require('citation-js');

    function getAPA(data) {
        // Lógica de processamento do "citacion.js"
        return new Cite(data).format('bibliography', {
            format: 'html',
            template: 'apa',
            lang: 'en-US'
        });;
    }

    var publicacoesData = <?php echo json_encode($publicacoesData); ?>;

    var publicacoesDiv = document.getElementById('publicacoes');

    for (var i = 0; i < publicacoesData.length; i++) {
        var publicacao = publicacoesData[i];

        // Criar um contentor div para cada publicação
        var container = document.createElement('div');
        container.classList.add('form-check', 'mb-3');

        // Criar o input checkbox
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'publicacao[' + publicacao.idPublicacao + ']';
        checkbox.value = publicacao.idPublicacao;
        checkbox.checked = publicacao.visivel;
        checkbox.classList.add('form-check-input');

        // Criar um div para o conteudo
        var contentDiv = document.createElement('div');
        contentDiv.innerHTML = getAPA(publicacao.dados);
        contentDiv.classList.add('form-check-label');

        // Append checkbox and content to container
        container.appendChild(checkbox);
        container.appendChild(contentDiv);

        publicacoesDiv.appendChild(container);
    }

    window.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        let lastChecked;

        function handleCheck(event) {
            if (event.shiftKey) {
                let start = Array.from(checkboxes).indexOf(this);
                let end = Array.from(checkboxes).indexOf(lastChecked);
                if (start > end) {
                    [start, end] = [end, start];
                }
                checkboxes.forEach((checkbox, index) => {
                    if (index >= start && index <= end) {
                        checkbox.checked = this.checked;
                    }
                });
            }

            lastChecked = this;
        }

        checkboxes.forEach(checkbox => checkbox.addEventListener('click', handleCheck));
    });
</script>