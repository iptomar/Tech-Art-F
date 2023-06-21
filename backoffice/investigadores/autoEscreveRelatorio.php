<?php

require '../../libraries/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Psr\Http\Message\ResponseInterface;

require "../verifica.php";
require "../config/basedados.php";

//verfica o tipo de sessão com base no utilizador
if ($_SESSION["autenticado"] != 'administrador' && $_SESSION["autenticado"] != $_GET["id"]) {
    header("Location: index.php");
}

//credenciais para acesso ao swagger UI da API da cienciaVitae
$login = 'IPT_ADMIN';
$password = 'U6-km(jD8a68r';

//iniciar handler cURL
$ch = curl_init();
$headers = array(
    "Content-Type: application/json",
    "Accept: application/json",
);

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //adicionar cabecalhos
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //retornar transferencia ativada
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); //autenticacao cURL basica ativada
curl_setopt($ch, CURLOPT_USERPWD, "$login:$password"); //user e password para o swagger UI

// 1. Informações

//consulta a realizar
$sql = "SELECT * FROM investigadores WHERE id = ?";

$id = $_GET["id"];
$stmt = mysqli_prepare($conn, $sql); //preparar conexao
mysqli_stmt_bind_param($stmt, 'i', $id); //agregar parametro id como inteiro
mysqli_stmt_execute($stmt); //executar consulta mysqli
$result = mysqli_stmt_get_result($stmt); //obter resultado da consulta
$rows = mysqli_fetch_assoc($result); //obter colunas como um array
$ciencia_id = $rows["ciencia_id"]; //ciencia id
$orcid = $rows["orcid"]; //orcid

//nomes dos relatorios
$relatorioModelo = "./relatorio.xlsx";
$novoRelatorio = "./relatorio_anual_" . $ciencia_id . ".xlsx";
$aux = "./auxiliar.xlsx";

//se nao exitir, criar ficheiro do novo relatorio
if(!file_exists($novoRelatorio)){
    $handle = @fopen($novoRelatorio, "w+");
    fclose($handle);
    if(!copy($relatorioModelo, $novoRelatorio)){
        echo "Não foi possível copiar $relatorioModelo...</br>";
    }
}

$url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/" . $ciencia_id . "/person-info?lang=User%20defined";

//adiconar url ao handler cURL
curl_setopt($ch, CURLOPT_URL, $url);

$result_curl = curl_exec($ch); //executar cURL e armazenar resultado
curl_close($ch); //fechar handler
$data = json_decode($result_curl); //descodificar JSON da resposta

$nome = $data->{"full-name"};

echo "$nome, $ciencia_id, $orcid</br>";

//::::::::::::ESCREVER NO EXCEL::::::::::::

//leitor de folhas de calculo para o novo relatorio
$reader = IOFactory::createReader("Xlsx");
$spreadsheet = $reader->load($novoRelatorio);

//escritor de folhas de calculo para o novo relatorio
$writer = IOFactory::createWriter($spreadsheet, "Xlsx");

$spreadsheet->setActiveSheetIndex(0);
$spreadsheet->getActiveSheet()->getCell('B20')->setValue($nome);
$spreadsheet->getActiveSheet()->getCell('B22')->setValue($ciencia_id);
$spreadsheet->getActiveSheet()->getCell('B23')->setValue($orcid);

// 2. Projetos de investigação

//consluta a realizar
$sql = "SELECT * FROM projetos AS p,investigadores_projetos AS ip WHERE ip.investigadores_id = ? AND p.id = ip.projetos_id";

$stmt = mysqli_prepare($conn, $sql); //preparar conexao
mysqli_stmt_bind_param($stmt, 'i', $id); //agregar parametro id como inteiro
mysqli_stmt_execute($stmt); //executar consulta mysqli
$result = mysqli_stmt_get_result($stmt); //obter resultado da consulta
$rows = mysqli_fetch_all($result); //obter colunas como um array

//echo json_encode($rows);

//::::::::::::ESCREVER NO EXCEL::::::::::::

//Letra e numero de comeco
$startChar = "C";
$startNumber = 14;

echo chr(ord($startChar)+1);

$spreadsheet->setActiveSheetIndex(1);

foreach($rows as $row){
    $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($row[1]);    //1 - Indice da coluna com o acronimo
    $startNumber++;
}


// 3. Publicações



// 4. Enventos e conferências



// 5. Patentes



// 6. Trabalho de orientação



// 7. Prémios e distinções



// 8. Outras atividades



//::::::::::::GUARDAR RELATORIO::::::::::::
//header('Content-Type: application/vnd.ms-excel');
//header('Content-Disposition: attachment;filename="'.$novoRelatorio.'"');
//header('Cache-Control: max-age=0');
$writer->save($novoRelatorio);


?>

<?php

/*if ($result->num_rows > 0) {
    $a = array();
    while ($row = $result->fetch_assoc()) {

        $variable = $row["ciencia_id"];
    

        //echo json_encode($data);

        //$name = $row["nome"]; 

        if (isset($data->{"output"}))

            foreach ($data->{"output"} as $key) {
                $person = $key->{""};

                if (isset($book)) {

                    array_push($a, $person);
                }
            }

        echo $a[0];
    }

    function cb($x, $y)
    {
        return $x->{'publication-year'} <= $y->{'publication-year'};
    }
    usort($a, 'cb');
    $ano = '';
    foreach ($a as $book) {


        echo $name.", ";
        echo "<p>";
        echo str_replace(";", " & ", $book->{"authors"}->{"citation"});

        echo ". (" . $book->{'publication-year'} . "). ";

        echo $book->{"title"};

        if (isset($book->{"volume"})) {
            echo ", " . $book->{"volume"};
        }

        if (isset($book->{"number-of-pages"})) {
            echo ", " . $book->{"number-of-pages"};
        }
        echo "</p>";
    }
}*/

?>