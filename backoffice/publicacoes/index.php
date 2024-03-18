<?php
require "../verifica.php";
require "../config/basedados.php";

$sql = "SELECT * FROM publicacoes";
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

//usar similar text para comparar strings
//mostrar percentagem
//adicionar email referente da publicacao na listagem
//com trim e lowercase 


<div class="container-xl">
  <div class="container-xl">
    <div class="table-responsive">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h2>Projetos</h2>
            </div>
            <div class="col-sm-6">
            </div>
          </div>
        </div>
        <table style="width:100%" class="table table-striped table-hover" >
          <thead>
            <tr>
              <th>idPublicação</th>
              <th >Dados</th>
              <th>Data</th>
              <th>País</th>
              <th>Cidade</th>
              <th>Tipo</th>
              <th>Visível</th>
            </tr>
          </thead>
          <tbody>

            <?php
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["idPublicacao"] . "</td>";
                echo "<td>" . $row["dados"] . "</td>";
                echo "<td>" . $row["data"] . "</td>";
                echo "<td>" . $row["pais"] . "</td>";
                echo "<td>" . $row["cidade"] . "</td>";
                echo "<td>" . $row["tipo"] . "</td>";
                echo "<td>" . $row["visivel"] . "</td>";
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