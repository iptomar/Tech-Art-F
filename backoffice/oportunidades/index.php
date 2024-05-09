<?php
require "../verifica.php";
require "../config/basedados.php";

//Selecionar os dados das oportunidades da base de dados
$sql = "SELECT id, titulo,titulo_en, imagem,visivel FROM oportunidades ORDER BY visivel DESC, id DESC";
$result = mysqli_query($conn, $sql);
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style type="text/css">
	<?php
	$css = file_get_contents('../styleBackoffices.css');
	echo $css;
	?>.div-textarea {
		display: block;
		padding: 5px 10px;
		border: 1px solid lightgray;
		resize: vertical;
		overflow: auto;
		resize: vertical;
		font-size: 1rem;
		font-weight: 400;
		line-height: 1.5;
		color: #495057;
	}
</style>

<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2 data-translation='opportunities-title'>Oportunidades</h2>
					</div>
					<div class="col-sm-6">
						<?php
						if ($_SESSION["autenticado"] == "administrador") {
							echo '<a href="create.php" class="btn btn-success"><i class="material-icons">&#xE147;</i>';
							echo '<span data-translation="opportunities-button-add">Adicionar Nova Oportunidade</span></a>';
						}
						?>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th style='width:100px;' data-translation='opportunities-table-visible'>Visível</th>
						<th style='width:110px;' data-translation='opportunities-table-image'>Imagem</th>
						<th style='width:250px;'>Título</th>
						<th style='width:200px;' data-translation='opportunities-table-title-en'>Título EN</th>
					</tr>
				</thead>

				<tbody>
					<?php
					if (@mysqli_num_rows($result) > 0) {

						while ($row = mysqli_fetch_assoc($result)) {
							$filesDir = "../assets/oportunidades/ficheiros_" . $row['id'] . "/";
							$files = '';
							if (is_dir($filesDir)) {
								$files = scandir($filesDir);
								$files = array_diff($files, array('.', '..'));
							}

							$row["visivel"] = $row["visivel"] ? "Sim" : "Não";
							echo "<tr>";
							echo "<td>" . $row["visivel"] . "</td>";

							echo "<td><img src='../assets/oportunidades/" . $row["imagem"] . "' width = '100px' height = '100px'></td>";
							echo "<td>" . $row["titulo"] . "</td>";

							echo "<td>" . $row["titulo_en"] . "</td>";
							if ($_SESSION["autenticado"] == "administrador") {
								echo "<td style='width:40px;'><a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary'><span data-translation='opportunities-button-change'>Alterar</span></a></td>";
								echo "<td style='width:40px;'><a href='remove.php?id=" . $row["id"] . "' class='btn btn-danger'><span data-translation='opportunities-button-delete'>Apagar</span></a></td>";
							}
							echo "</tr>";
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>