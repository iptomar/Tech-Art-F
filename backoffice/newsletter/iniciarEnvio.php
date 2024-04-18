<script>session_start();</script>


<?php

require "../config/basedados.php";

//Selecionar os dados das noticias da base de dados
$sql = "SELECT id, titulo, conteudo, data, imagem FROM noticias ORDER BY DATA DESC, titulo";
$result = mysqli_query($conn, $sql);
// Inicializar o array de notícias escolhidas
if (!isset($_SESSION['noticias_escolhidas'])) {
  $_SESSION['noticias_escolhidas'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $noticias_escolhidas = $_POST['noticias_escolhidas'];
  
  $_SESSION['noticias_escolhidas'] = $noticias_escolhidas;
  }
?>

<head>
  <title>Iniciar Envio</title>
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
      <button class="btn btn-primary mr-4 ml-4" id="next">Seguinte</button>

    </div>

    <div class="row my-4">
      <div class="col-sm-6">
        <h4>Lista de notícias escolhidas</h4>
        <ul id="noticias-escolhidas" class="list-group sortable">
          <?php
          foreach ($_SESSION['noticias_escolhidas'] as $noticia) {
            echo "<li class='list-group-item d-flex justify-content-between align-items-center' data-noticia-id='" . $noticia['id'] . "'>" . $noticia['titulo'] . "<span class='badge badge-primary badge-pill remove-noticia'>Remover</span></li>";
          }
          ?>
        </ul>
      </div>
    </div>

    <div class="row my-4">
      <div class="col-sm-6">
        <input class="search-bar" type="text" placeholder="Pesquisar" id="search-input">
        <button class="search-button" id="search-button">
          <img class="search-icon" src="../assets/newsletter/search.svg">
        </button>
      </div>
    </div>

    <div class="row my-4">
      <table class="table table-striped table-hover" id="noticias-table">
        <thead>
          <tr>
            <th>Título</th>
            <th>Conteúdo</th>
            <th>Data</th>
            <th>Imagem</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              if (!in_array($row, $_SESSION['noticias_escolhidas'])) {
                echo "<tr data-noticia-id='" . $row['id'] . "'>";
                echo "<td style='width:250px;'>" . $row["titulo"] . "</td>";
                echo "<td style='width:500px; height:100px;'>" . "<div class='div-textarea' style='width:100%; height:100%;'>" . $row["conteudo"] . "</div>" . "</td>";
                echo "<td style='width:250px;'>" . $row["data"] . "</td>";
                echo "<td><img src='../assets/noticias/$row[imagem]' width='100px' height='100px'></td>";
                echo "<td><button class='btn btn-primary add-noticia' data-noticia-id='" . $row['id'] . "' data-noticia-titulo='" . $row['titulo'] . "'>Adicionar</button></td>";
                echo "</tr>";
              }
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

<script>
  // Passando o array de notícias escolhidas do PHP para o JavaScript
  var noticiasEscolhidas = <?php echo json_encode($_SESSION['noticias_escolhidas']); ?>;
</script>
<script>

  $(document).ready(function() {
    // Ordenar a tabela de notícias pela data
    $('#noticias-table th').click(function() {
      var orderBy = $(this).text().toLowerCase();
      if (orderBy === 'data') {
        var rows = $('tbody tr', '#noticias-table').sort(function(a, b) {
          var dateA = new Date($(a).find('td:nth-child(3)').text());
          var dateB = new Date($(b).find('td:nth-child(3)').text());
          return dateB - dateA;
        });
        $('tbody', '#noticias-table').html(rows);
      }
    });

    // Pesquisar o título da notícia
    $('#search-input').on('input', function() {
      var searchTerm = $(this).val().toLowerCase();
      $('#noticias-table tbody tr').each(function() {
        var titulo = $(this).find('td:first-child').text().toLowerCase();
        if (titulo.includes(searchTerm)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });

    // Adicionar notícia à lista de notícias escolhidas
    $('#noticias-table').on('click', '.add-noticia', function() {
      var noticiaId = $(this).data('noticia-id');
      var noticiaTitulo = $(this).data('noticia-titulo');
      var noticiaExistente = $('#noticias-escolhidas li[data-noticia-id="' + noticiaId + '"]');

      if (noticiaExistente.length === 0) {
        $('#noticias-escolhidas').append('<li class="list-group-item d-flex justify-content-between align-items-center" data-noticia-id="' + noticiaId + '">' + noticiaTitulo + '<span class="badge badge-primary badge-pill remove-noticia">Remover</span></li>');
        $(this).closest('tr').hide();
        var noticia = {
          id: noticiaId,
          titulo: noticiaTitulo
        };
        noticiasEscolhidas.push(noticia);
        sendNoticiasEscolhidasToServer();
      }
    });

    // Remover notícia da lista de notícias escolhidas
    $('#noticias-escolhidas').on('click', '.remove-noticia', function() {
      var noticiaId = $(this).closest('li').data('noticia-id');
      var noticiaIndex = noticiasEscolhidas.findIndex(function(noticia) {
        return noticia.id === noticiaId;
      });

      if (noticiaIndex !== -1) {
        noticiasEscolhidas.splice(noticiaIndex, 1);
        $(this).closest('li').remove();
        sendNoticiasEscolhidasToServer();
        $('#noticias-table tr[data-noticia-id="' + noticiaId + '"]').show();
      }
    });
  });
</script>
<script>
    $('#next').click(function() {
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
</script>

<script>
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

</script>

<script>
function sendNoticiasEscolhidasToServer() {
    $.ajax({
        url: 'preencherCampos.php',
        type: 'POST',
        data: { noticias_escolhidas: noticiasEscolhidas },
        success: function(response) {
            console.log('Session variable updated:', response);
        },
        error: function(xhr, status, error) {
            console.error('Error updating session variable:', error);
        }
    });
}
</script>