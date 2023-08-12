<script src="../assets/js/citation-js-0.6.8.js"></script>
<script>
    const Cite = require('citation-js')
</script>
<?php
require "../verifica.php";
require "../config/basedados.php";
require_once "../config/credentials.php";

//Se o utilizador não é um administrador não tem permissão para alterar as publicações
if ($_SESSION["autenticado"] != 'administrador') {
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
        $formattedFields[] = "  $fieldName = {" . addslashes($fieldValue) . "}";
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

//Login e password da API da Ciência Vitae definidos em ../config/credentials.php
$loginAPI = USERCIENCIA;
$passwordAPI = PASSWORDCIENCIA;

$cienciaId = $_GET["ciencia_id"];
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

//Array que vai conter as publicações do investigador da API
$publicacoesAPI = array();

if (isset($data->{"output"})) {

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
        if (isset($typeOutput) && isset($dataOutput)) {
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
            echo "<br><p><b>$typeOutput - $publicId </b><p>";

            //Lidar com os dados dependendo do tipo de publicação
            switch ($typeOutput) {
                case 'journal-article':
                    $data = [
                        "title" => $dataOutput->{"article-title"},
                        "journal" => $dataOutput->journal,
                        "volume" => $dataOutput->volume,
                        "number" => $dataOutput->issue,
                        "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                        "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                        "month" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->month : "",
                        "address" => isset($dataOutput->{"publication-location"}) ? $dataOutput->{"publication-location"}->city . ", " . $dataOutput->{"publication-location"}->country->value : "",
                        "url" => $dataOutput->{"url"},
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    ];

                    break;
                case 'journal-issue':
                    $data = [
                        "title" => addslashes($dataOutput->{"issue-title"}),
                        "journal" => addslashes($dataOutput->journal),
                        "volume" => $dataOutput->volume,
                        "number" => $dataOutput->{"issue-number"},
                        "pages" => $dataOutput->{"number-of-pages"},
                        "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                        "month" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->month : "",
                        "editor" => formatAuthors($dataOutput->{"editors"}),
                        "address" => isset($dataOutput->{"publication-location"}) ? $dataOutput->{"publication-location"}->city . ", " . $dataOutput->{"publication-location"}->country->value : "",
                        "url" => $dataOutput->{"url"},
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    ];
                    if (isset($dataOutput->{"publication-date"}->day)) {
                        $data["date"] = $dataOutput->{"publication-date"}->year  . "-" . $dataOutput->{"publication-date"}->month . "-" . $dataOutput->{"publication-date"}->day;
                    }
                    break;
                case 'book':
                    $data = [
                        "title" => $dataOutput->{"title"},
                        "volume" => $dataOutput->volume,
                        "edition" => $dataOutput->edition,
                        "pages" => $dataOutput->{"number-of-pages"},
                        "year" => $dataOutput->{"publication-year"},
                        "address" => isset($dataOutput->{"publication-location"}) ? $dataOutput->{"publication-location"}->city . ", " . $dataOutput->{"publication-location"}->country->value : "",
                        "publisher" => addslashes($dataOutput->{"publisher"}),
                        "url" => $dataOutput->{"url"},
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "editor" => formatAuthors($dataOutput->{"editors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    ];
                    break;
                case 'edited-book':
                    $data = [
                        "title" => $dataOutput->{"title"},
                        "volume" => $dataOutput->volume,
                        "edition" => $dataOutput->edition,
                        "pages" => $dataOutput->{"number-of-pages"},
                        "year" => $dataOutput->{"publication-year"},
                        "address" => isset($dataOutput->{"publication-location"}) ? $dataOutput->{"publication-location"}->city . ", " . $dataOutput->{"publication-location"}->country->value : "",
                        "publisher" => addslashes(addslashes($dataOutput->{"publisher"})),
                        "url" => addslashes($dataOutput->url),
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "editor" => formatAuthors($dataOutput->{"editors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    ];
                    break;
                case 'book-chapter':
                    $data = [
                        "title" => addslashes($dataOutput->{"chapter-title"}),
                        "booktitle" => addslashes($dataOutput->{"book-title"}),
                        "volume" => $dataOutput->{"book-volume"},
                        "edition" => $dataOutput->{"book-edition"},
                        "pages" => generatePageRange($dataOutput, "chapter-page-range-from", "chapter-page-range-to"),
                        "address" => isset($dataOutput->{"publication-location"}) ? $dataOutput->{"publication-location"}->city . ", " . $dataOutput->{"publication-location"}->country->value : "",
                        "year" => $dataOutput->{"publication-year"},
                        "publisher" => addslashes($dataOutput->{"book-publisher"}),
                        "url" => $dataOutput->url,
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "editor" => formatAuthors($dataOutput->{"editors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    ];
                    break;
                case 'book-review':
                    $data = [
                        "title" => addslashes($dataOutput->{"review-title"}),
                        "journal" => addslashes($dataOutput->{"published-in"}),
                        "volume" => $dataOutput->{"review-volume"},
                        "number" => $dataOutput->{"review-issue"},
                        "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                        "year" => isset($dataOutput->{"date-of-review-publication"}) ? $dataOutput->{"date-of-review-publication"}->year : "",
                        "month" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->month : "",
                        "publisher" => $dataOutput->{"review-publisher"},
                        "url" => $dataOutput->url,
                        "booktitle" => addslashes($dataOutput->{"book-title"}),
                        "bookaddress" => isset($dataOutput->{"book-publication-location"}->city) ? $dataOutput->{"book-publication-location"}->city . ", " . $dataOutput->{"book-publication-location"}->country->value : "",
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    ];
                    break;
                case 'translation':
                    $data = array(
                        "title" => $dataOutput->{"title"},
                        "booktitle" => addslashes($dataOutput->{"series-title"}),
                        "volume" => $dataOutput->{"volume"},
                        "edition" => $dataOutput->{"edition"},
                        "pages" => $dataOutput->{"number-of-pages"},
                        "year" => $dataOutput->{"publication-year"},
                        "publisher" => $dataOutput->{"publisher"},
                        "address" => isset($dataOutput->{"publication-location"}) ? $dataOutput->{"publication-location"}->city . ", " . $dataOutput->{"publication-location"}->country->value : "",
                        "url" => $dataOutput->url,
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'dissertation':
                    $data = array(
                        "title" => $dataOutput->{"title"},
                        "school" => implode(' and ', array_map(function ($institution) {
                            return addslashes($institution->{"institution-name"});
                        }, isset($dataOutput->institutions->institution) ? $dataOutput->institutions->institution : array())),
                        "year" => isset($dataOutput->{"completion-date"}) ? $dataOutput->{"completion-date"}->year : "",
                        "month" => isset($dataOutput->{"completion-date"}) ? $dataOutput->{"completion-date"}->month : "",
                        "type" => isset($dataOutput->{"degree-type"}) ? $dataOutput->{"degree-type"}->value : "",
                        "supervisor" => implode(' and ', array_map(function ($supervisor) {
                            return addslashes($supervisor->{"supervisor-name"});
                        }, isset($dataOutput->supervisors->supervisor) ? $dataOutput->supervisors->supervisor : array())),
                        "url" => $dataOutput->url,
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'newspapper-article':
                    $data = array(
                        "title" => $dataOutput->{"article-title"},
                        "journal" => $dataOutput->{"newspaper"},
                        "volume" => $dataOutput->{"volume"},
                        "number" => $dataOutput->{"edition"},
                        "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                        "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                        "month" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->month : "",
                        "address" => isset($dataOutput->{"publication-location"}) ? $dataOutput->{"publication-location"}->city . ", " . $dataOutput->{"publication-location"}->country->value : "",
                        "url" => $dataOutput->url,
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'newsletter-article':
                    $data = array(
                        "title" => $dataOutput->{"article-title"},
                        "journal" => $dataOutput->{"newsletter"},
                        "volume" => $dataOutput->{"volume"},
                        "number" => $dataOutput->{"issue"},
                        "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                        "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                        "month" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->month : "",
                        "address" => isset($dataOutput->{"publication-location"}->city) ? $dataOutput->{"publication-location"}->city : "",
                        "url" => $dataOutput->url,
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'encyclopedia-entry':
                    $data = array(
                        "title" => $dataOutput->{"entry-title"},
                        "booktitle" => addslashes($dataOutput->{"encyclopedia-title"}),
                        "volume" => $dataOutput->{"volume"},
                        "number" => $dataOutput->{"edition"},
                        "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                        "year" => $dataOutput->{"publication-year"},
                        "publisher" => $dataOutput->{"publisher"},
                        "address" => isset($dataOutput->{"publication-location"}->city) ? $dataOutput->{"publication-location"}->city : "",
                        "url" => $dataOutput->url,
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "editor" => formatAuthors($dataOutput->{"editors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'magazine-article':
                    $data = array(
                        "title" => $dataOutput->{"article-title"},
                        "journal" => $dataOutput->{"magazine"},
                        "volume" => $dataOutput->{"volume"},
                        "number" => $dataOutput->{"issue"},
                        "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                        "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                        "month" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->month : "",
                        "address" => isset($dataOutput->{"publication-location"}->city) ? $dataOutput->{"publication-location"}->city : "",
                        "url" => $dataOutput->url,
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "editor" => formatAuthors($dataOutput->{"editors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'dictionary-entry':
                    $data = array(
                        "title" => $dataOutput->{"entry-title"},
                        "booktitle" => $dataOutput->{"dictionary-title"},
                        "volume" => $dataOutput->{"volume"},
                        "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                        "year" => $dataOutput->{"publication-year"},
                        "location" => isset($dataOutput->{"publication-location"}->city) ? $dataOutput->{"publication-location"}->city : "",
                        "url" => $dataOutput->url,
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "editor" => formatAuthors($dataOutput->{"editors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'report':
                    $data = array(
                        "title" => $dataOutput->{"report-title"},
                        "volume" => $dataOutput->{"volume"},
                        "pages" => $dataOutput->{"number-of-pages"},
                        "institution" => implode(" and ", array_map(function ($institution) {
                            return $institution->{"institution-name"};
                        }, isset($dataOutput->{"institutions"}->institution) ? $dataOutput->{"institutions"}->institution : array())),
                        "year" => isset($dataOutput->{"date-submitted"}) ? $dataOutput->{"date-submitted"}->year : "",
                        "month" => isset($dataOutput->{"date-submitted"}) ? $dataOutput->{"date-submitted"}->month : "",
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "url" => $dataOutput->url,
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'working-paper':
                    $data = array(
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
                    $data = array(
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
                    $data = array(
                        "title" => $dataOutput->{"title"},
                        "year" => isset($dataOutput->{"creation-date"}) ? $dataOutput->{"creation-date"}->year : "",
                        "month" => isset($dataOutput->{"creation-date"}) ? $dataOutput->{"creation-date"}->month : "",
                        "url" => $dataOutput->url,
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'test':
                    $data = array(
                        "title" => $dataOutput->{"title"},
                        "year" => isset($dataOutput->{"date-first-used"}) ? $dataOutput->{"date-first-used"}->year : "",
                        "month" => isset($dataOutput->{"date-first-used"}) ? $dataOutput->{"date-first-used"}->month : "",
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'website':
                    $data = array(
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
                    $data = array(
                        "title" => $dataOutput->{"paper-title"},
                        "booktitle" => addslashes($dataOutput->{"proceedings-title"}),
                        "year" => isset($dataOutput->{"conference-date"}) ? $dataOutput->{"conference-date"}->year : "",
                        "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                        "address" => isset($dataOutput->{"conference-location"}) ? addslashes($dataOutput->{"conference-location"}->city) . ", " . $dataOutput->{"conference-location"}->country->value : "",
                        "publisher" => $dataOutput->{"proceedings-publisher"},
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    if (isset($dataOutput->{"conference-name"})) {
                        $data["maintitle"] = $dataOutput->{"conference-name"};
                    }
                    break;
                case 'conference-abstract':
                    $data = array(
                        "title" => $dataOutput->{"article-title"},
                        "journal" => $dataOutput->{"conference-name"},
                        "address" => isset($dataOutput->{"conference-location"}) ? $dataOutput->{"conference-location"}->city . ", " . $dataOutput->{"conference-location"}->country->value : "",
                        "volume" => $dataOutput->{"volume"},
                        "number" => $dataOutput->{"issue"},
                        "pages" => generatePageRange($dataOutput, "page-range-from", "page-range-to"),
                        "year" => isset($dataOutput->{"publication-date"}) ? $dataOutput->{"publication-date"}->year : "",
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'conference-poster':
                    $data = array(
                        "title" => $dataOutput->{"title"},
                        "booktitle" => $dataOutput->{"conference-name"},
                        "year" => isset($dataOutput->{"conference-date"}) ? $dataOutput->{"conference-date"}->year : "",
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'exhibition-catalogue':
                    $data = array(
                        "title" => $dataOutput->{"title"},
                        "pages" => $dataOutput->{"number-of-pages"},
                        "year" => $dataOutput->{"publication-year"},
                        "publisher" => addslashes($dataOutput->{"gallery-or-publisher"}),
                        "author" => formatAuthors($dataOutput->{"authors"}),
                        "keywords" => implode(', ', isset($dataOutput->{"keywords"}->{"keyword"}) ? $dataOutput->{"keywords"}->{"keyword"} : array())
                    );
                    break;
                case 'preface-postface':
                    $data = array(
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
                    $data = array(
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
                    unset($data);
                    break;
            }
            if (isset($data)) {
                $entryPublication = generatePublicationEntry($typeOutput, $publicId, $data);
                $id = str_replace('-', '_', $publicId);
                echo  "
                <div id='$id'>
                <p>";
                echo "<pre>";
                print_r($dataOutput);
                echo "</pre>";


                echo "<br>$entryPublication </p>
                </div>
                <br>
                <script>
                const apaCitations_$id = new Cite('$entryPublication').format('bibliography', {
                    format: 'html',
                    template: 'apa',
                    lang: 'en-US'
                })
        
                const newParagraph_$id = document.createElement('div');
                const outputDiv_$id = document.getElementById('$id');
                outputDiv_$id.appendChild(newParagraph_$id);
                newParagraph_$id.innerHTML = apaCitations_$id;

                </script>
                ";
            } else {
                echo "$typeOutput não é um tipo de publicação reconhecido";
            }
        } else {
            echo "NO DATA";
        }
    }
} else {
    "NO OUPUT";
}