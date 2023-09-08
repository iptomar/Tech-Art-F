<?php
require "../verifica.php";
require "../config/basedados.php";

$find = "";


$sql = "SELECT id, nome, email, ciencia_id, sobre, tipo, fotografia, areasdeinteresse, orcid, scholar FROM investigadores ORDER BY nome";
$result = mysqli_query($conn, $sql);

if (isset($_POST["anoRelatorio"])) {
	$_SESSION["anoRelatorio"] = $_POST["anoRelatorio"];
}

?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Round">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style type="text/css">
	<?php
	$css = file_get_contents('../styleBackoffices.css');
	echo $css;
	?>
</style>

<div class="container mt-3">
	<form action="./index.php" method="post">
		<input name="anoRelatorio" type="text" placeholder="Ano do relatório" />
		<input type="submit" value="Submeter Ano" class="btn btn-success" />

		<?php
		if (isset($_SESSION["anoRelatorio"])) {
		?>
			<span class='text-danger'>
				<?php
				if (@$_SESSION["anoRelatorio"] != "") {

				?>

					<span class="material-icons-round ml-3" style="font-size:16px;">&#xE002;</span><span class="ml-2">Foi submetido o ano <?= $_SESSION["anoRelatorio"] ?>!</span>

				<?php
				} else {
				?>

					<span class="material-icons-round ml-3" style="font-size:16px;">&#xE002;</span><span class="ml-2">Cuidado! Campo submetido vazio! (Ano: <?= date("Y") ?>)</span>

				<?php
				}

				?>

			</span>

		<?php } else {
		?>
			<span class="text-info">
				<span class="material-icons-round ml-3" style="font-size:16px;">&#xE88E;</span><span class="ml-2"> Ano Atual: <?= date("Y") ?></span>
			</span>
		<?php
		} ?>
	</form>
</div>

<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Investigadores</h2>
					</div>
					<?php if ($_SESSION["autenticado"] == 'administrador') { ?>
						<div class="col-sm-6">
							<a href="create.php" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Adicionar
									Novo Investigador</span></a>
						</div>
					<?php } ?>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Email</th>
						<th>CiênciaVitae ID</th>
						<!--<th>Sobre</th>
						<th>Tipo</th>
						<th>Áreas de interesse</th>
						<th>Orcid</th>
						<th>Scholar</th> -->
						<th>Fotografia</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							if ($_SESSION["autenticado"] == 'administrador' || $_SESSION["autenticado"] == $row["id"]) {
								echo "<tr>";
								echo "<td>" . $row["nome"] . "</td>";
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["ciencia_id"] . "</td>";
								/*                         echo "<td>".$row["sobre"]."</td>";
								echo "<td>".$row["tipo"]."</td>";
								echo "<td>".$row["areasdeinteresse"]."</td>";
								echo "<td>".$row["orcid"]."</td>";
								echo "<td>".$row["scholar"]."</td>";
								*/
								echo "<td><img src='../assets/investigadores/$row[fotografia]' width = '100px' height = '100px'></td>";
								echo "<td style='min-width:250px;'><a href='edit.php?id=" . $row["id"] . "' class='w-100 mb-1 btn btn-primary'><span>Alterar</span></a>";
								if ($_SESSION["autenticado"] == 'administrador') {
									echo "<a href='remove.php?id=" . $row["id"] . "' class='w-100 mb-1 btn btn-danger'><span>Apagar</span></a><br>";
								}
								echo "<a href='resetpassword.php?id=" . $row["id"] . "' class='w-100 mb-1 btn btn-warning'><span>Alterar Password</span></a><br>";
								echo "<a onclick='gerarRelatorio(" . $row["id"] . ")' class='w-100 mb-1 btn btn-info'><span>Gerar Relatório</span></a><br>";
								echo "<a href='publicacoes.php?id=" . $row["id"] . "' class='w-100 mb-1 btn btn-secondary'><span>Selecionar Publicações</span></a><br>";
								echo "</td>";
								echo "</tr>";
							}
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	//Criar um formulário com o id do investigador a gerar o relátorio e submeter para fazer POST com o gerar e ativar o php
	function gerarRelatorio(id) {
		const form = document.createElement("form");
		form.action = "index.php";
		form.method = "post";

		const input = document.createElement("input");
		input.type = "hidden";
		input.name = "gerar";
		input.value = id;

		form.appendChild(input);

		document.body.appendChild(form);

		form.submit();
	}
</script>

<?php
if (isset($_POST['gerar'])) {
// Verifica se a variável de sessão "anoRelatorio" está definida
if (isset($_SESSION["anoRelatorio"])) {
    // Se estiver definida, utiliza o ano da variável de sessão
    $year = $_SESSION["anoRelatorio"];
} else {
    // Caso contrário, usa o ano atual
    $year = date("Y");
}

// Consulta SQL para obter publicações do investigador para o ano especificado
$sql = "SELECT p.idPublicacao, p.dados, p.data, p.pais, p.cidade, p.tipo
        FROM publicacoes p
        INNER JOIN publicacoes_investigadores pi ON p.idPublicacao = pi.publicacao
        WHERE pi.investigador = ? and visivel=1 and YEAR(data) = $year";

// Prepara a consulta SQL
$stmt = mysqli_prepare($conn, $sql);
$investigatorId = $_POST["gerar"];
mysqli_stmt_bind_param($stmt, "i", $investigatorId);

// Executa a consulta SQL
if (!mysqli_stmt_execute($stmt)) {
    die("Executar falhou: " . mysqli_error($conn));
}

// Obtém o resultado da consulta
$result = mysqli_stmt_get_result($stmt);
$publicacoes = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fecha a consulta SQL
mysqli_stmt_close($stmt);

// Obtém o ciencia_id do investigador a partir do banco de dados
$stmt = mysqli_prepare($conn, "SELECT ciencia_id FROM investigadores WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $investigatorId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$cienciaId = $row['ciencia_id'];

// Define login e senha para a API da Ciência Vitae
$loginAPI = USERCIENCIA;
$passwordAPI = PASSWORDCIENCIA;

// URL da API da Ciência Vitae para obter informações do currículo do investigador
$url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/" . $cienciaId . "/output?lang=User%20defined";

// Inicializa uma sessão cURL
$ch = curl_init();

// Define os cabeçalhos da requisição cURL
$headers = array(
    "Content-Type: application/json",
    "Accept: application/json",
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

// Define as credenciais de autenticação para a API da Ciência Vitae
curl_setopt($ch, CURLOPT_USERPWD, "$loginAPI:$passwordAPI");

// Executa a requisição cURL e obtém a resposta
$result_curl = curl_exec($ch);

// Fecha a sessão cURL
curl_close($ch);

// Decodifica o JSON da resposta em um objeto PHP
$data = json_decode($result_curl);


// URL da API da Ciência Vitae para obter informações sobre patentes
$url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/" . $cienciaId . "/output?lang=User%20defined";

// Inicializa outra sessão cURL
$ch = curl_init();

// Define os cabeçalhos da requisição cURL novamente
$headers = array(
    "Content-Type: application/json",
    "Accept: application/json",
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

// Define as credenciais de autenticação para a API da Ciência Vitae novamente
curl_setopt($ch, CURLOPT_USERPWD, "$loginAPI:$passwordAPI");

// Executa a segunda requisição cURL e obtém a resposta
$result_curl = curl_exec($ch);

// Fecha a segunda sessão cURL
curl_close($ch);

// Decodifica o JSON da segunda resposta em um objeto PHP
$data = json_decode($result_curl);

// Usa array_filter para filtrar apenas as patentes no ano especificado
$filteredData = array_filter($data->output, function ($item) use ($year) {
    return isset($item->{"output-type"}->code) && $item->{"output-type"}->code === "P401"
        && isset($item->patent->{"date-issued"}->year) && $item->patent->{"date-issued"}->year === $year;
});

// Função para gerar entradas BibTeX a partir dos dados das patentes filtradas
function generateEntry($dataArray)
{
    $bibtexArray = [];

    foreach ($dataArray as $data) {
        if (!is_object($data) || !isset($data->patent)) {
            continue;
        }

        $bibtexEntry = "@patent{" . $data->patent->identifiers->identifier[0]->identifier . ",\n" .
            "  title = {" . $data->patent->{"patent-title"} . "},\n" .
            "  year = {" . $data->patent->{"date-issued"}->year . "},\n" .
            "  author = {" . $data->patent->authors->citation . "}" .
            (isset($data->patent->country->value) ? ",\n  location = {" . $data->patent->country->value . "}" : "") .
            "\n}";

        $bibtexArray[] = $bibtexEntry;
    }

    return $bibtexArray;
}

// Gera entradas em BibTeX a partir dos dados das patentes filtradas
$patents = generateEntry($filteredData);

// Inclui a biblioteca jQuery através de um link externo
echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script src="../assets/js/citation-js-0.6.8.js"></script>
	<script>
		const Cite = require(\'citation-js\');
		var publications = ' . json_encode($publicacoes) . ';
		var patentes = ' . json_encode($patents) . ';


		// Obter a referência APA das publicações 
		for (var i = 0; i < publications.length; i++) {
			var APAreference = processarAPA(publications[i].dados);
			publications[i].dados = APAreference;
		}

		// Obter a referência APA das patentes 
		for (var i = 0; i < patentes.length; i++) {
			var APAreference = processarAPA(patentes[i]);
			patentes[i] = APAreference;
		}
		
		function processarAPA(data) {
			// Lógica de processamento do "citation.js"
			var htmlContent = new Cite(data).format(\'bibliography\', {
				format: \'html\',
				template: \'apa\',
				lang: \'en-US\'
			});
			return htmlContent;
		}
		
		// Criar um elemento de formulário
		var form = document.createElement(\'form\');
		form.method = \'POST\';
		form.action = \'autoEscreveRelatorio.php?id=\' + ' . $investigatorId . ';
		
		// Criar um elemento de input para armazenar as publicações
		var input = document.createElement(\'input\');
		input.type = \'hidden\';
		input.name = \'publicacoes\';
		input.value = JSON.stringify(publications);

		// Anexar o input publicacoes ao formulário
		form.appendChild(input);

		var inputPat = document.createElement(\'input\');
		inputPat.type = \'hidden\';
		inputPat.name = \'patentes\';
		inputPat.value = JSON.stringify(patentes);

		// Anexar o input patentes ao formulário
		form.appendChild(inputPat);
		
		// Anexar o formulário ao documento
		document.body.appendChild(form);
		
		// Submeter o formulário
		form.submit();
	</script>';
}

mysqli_close($conn);
?>