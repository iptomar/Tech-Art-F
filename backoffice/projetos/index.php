<?php
require "../verifica.php";
require "../config/basedados.php";
require "../assets/models/functions.php";

// Initialize extra condition to empty string
$extraCondition = "";

// Check if the filterForm is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filterForm'])) {
	// Check if the checkbox for completed projects is checked
	if (isset($_POST['pcompletos'])) {
		// Add the extra condition
		$extraCondition = " AND concluido = 1";
	}
}

// Modify the SQL query to include the extra condition
$sql = "SELECT id, nome, referencia, areapreferencial, financiamento, fotografia, concluido FROM projetos WHERE 1=1" . $extraCondition . " ORDER BY nome";

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
	<div class="container-xl">
		<div class="table-responsive">
			<div class="table-wrapper">
				<div class="table-title">
					<div class="row">
						<div class="col-sm-6">
							<h2 data-translation='project-title'>Projetos</h2>
						</div>
						<div class="col-sm-6">
							<a href="create.php" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span data-translation='project-add-new'>Adicionar
									Novo Projeto</span></a>
						</div>
					</div>
				</div>
				<div id="filterSection" style="display: flex; align-items: center;">
					<h2 style="margin-right: auto;">Filtros</h2>
					<form id="filterForm" method="post" style="flex: 1; display: flex; align-items: center;">
						<div id="optionsDiv" style="margin: auto;">
							<label for="completos" style="display: flex; align-items: center;">
								<input type="checkbox" id="completos" name="pcompletos" value="Completos" <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filterForm']) && isset($_POST['pcompletos']))
									echo "checked"; ?> style="margin-right: 5px;">
								<span style="vertical-align: middle;">Completos</span>
							</label>
							<!-- Add more checkboxes here for additional filters -->
						</div>
						<button class="btn btn-success" type="submit">Aplicar</button>
						<input type="hidden" name="filterForm"> <!-- Hidden field to indicate form submission -->
					</form>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th data-translation='project-name'>Nome</th>
							<th data-translation='project-state'>Estado</th>
							<!--                 <th>Descrição</th>
				<th>Sobre Projeto</th> -->
							<th data-translation='project-reference'>Referência</th>
							<th data-translation='project-preferencial-area'>TECHN&ART Área Preferencial</th>
							<th data-translation='project-funding'>Financiamento</th>
							<!--                 <th>Âmbito</th>
 -->
							<th data-translation='project-photo'>Fotografia</th>
							<th data-translation='project-actions'>Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								echo "<tr>";
								echo "<td>" . $row["nome"] . "</td>";
								if ($row["concluido"]) {
									echo "<td>Concluído</td>";
								} else {
									echo "<td>Em Curso</td>";
								}
								/*             echo "<td style='width:250px;'>".$row["descricao"]."</td>";
													echo "<td style='width:250px;'>".$row["sobreprojeto"]."</td>";
													*/
								echo "<td>" . $row["referencia"] . "</td>";
								echo "<td>" . $row["areapreferencial"] . "</td>";
								echo "<td>" . $row["financiamento"] . "</td>";
								/*             echo "<td>".$row["ambito"]."</td>";
								 */
								echo "<td><img src='../assets/projetos/$row[fotografia]' width = '100px' height = '100px'></td>";
								$sql1 = "SELECT gestores_id FROM gestores_projetos WHERE projetos_id = " . $row["id"];
								$result1 = mysqli_query($conn, $sql1);
								$selected = array();
								if (mysqli_num_rows($result1) > 0) {
									while (($row1 = mysqli_fetch_assoc($result1))) {
										$selected[] = $row1['gestores_id'];
									}
								}
								if ($_SESSION["autenticado"] == "administrador" || in_array($_SESSION["autenticado"], $selected)) {
									echo "<td><a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary'><span data-translation='project-button-change'>Alterar</span></a></td>";
									echo "<td><a href='remove.php?id=" . $row["id"] . "' class='btn btn-danger'><span data-translation='project-button-delete'>Apagar</span></a></td>";
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

	<?php
	mysqli_close($conn);
	?>