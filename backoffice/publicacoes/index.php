<?php
require "../verifica.php";
require "../config/basedados.php";
require "./analise_duplicados.php";

$sql = "SELECT i.email as email, REGEXP_SUBSTR(dados, 'title = {(.*?)}') as title,
REGEXP_SUBSTR(dados, 'journal = {(.*?)}') as journal,
REGEXP_SUBSTR(dados, 'volume = {(.*?)}') as volume,
REGEXP_SUBSTR(dados, 'number = {(.*?)}') as pnumber,
REGEXP_SUBSTR(dados, 'pages = {(.*?)}') as pages,
REGEXP_SUBSTR(dados, 'year = {(.*?)}') as pyear,
REGEXP_SUBSTR(dados, 'url = {(.*?)}') as purl,
REGEXP_SUBSTR(dados, 'author = {(.*?)}') as author,
REGEXP_SUBSTR(dados, 'keywords = {(.*?)}') as keywords
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

<div class="container-xl">
  <div class="container-xl">
    <div class="table-responsive">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h2>Publicações</h2>
            </div>
            <div class="col-sm-6">
              <input type="submit" class="btn btn-success" class="material-icons" name="submit" value="Analisar">
            </div>
            <form method="post"><br>
              <label for="percentage">Percentagem (0-100%):</label>
              <input type="number" id="percentage" name="percentage" min="0" max="100" required>
              <br><br>
              <label>Selecione os campos para análise:</label>
              <br>
              <input type="checkbox" id="title" name="fields[]" value="title">
              <label for="title">Title</label>

              <input type="checkbox" id="volume" name="fields[]" value="volume">
              <label for="volume">Volume</label>

              <input type="checkbox" id="edition" name="fields[]" value="edition">
              <label for="edition">Edition</label>

              <input type="checkbox" id="pages" name="fields[]" value="pages">
              <label for="pages">Pages</label>

              <input type="checkbox" id="year" name="fields[]" value="year">
              <label for="year">Year</label>

              <input type="checkbox" id="publisher" name="fields[]" value="publisher">
              <label for="publisher">Publisher</label>

              <input type="checkbox" id="url" name="fields[]" value="url">
              <label for="url">URL</label>

              <input type="checkbox" id="author" name="fields[]" value="author">
              <label for="author">Author</label>

              <input type="checkbox" id="editor" name="fields[]" value="editor">
              <label for="editor">Editor</label>

              <input type="checkbox" id="keywords" name="fields[]" value="keywords">
              <label for="keywords">Keywords</label>
            </form>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div>
      <table style="width:100%" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Warning</th>
            <th>E-Mail</th>
            <th>Similaridade</th>
            <th>Title</th>
            <th>Journal</th>
            <th>Volume</th>
            <th>Number</th>
            <th>Pages</th>
            <th>Year</th>
            <th>url</th>
            <th>Author</th>
            <th>Keywords</th>
          </tr>
        </thead>
        <tbody>

          <?php

          $percentage = 
          $rows = $result->fetch_all(MYSQLI_ASSOC);
          $titles = array_column($rows, 'title');
          $journals = array_column($rows, 'journal');
          $volumes = array_column($rows, 'volume');
          $numbers = array_column($rows, 'pnumber');
          $pages = array_column($rows, 'pages');
          $years = array_column($rows, 'pyear');
          $urls = array_column($rows, 'purl');
          $authors = array_column($rows, 'author');
          $keywords = array_column($rows, 'keywords');

          $checker = new analise_duplicados($titles,$journals,$volumes,$numbers,$pages,$years,$urls,$authors,$keywords);

          $potentialDuplicates = $checker->checkSimilarity();

          foreach ($potentialDuplicates as $duplicate) {
            echo "<tr>";
            echo "<td>" . "</td>";
            echo "<td>" . $duplicate["publication1title"] . "</td>";
            echo "<td>" . $duplicate["publication2title"] . "</td>";
            echo "<td>" . $duplicate["percenttitle"] . "</td>";
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