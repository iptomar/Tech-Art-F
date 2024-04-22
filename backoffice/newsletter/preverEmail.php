<?php
require "../config/basedados.php";
require "./templatePT.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['noticias'])) {
    $noticias = json_encode($_POST['noticias']);
  }
  if (isset($_POST['tituloPT'])) {
    $tituloPT = $_POST['tituloPT'];
  }
  if (isset($_POST['assuntoPT'])) {
    $assuntoPT = $_POST['assuntoPT'];
  }
  if (isset($_POST['tituloENG'])) {
    $tituloENG = $_POST['tituloENG'];
  }
  if (isset($_POST['assuntoENG'])) {
    $assuntoENG = $_POST['assuntoENG'];
  }
}
?>

<head>
  <title>Prever Email</title>
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
    <div class="col-">
      <h4>Preview Template</h4>
      <div>
        <?php echo template_header_pt(); ?>
        <?php echo template_noticias_pt($titulo, $noticias); ?>
        <?php echo template_footer_pt('Token'); ?>
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
  });
</script>