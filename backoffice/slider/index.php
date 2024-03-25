<?php
require "../verifica.php";
require "../config/basedados.php";
//Selecionar os dados do slider da base de dados
$sql = "SELECT id, titulo, conteudo, imagem , visibilidade, link FROM slider";
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
	.div-textarea {
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
						<h2>Slider</h2>
					</div>
					<div class="col-sm-6">
						<?php
						if ($_SESSION["autenticado"] == "administrador") {
							echo '<a href="create.php" class="btn btn-success"><i class="material-icons">&#xE147;</i>';
							echo '<span>Adicionar Novo Item ao Slider</span></a>';
						}
						?>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th style="width: 30px;">Título</th>	
						<th style="width: 30px;">Ativo</th>							
						<th>Imagem</th>						
						<th>Conteúdo</th>						
					</tr>
				</thead>

				<tbody>
					<?php
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td style='width:50px;'>" . $row["titulo"] . "</td>";
							if ($row["visibilidade"] == 1)
								echo "<td style='width:50px;'><div style='height:50px; width:80px; background-color:green; display:flex; justify-content:center; align-items:center;'>Ativo</div></td>";
							else 
								echo "<td style='width:50px;'><div style='height:50px; width:80px; background-color:grey; display:flex; justify-content:center; align-items:center;'>Oculto</div></td>";
							echo "<td><img src='../assets/slider/$row[imagem]' width = '250px'></td>";
							echo "<td>" . "<div class='div-textarea' style='width:100%; height:100%;'>" . $row["conteudo"] . "</div>" . "</td>";
							if ($_SESSION["autenticado"] == "administrador") {
								echo "<td><a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary'><span>Alterar</span></a></td>";
								echo "<td><a href='remove.php?id=" . $row["id"] . "' class='btn btn-danger'><span>Apagar</span></a></td>";
							}
							echo "</tr>";							

							if (!$row["link"] == "")
								echo "<td colspan='6' style='background-color:#cccccc'><b>Link: </b>" . $row["link"] . "</td>";
							else
								echo "<td colspan='6' style='background-color:#cccccc'><b>Link: </b>N/A</td>";
							echo "</tr>";

							echo "<tr><td colspan='6'><hr style='height: 3px; background-color: #435D7D;' /></td></tr>";
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
?> No index.php adicionar funcao/ciclo que faz parse das imagens da tabela e gera o slider para o template da homepage.