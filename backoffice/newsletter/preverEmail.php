<?php
session_start();
require "../config/basedados.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $noticias_escolhidas = $_POST['noticias_escolhidas'];
    $_SESSION['noticias_escolhidas'] = $noticias_escolhidas;
}
?>

<head>
  <title>Preencher Campos</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
  <style>
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

    .search-bar {
      height: 40px;
      justify-content: center;
      align-items: center;
      width: 80%;
      flex: 1;
      padding-left: 10px;
      font-size: 16px;
      border-width: 1px;
      border-style: solid;
      border-radius: 2px;
      border-color: rgb(192, 192, 192);
      box-shadow: inset 1px 2px 3px rgba(0, 0, 0, 0.05);
    }

    .search-button {
      height: 40px;
      width: 66px;
      background-color: rgb(224, 224, 224);
      border-width: 1px;
      border-style: solid;
      border-color: rgb(192, 192, 192);
      margin-left: -1px;
      margin-right: 10px;
    }

    .search-icon {
      height: 25px;
    }
  </style>
</head>

<body>
  <div id="main-container">
    <div class="col-sm-12">
      <button class="btn btn-primary mr-4 ml-4" id="back">Voltar</button>
      <button class="btn btn-primary mr-4 ml-4" id="send">Enviar</button>
    </div>

    <div class="row my-4">
      <div class="col-sm-6">
        <h4>Lista de notícias escolhidas</h4>
        <ul class="list-group">
          <?php
          foreach ($_SESSION['noticias_escolhidas'] as $noticia) {
            echo "<li class='list-group-item d-flex justify-content-between align-items-center' data-noticia-id='" . $noticia['id'] . "'>" . $noticia['titulo'] . "</li>";
          }
          ?>
        </ul>
      </div>
    </div>

    <div class="row my-4 br-4">
   
    </div>
    
  </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#back').click(function() {
      $.ajax({
        url: 'preencherCampos.php',
        type: 'GET',
        success: function(data) {
          $('#main-container').html(data);
        },
        error: function() {
          alert('Erro ao carregar o conteúdo.');
        }
      });
    });
  });
</script>
