<?php
require "../config/basedados.php";
require "./templatePT.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['noticias_escolhidas'])) {
    $noticias = $_POST['noticias_escolhidas'];
  }
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
    ?>
  </style>
</head>

<body>
  <div id="main-container">
    <div class="row my-4">
      <button class="btn btn-primary mr-4 ml-4" id="back">Descartar</button>
      <button class="btn btn-primary mr-4 ml-4" id="next">Confimar</button>
    </div>
    <div class="col-sm-6">
      <div class="row my-4">
        
        <div class="form-group">
          <label for="titulo">Título:</label>
          <input type="text" class="form-control" id="titulo" placeholder="Digite o título" required>
        </div>
        <div class="form-group">
          <label for="assunto">Assunto:</label>
          <input type="text" class="form-control" id="assunto" placeholder="Digite o assunto" required>
        </div>
      </div>
      <div class="row my-4">
      <h4>Preencher Campos em Inglês</h4>
        <div class="form-group">
          <label for="tituloEn">Título:</label>
          <input type="text" class="form-control" id="tituloEn" placeholder="Digite o título" required>
        </div>
        <div class="form-group">
          <label for="assuntoEn">Assunto:</label>
          <input type="text" class="form-control" id="assuntoEn" placeholder="Digite o assunto" required>
        </div>
      </div>
    </div>
  </div>
  </div>
</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#back').click(function() {
      $.ajax({
        url: 'statsNewsletter.php',
        type: 'GET',
        success: function(data) {
          $('#main-container').html(data);
        },
        error: function() {
          alert('Erro ao carregar o conteúdo.');
        }
      });
    });

    $('#next').click(function() {
      var titulo = $('#titulo').val();
      var tituloEn = $('#tituloEn').val();
      var assunto = $('#assunto').val();
      var assuntoEn = $('#assuntoEn').val();
      var noticias = <?php echo json_encode($noticias); ?>;

      $.ajax({
        url: 'preverEmail.php',
        type: 'POST',
        data: {
          noticias: noticias,
          titulo: titulo,
          tituloEn :tituloEn,
          assunto: assunto,
          assuntoEn: assuntoEn
        },
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