<?php
require "../config/basedados.php";
require "./templatePT.php";
require "./templateEn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['noticias'])) {
    $noticias = json_encode($_POST['noticias']);
  }
  if (isset($_POST['titulo'])) {
    $titulo = $_POST['titulo'];
  }
  if (isset($_POST['assunto'])) {
    $assunto = $_POST['assunto'];
  }
  if (isset($_POST['tituloEn'])) {
    $tituloEn = $_POST['tituloEn'];
  }
  if (isset($_POST['assuntoEn'])) {
    $assuntoEn = $_POST['assuntoEn'];
  }
}
?>

<!DOCTYPE html>
<html>

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
    <?php $css = file_get_contents('../styleBackoffices.css');
    echo $css; ?>
  </style>
</head>

<body>
  <div id="main-container">
    <div class="row my-4">
      <button class="btn btn-primary mr-4 ml-4" id="back">Descartar</button>
      <button class="btn btn-primary mr-4 ml-4" id="send-newsletter">Enviar Newsletter</button>
    </div>
    <div class="row my-4 ml-6">
      <div class="progress" id="progress-bar" style="display: none; width:100%; margin-left:24px;">
        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; height:20px;">
          Aguarde

        </div>
      </div>
    </div>
    <div class="col">
      <h4>Preview Template Português</h4>
      <div class="row my-4">
        <div>
          <?php echo template_header_pt(); ?>
          <?php echo template_noticias_pt($titulo, $noticias); ?>
          <?php echo template_footer_pt('Token'); ?>
        </div>
      </div>
      <h4>Preview Template Inglês</h4>
      <div class="row my-4">
        <div>
          <?php echo template_header_en(); ?>
          <?php echo template_noticias_en($tituloEn, $noticias); ?>
          <?php echo template_footer_en('Token'); ?>
        </div>
      </div>
    </div>
  </div>


</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#send-newsletter').click(function(e) {
      e.preventDefault(); // Impede o envio do formulário

      // Exibe a barra de progresso
      $('#progress-bar').show();

      var titulo = '<?php echo $titulo; ?>';
      var assunto = '<?php echo $assunto; ?>';
      var tituloEn = '<?php echo $tituloEn; ?>';
      var assuntoEn = '<?php echo $assuntoEn; ?>';
      var noticias = '<?php echo $noticias; ?>';

      // Simulação de envio de newsletter (substitua por sua lógica real)
      setTimeout(function() {
        // Atualiza a barra de progresso
        var progress = 0;
        var interval = setInterval(function() {
          progress += 10;
          $('#progress-bar .progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
          if (progress >= 125) {
            clearInterval(interval);
            alert('Newsletter enviada com sucesso!');
            $('#progress-bar').hide();
          }
        }, 200);
      }, 1000);
    });

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

</html>