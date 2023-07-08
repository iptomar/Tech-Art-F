<?php

include "./locaisPortugueses.php";
include '../../libraries/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require "../verifica.php";
require "../config/basedados.php";

//verfica o tipo de sessão com base no utilizador
if ($_SESSION["autenticado"] != 'administrador' && $_SESSION["autenticado"] != $_GET["id"]) {
    header("Location: index.php");
}

//ano
if($_SESSION["anoRelatorio"] != ""){
	$year = $_SESSION["anoRelatorio"];
}else{
    $year = date("Y");
}


//$year = 2011;

//opcoes do select de cada pagina folha de calculo
//(apenas a contar da segunda pagina)
$activePageSelectOptions = array();


//array de carateres nao reconhecidos
$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

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

$url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/" . $ciencia_id . "/person-info?lang=User%20defined";

//adicionar url ao handler cURL
curl_setopt($ch, CURLOPT_URL, $url);

//echo curl_error($ch); //mostrar erros do cURL

$result_curl = curl_exec($ch); //executar cURL e armazenar resultado

curl_close($ch); //fechar handler
$data = json_decode($result_curl); //descodificar JSON da resposta

//nome completo
$nome = $data->{"full-name"};
$nomeArray = explode(" ", $nome);

//ultimo nome
$lastName = $nomeArray[count($nomeArray)-1];
$lastName = strtr($lastName, $unwanted_array);

//primeiro nome
$firstName = $nomeArray[0];
$firstName = strtr($firstName, $unwanted_array);

//nome do novo relatorio
$novoRelatorio = "./".strtoupper($lastName)."_".strtolower($firstName)."_".$year.".xlsx";

//echo $novoRelatorio."</br>";

//echo "$nome</br>";

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

//echo chr(ord($startChar)+1);

$spreadsheet->setActiveSheetIndex(1);

foreach($rows as $row){

    //letra de comeco
    $startChar = "C";
    $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($row[1]);    //1 - Indice da coluna com o acronimo
    $startNumber++;
}


// 3. Publicações

//categorias de publicacao

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

$url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/" . $ciencia_id . "/output?lang=User%20defined";

//adicionar url ao handler cURL
curl_setopt($ch, CURLOPT_URL, $url);

//mostrar erros
//echo curl_error($ch);

//resultado
$result_curl = curl_exec($ch); //executar cURL e armazenar resultado

curl_close($ch); //fechar handler
$data = json_decode($result_curl); //descodificar JSON da resposta

//echo json_encode($data);

//::::::::::::ESCREVER NO EXCEL::::::::::::

//tipo de publicacao
$outputType ="";

//localização de publicacao
$outputLocation;

//atributo associado ao tipo de publicacao
$outputAttr = (object)[];

//categoria na folha de calculo
$excelOutCategory = "";

//Letra e numero de comeco
$startChar = "A";
$startNumber = 12;

//echo chr(ord($startChar)+1);

$spreadsheet->setActiveSheetIndex(2);

//opcoes da lista pendente
for($opc = 1; $opc <= 22; $opc++){

    $activePageSelectOptions[$opc-1] = $spreadsheet->getActiveSheet()->getCell("J".$opc)->getFormattedValue();

}

//echo implode("</br>",$activePageSelectOptions);

//echo json_encode($data);

foreach($data->{"output"} as $row){

    //letra de comeco
    $startChar = "A";

    //iterador
    $i = 0;

    //::::::categoria de publicacao::::::
    $outputType = $row->{"output-type"}->{"value"};

    //encontrar a propriedade nao nula correspondente a categoria de publicacao
    foreach($row as $attr){
        if($attr != null && $i >= 2){
            $outputAttr = $attr;
            break;
        }
        $i++;
    }

    if(@$outputAttr->{"publication-year"} == $year."" || @$outputAttr->{"publication-date"}->{"year"} == $year.""){
        //local de publicacao
        $outputLocation = @$outputAttr->{"publication-location"}->{"country"}->{"value"};

        if (is_null($outputLocation)) {
            $outputLocation = @$outputAttr->{"publication-location"}->{"city"};
            //echo $outputLocation." here</br>";
            if ($outputLocation != "") {
                for ($i = 0; $i < count($localizacoesPortuguesas); $i++) {
                    if ($outputLocation == $localizacoesPortuguesas[$i]) {
                        $outputLocation = "Portugal";
                        break;
                    } else if ($i + 1 == count($localizacoesPortuguesas)) {
                        $outputLocation = "Estrangeiro";
                    }
                }
            } else {
                $outputLocation = "Local Desconhecido";
            }
        } else {
            if ($outputLocation != "Portugal") {
                $outputLocation = "Estrangeiro";
            }
        }

        //!!!!!!!!!!! SUBSTITUIR POR SWITCH PARA AS OPCOES POSSIVEIS !!!!!!!!!
        $excelOutCategory = $outputType . ": " . $outputLocation;

        switch($excelOutCategory){
            case "Livro: Portugal":
                $excelOutCategory = $activePageSelectOptions[0];
                break;
            case "Livro: Estrangeiro":
                $excelOutCategory = $activePageSelectOptions[1];
                break;
            case "Capítulo de livro: Portugal":
                $excelOutCategory = $activePageSelectOptions[4];
                break;
            case "Capítulo de livro: Estrangeiro":
                $excelOutCategory = $activePageSelectOptions[6];
                break;
            case "Artigo em revista: Portugal":
                $excelOutCategory = $activePageSelectOptions[8];
                break;
            case "Artigo em revista: Estrangeiro":
                $excelOutCategory = $activePageSelectOptions[10];
                break;
        }

        $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($excelOutCategory);

        //::::::referencia bibliografica::::::

        //caracter de comeco
        $startChar = chr(ord($startChar) + 1);

        //URL para referencia
        $doi = @$outputAttr->{"url"};

        //echo $url."</br>";

        $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($doi);

        //::::::URL, DOI::::::

        //caracter de comeco
        $startChar = chr(ord($startChar) + 1);

        $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($doi);

        $startNumber++;
    } 
}


// 4. Enventos e conferencias

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

$url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/" . $ciencia_id . "/service?lang=User%20defined";

//adicionar url ao handler cURL
curl_setopt($ch, CURLOPT_URL, $url);

//mostrar erros
//echo curl_error($ch);

//resultado
$result_curl = curl_exec($ch); //executar cURL e armazenar resultado

curl_close($ch); //fechar handler
$data = json_decode($result_curl); //descodificar JSON da resposta

//::::::::::::ESCREVER NO EXCEL::::::::::::

//categoria de servico
$serviceCategory = "";

//atributo do servico
$serviceAttr = (object)[];

//dados para escrever na folha

$categoriaEvento = "";

$refBibliografica = "";

$spreadsheet->setActiveSheetIndex(3);

//opcoes da lista pendente

$activePageSelectOptions = array();

for($opc = 1; $opc <= 15; $opc++){

    $activePageSelectOptions[$opc-1] = $spreadsheet->getActiveSheet()->getCell("H".$opc)->getFormattedValue();

}

//echo implode("</br>",$activePageSelectOptions);

foreach($data->{"service"} as $row){

    //letra de comeco
    $startChar = "A";

    //iterador
    $i = 0;

    //encontrar a propriedade nao nula correspondente ao tipo de servico
    foreach($row as $attr){
        if($attr != null && $i >= 1){
            $serviceAttr = $attr;
            break;
        }
        $i++;
    }

    /*if(@$row->{"service-category"} != null && 
    @$row->{"service-category"}->{"value"} == "Orientação")*/
    if(@$row->{"service-category"} != null && 
    (@$row->{"service-category"}->{"value"} == "Participação em evento" || 
    @$row->{"service-category"}->{"value"} == "Organização de evento") && 
    (@$serviceAttr->{"end-date"}->{"year"} == $year . "" ||
    @$serviceAttr->{"start-date"}->{"year"} == $year . "")){


        //::::::categoria do evento::::::
        $serviceCategory = @$row->{"service-category"}->{"value"};

        $categoriaEvento = $serviceCategory.": ".@$serviceAttr->{"end-date"}->{"year"};
        
        $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($categoriaEvento);

        //::::::referencia bibliografica::::::

        $startChar = chr(ord($startChar) + 1);

        $refBibliografica = @$serviceAttr->{"event-description"};

        $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($refBibliografica);

        $startNumber++;        

    }

}

// 5. Patentes



// 6. Trabalho de orientação

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

$url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/" . $ciencia_id . "/service?lang=User%20defined";

//adicionar url ao handler cURL
curl_setopt($ch, CURLOPT_URL, $url);

//mostrar erros
//echo curl_error($ch);

//resultado
$result_curl = curl_exec($ch); //executar cURL e armazenar resultado

curl_close($ch); //fechar handler
$data = json_decode($result_curl); //descodificar JSON da resposta

//::::::::::::ESCREVER NO EXCEL::::::::::::

//categoria de servico
$serviceCategory = "";

//atributo do servico
$serviceAttr = (object)[];

//tipo de graduacao
$degreeType = "";

//:::dados a escrever:::

$tipologiaOrientacao = "";

$nomeAluno = "";

$tituloProjeto = "";

$instituicao = "";

$spreadsheet->setActiveSheetIndex(5);

//opcoes da lista pendente

$activePageSelectOptions = array();

for($opc = 1; $opc <= 5; $opc++){

    $activePageSelectOptions[$opc-1] = $spreadsheet->getActiveSheet()->getCell("G".$opc)->getFormattedValue();

}

//Letra e numero de comeco
$startChar = "A";
$startNumber = 14;

foreach($data->{"service"} as $row){

    //letra de comeco
    $startChar = "A";

    //iterador
    $i = 0;

    //encontrar a propriedade nao nula correspondente ao tipo de servico
    foreach($row as $attr){
        if($attr != null && $i >= 1){
            $serviceAttr = $attr;
            break;
        }
        $i++;
    }

    /*if(@$row->{"service-category"} != null && 
    @$row->{"service-category"}->{"value"} == "Orientação")*/
    if(@$row->{"service-category"} != null && 
    @$row->{"service-category"}->{"value"} == "Orientação" && 
    (@$serviceAttr->{"end-date"}->{"year"} == $year . "" ||
    @$serviceAttr->{"start-date"}->{"year"} == $year . "")){

        //::::::tipologia de orientacao::::::

        $serviceCategory = @$row->{"service-category"}->{"value"};
        $degreeType = $serviceAttr->{"degree-type"}->{"value"};

        //!!!!!!!!!!! SUBSTITUIR POR SWITCH PARA AS OPÇÕES POSSIVEIS !!!!!!!!!

        $tipologiaOrientacao = $serviceCategory . ": " . $degreeType.": fim em ".$serviceAttr->{"end-date"}->{"year"};

        switch($tipologiaOrientacao){

            case "Orientação: Mestrado: fim em ".$year:
                $tipologiaOrientacao = $activePageSelectOptions[0];
                break;
            case "Orientação: Mestrado: fim em ":
                $tipologiaOrientacao = $activePageSelectOptions[1];
                break;
            case "Orientação: Doutoramento: fim em ".$year:
                $tipologiaOrientacao = $activePageSelectOptions[2];
                break;
            case "Orientação: Doutoramento: fim em ":
                $tipologiaOrientacao = $activePageSelectOptions[3];
                break;
            default:
                $tipologiaOrientacao = $activePageSelectOptions[4];
                break;

        }

        $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($tipologiaOrientacao);

        //::::::nome do aluno::::::

        $startChar = chr(ord($startChar) + 1);

        $nomeAluno = @$serviceAttr->{"student-name"}->{"value"};

        $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($nomeAluno);

        //::::::titulo do projeto::::::

        $startChar = chr(ord($startChar) + 1);

        $tituloProjeto = @$serviceAttr->{"thesis-title"};

        $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($tituloProjeto);

        //::::::instituicao::::::

        $startChar = chr(ord($startChar) + 1);

        $instituicao = @$serviceAttr->{"academic-institutions"}->{"institution"}[0]->{"institution-name"};

        $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($instituicao);

        $startNumber++;
    }
}


// 7. Prémios e distinções

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

$url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/" . $ciencia_id . "/distinction?lang=User%20defined";

//adicionar url ao handler cURL
curl_setopt($ch, CURLOPT_URL, $url);

//mostrar erros
//echo curl_error($ch);

//resultado
$result_curl = curl_exec($ch); //executar cURL e armazenar resultado

curl_close($ch); //fechar handler
$data = json_decode($result_curl); //descodificar JSON da resposta

//::::::::::::ESCREVER NO EXCEL::::::::::::

//dados para escrever na folha

$categoriaPremio = "";

$descricao = "";

$spreadsheet->setActiveSheetIndex(6);

//Letra e numero de comeco
$startChar = "A";
$startNumber = 16;

//opcoes da lista pendente

$activePageSelectOptions = array();

for($opc = 1; $opc <= 3; $opc++){

    $activePageSelectOptions[$opc-1] = $spreadsheet->getActiveSheet()->getCell("C".$opc)->getFormattedValue();

}

foreach($data->{"distinction"} as $row){

    $startChar = "A";

    if(@$row->{"effective-date"} != null && 
    @$row->{"effective-date"} == "".$year){

        //:::categoria do premio:::
        $categoriaPremio = @$row->{"distinction-type"}->{"value"};

        $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($categoriaPremio);

        //:::descricao/nome:::

        $startChar = chr(ord($startChar) + 1);

        $descricao = @$row->{"distinction-name"};

        $spreadsheet->getActiveSheet()->getCell($startChar.$startNumber)->setValue($descricao);

        $startNumber++;

    }

    

}

// 8. Outras atividades


//::::::::::::GUARDAR RELATORIO::::::::::::
$writer->save($novoRelatorio);

//::::::::::::DESCARREGAR RELATORIO::::::::::::

$finfo = finfo_open(FILEINFO_MIME_TYPE); 
$mime =  finfo_file($finfo, basename($novoRelatorio));
finfo_close($finfo);

header('Content-Type: '.$mime);
header('Content-Disposition: attachment;  filename="'.basename($novoRelatorio).'"');
header('Content-Length: ' . filesize(basename($novoRelatorio)));
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

ob_get_clean();
echo file_get_contents(basename($novoRelatorio));
ob_end_flush();


//::::::::::::APAGAR RELATORIO DO SERVIDOR::::::::::::
unlink($novoRelatorio);
?>