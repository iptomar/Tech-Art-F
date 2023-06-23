<?php

include '../../libraries/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require "../verifica.php";
require "../config/basedados.php";

//verfica o tipo de sessão com base no utilizador
if ($_SESSION["autenticado"] != 'administrador' && $_SESSION["autenticado"] != $_GET["id"]) {
    header("Location: index.php");
}

//credenciais para acesso ao swagger UI da API da cienciaVitae
$login = 'IPT_ADMIN';
$password = 'U6-km(jD8a68r';

//iniciar sessao cURL
$ch = curl_init();
$headers = array(
    "Content-Type: application/json",
    "Accept: application/json",
);

curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //adicionar cabecalhos
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //retornar transferencia ativada
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

//nomes do relatorio modelo
$relatorioModelo = "./relatorio.xlsx";
$aux = "./auxiliar.xlsx";

//se nao exitir, criar ficheiro do novo relatorio
/*if(!file_exists($novoRelatorio)){
    $handle = @fopen($novoRelatorio, "w+");
    fclose($handle);
    if(!copy($relatorioModelo, $novoRelatorio)){
        echo "Não foi possível copiar $relatorioModelo...</br>";
    }
}*/

$url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/" . $ciencia_id . "/person-info?lang=User%20defined";

//adicionar url ao handler cURL
curl_setopt($ch, CURLOPT_URL, $url);

$result_curl = curl_exec($ch); //executar cURL e armazenar resultado

echo curl_error($ch);

curl_close($ch); //fechar handler
$data = json_decode($result_curl); //descodificar JSON da resposta

//nome completo
$nome = $data->{"full-name"};
$nomeArray = explode(" ", $nome);

//array de carateres nao reconhecidos
$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

//ultimo nome
$lastName = $nomeArray[count($nomeArray)-1];
$lastName = strtr($lastName, $unwanted_array);

//primeiro nome
$firstName = $nomeArray[0];
$firstName = strtr($firstName, $unwanted_array);

//ano
$year = 2023;

//nome do novo relatorio
$novoRelatorio = "./".strtoupper($lastName)."_".strtolower($firstName)."_".$year.".xlsx";

echo $novoRelatorio."</br>";

echo "$nome</br>";

//::::::::::::ESCREVER NO EXCEL::::::::::::

//tipo de ficheiro
$inputFileType = PHPExcel_IOFactory::identify($relatorioModelo);

//carregar o  relatorio modelo
$reader = PHPExcel_IOFactory::createReader($inputFileType);
$spreadsheet = $reader->load($relatorioModelo);

//escritor de folhas de calculo para o relatorio modelo
$writer = PHPExcel_IOFactory::createWriter($spreadsheet, $inputFileType);

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