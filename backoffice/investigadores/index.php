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
			}?>
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
								echo "<a href='autoEscreveRelatorio.php?id=" . $row["id"] . "' class='w-100 mb-1 btn btn-info'><span>Gerar Relatório</span></a><br>";
								echo "<a href='publicacoes.php?ciencia_id=" . $row["ciencia_id"] . "' class='w-100 mb-1 btn btn-secondary'><span>Selecionar Publicações</span></a><br>";
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

<?php

mysqli_close($conn);
?>