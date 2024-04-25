<?php
require "../config/basedados.php";

//Selecionar os dados das noticias da base de dados
$sqlSubsPT = "SELECT count(lang) as count FROM subscritores WHERE lang = 'pt'";
$sqlSubsENG = "SELECT count(lang) as count FROM subscritores WHERE lang = 'eng'";

$resultSubsPT = mysqli_query($conn, $sqlSubsPT);
$resultSubsENG = mysqli_query($conn, $sqlSubsENG);

$countPT = mysqli_fetch_assoc($resultSubsPT)["count"];
$countENG = mysqli_fetch_assoc($resultSubsENG)["count"];
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
</style>

<div id="main-container">

  <div class="row">
    <div class="col-sm-12">
      <button class="btn btn-primary mr-4 ml-4" id="start-send" data-translation='newsletter-button-send'>Iniciar Envio</button>
    </div>
  </div>

  <div class="row my-4">
    <div class="col-sm-4 mb-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title" data-translation='newsletter-stats-subscribers-pt'>Subscritores (Português)</h5>
          <p class="card-text">
            <?php
            echo ($countPT);
            ?>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 mb-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title" data-translation='newsletter-stats-subscribers-en'>Subscritores (Inglês)</h5>
          <p class="card-text">
            <?php
            echo ($countENG);
            ?>
          </p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 mb-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title" data-translation='newsletter-stats-total-subs'>Total Subscritores</h5>
          <p class="card-text">
            <?php
            echo ($countPT + $countENG);
            ?>
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="row my-4">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title" data-translation='newsletter-stats-sended'>Newsletters Enviadas</h5>
          <p class="card-text">Task Histórico</p>
        </div>
      </div>
    </div>
  </div>


</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#start-send').click(function() {
      $.ajax({
        url: 'iniciarEnvio.php',
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
