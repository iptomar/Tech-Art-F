<?php
require "../verifica.php";
require "../config/basedados.php";
require "./analise_duplicados.php";

$sql = "SELECT *, i.email, REGEXP_SUBSTR(dados, 'title = {(.*?)}') as title
FROM publicacoes AS p 
JOIN publicacoes_investigadores AS pi2 ON p.idPublicacao = pi2.publicacao
JOIN investigadores AS i ON pi2.investigador = i.id;";
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

<div class="container">
        <h2>Analisar Dados</h2>
        <form method="post">
            <label for="percentage">Porcentagem (0-100%):</label>
            <input type="number" id="percentage" name="percentage" min="0" max="100" required>
            <br><br>
            <label>Selecione os campos:</label>
            <br>
            <input type="checkbox" id="title" name="fields[]" value="title">
            <label for="title">Title</label>
            <br>
            <input type="checkbox" id="volume" name="fields[]" value="volume">
            <label for="volume">Volume</label>
            <br>
            <input type="checkbox" id="edition" name="fields[]" value="edition">
            <label for="edition">Edition</label>
            <br>
            <input type="checkbox" id="pages" name="fields[]" value="pages">
            <label for="pages">Pages</label>
            <br>
            <input type="checkbox" id="year" name="fields[]" value="year">
            <label for="year">Year</label>
            <br>
            <input type="checkbox" id="publisher" name="fields[]" value="publisher">
            <label for="publisher">Publisher</label>
            <br>
            <input type="checkbox" id="url" name="fields[]" value="url">
            <label for="url">URL</label>
            <br>
            <input type="checkbox" id="author" name="fields[]" value="author">
            <label for="author">Author</label>
            <br>
            <input type="checkbox" id="editor" name="fields[]" value="editor">
            <label for="editor">Editor</label>
            <br>
            <input type="checkbox" id="keywords" name="fields[]" value="keywords">
            <label for="keywords">Keywords</label>
            <br><br>
            <input type="submit" name="submit" value="Analisar">
        </form>
    </div>

<?php
$titles = array_column($result->fetch_all(MYSQLI_ASSOC), 'title');

$checker = new analise_duplicados($titles);
$potentialDuplicates = $checker->checkSimilarity();

foreach ($potentialDuplicates as $duplicate) {
  
    echo "Potencial duplicado:\n";
    echo "Publicação 1: " . $duplicate['publicacao1'] . "\n<br>";
    echo "Publicação 2: " . $duplicate['publicacao2'] . "\n<br>";
    echo "Similaridade: " . $duplicate['similaridade'] . "%\n\n <br><br>";
}

?>

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
              <th>e-mail</th>
              <th>titulo</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $result = mysqli_query($conn, $sql);
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
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
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