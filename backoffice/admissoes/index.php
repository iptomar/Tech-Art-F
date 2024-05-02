<?php
require "../verifica.php";
require "../config/basedados.php";
require "bloqueador.php";
require "../assets/models/functions.php";

$sql = "SELECT id, ficheiro_fotografia, nome_completo, ciencia_id, orcid, data_criacao FROM admissoes ORDER BY data_criacao DESC";
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
	?>
</style>

<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2 data-translation='admissions-requests-title'>Pedidos de admissão</h2>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
					<th style="min-width:150px" data-translation='admissions-table-submission-date'>Data Submissão</th>
						<th style="max-width:150px" data-translation='admissions-table-photo'>Fotografia</th>
						<th data-translation='admissions-table-full-name'>Nome completo</th>
						<th style="min-width:100px" >Ciência ID</th>
						<th style="min-width:100px" >ORCID</th>
						<th data-translation='admissions-table-actions'>Ações</th>
					</tr>
				</thead>

				<tbody>
					<?php
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							$formatted_timestamp = date("d-m-Y H:i", strtotime($row["data_criacao"]));
							echo "<tr>";
							echo "<td>" . $formatted_timestamp . "</td>";
							echo "<td><img src='../assets/ficheiros_admissao/admissao_" . $row["id"] . "/" . $row["ficheiro_fotografia"] . "' width = '100px' height = '100px'></td>";
							echo "<td>" . $row["nome_completo"] . "</td>";
							echo "<td>" . $row["ciencia_id"] . "</td>";
							echo "<td>" . $row["orcid"] . "</td>";
							echo "<td><a href='details.php?id=" . $row["id"] . "' class='btn btn-primary'><span data-translation='admissions-button-details'>Detalhes</span></a></td>";
							echo "<td><a href='remove.php?id=" . $row["id"] . "' class='btn btn-danger'><span data-translation='admissions-button-delete'>Apagar</span></a></td>";
							echo "</tr>";
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