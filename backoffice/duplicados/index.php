<?php
require "../verifica.php";
require "../config/basedados.php";
require "./check_duplicates.php";
require "../assets/models/functions.php";

$limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchField = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
$escapedSearchTerm = $conn->real_escape_string($searchTerm);

$filterStatus = isset($_GET['status']) ? $_GET['status'] : array();

$filterNumberedTitles = isset($_GET['numbered_titles']) && $_GET['numbered_titles'] == 'on';

$searchCondition = '';
$statusCondition = '';
$numberedTitlesCondition = '';

if (!empty($searchTerm)) {
  if ($searchField == 'all') {
    $searchCondition = "CONCAT_WS(' ', publicacoes, email, title, url) LIKE '%$escapedSearchTerm%'";
  } else {
    $searchCondition = "$searchField LIKE '%$escapedSearchTerm%'";
  }
}

if (!empty($filterStatus)) {
  $statusCondition = "status IN ('" . implode("','", $filterStatus) . "')";
}

if ($filterNumberedTitles) {
  $numberedTitlesCondition = "(
      CASE
          WHEN isRomanOrNumber(getLastWord(SUBSTRING_INDEX(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(title, '$[0].title1')), ' ', -1), ' ', 1))) THEN 1
          WHEN isRomanOrNumber(getLastWord(SUBSTRING_INDEX(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(title, '$[0].title2')), ' ', -1), ' ', 1))) THEN 1
          ELSE 0
      END
  ) = 1";
}

$conditions = array_filter(array($searchCondition, $statusCondition, $numberedTitlesCondition));
$whereClause = implode(" AND ", $conditions);
$whereClause = $whereClause ? "WHERE $whereClause" : "";

function isRomanOrNumber($str)
{
  if (ctype_digit($str)) {
    return true;
  }
  $pattern = '/^M{0,3}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/';
  if (preg_match($pattern, $str)) {
    return true;
  }
  return false;
}

function getLastWord($str)
{
  $str = trim($str);
  if (strpos($str, ' ') === false) {
    return substr($str, 0, -1);
  }
  $words = explode(' ', $str);
  $lastWord = array_pop($words);
  return substr($lastWord, 0, -1);
}

$sql = "SELECT  id,

                status,

                JSON_UNQUOTE(JSON_EXTRACT(publicacoes, '$[0].id1')) as publicacao1,
                JSON_UNQUOTE(JSON_EXTRACT(publicacoes, '$[0].id2')) as publicacao2,

                JSON_UNQUOTE(JSON_EXTRACT(email, '$[0].email1')) as email1,
                JSON_UNQUOTE(JSON_EXTRACT(email, '$[0].email2')) as email2,

                JSON_UNQUOTE(JSON_EXTRACT(title, '$[0].title1')) as title1,
                JSON_UNQUOTE(JSON_EXTRACT(title, '$[0].title2')) as title2,
                JSON_UNQUOTE(JSON_EXTRACT(title, '$[0].percenttitle')) as percenttitle,

                JSON_UNQUOTE(JSON_EXTRACT(url, '$[0].url1')) as url1,
                JSON_UNQUOTE(JSON_EXTRACT(url, '$[0].url2')) as url2,
                JSON_UNQUOTE(JSON_EXTRACT(url, '$[0].percenturl')) as percenturl

                FROM publicacoes_duplicados

                $whereClause
                
                LIMIT $start, $limit";

$result = mysqli_query($conn, $sql);

$countQuery = "SELECT COUNT(*) AS total FROM publicacoes_duplicados";
$countResult = $conn->query($countQuery);
$row = $countResult->fetch_assoc();
$total = $row['total'];

$totalPages = ceil($total / $limit);

$limitOptions = array(5, 10, 20, 50);
/* calcular o total de páginas */
$totalPages = ceil($total / $limit);
$pagination = '';

if ($totalPages > 1) {
  $pagination .= '<ul class="pagination justify-content-center">';
  $prev = max($page - 1, 1);
  $next = min($page + 1, $totalPages);
  /* se estiver no início, desabilitar o botão */
  $disabledStart = ($page == 1) ? 'disabled' : '';
  $pagination .= '<li class="page-item ' . $disabledStart . '"><a class="page-link" href="?limit=' . $limit . '&page=1&search=' . urlencode($searchTerm) . '">Início</a></li>';

  /* se não for possível andar para trás, desabilitar o botão */
  $disabledPrev = ($page == 1) ? 'disabled' : '';
  $pagination .= '<li class="page-item ' . $disabledPrev . '"><a class="page-link" href="?limit=' . $limit . '&page=' . $prev . '&search=' . urlencode($searchTerm) . '">Anterior</a></li>';

  for ($i = max(1, $page - 2); $i <= min($page + 2, $totalPages); $i++) {
    $activeClass = ($i == $page) ? 'disabled' : '';
    $pagination .= '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?limit=' . $limit . '&page=' . $i . '&search=' . urlencode($searchTerm) . '">' . $i . '</a></li>';
  }

  /* se não for possível andar para a frente, desabilitar o botão */
  $disabledNext = ($page == $totalPages) ? 'disabled' : '';
  $pagination .= '<li class="page-item ' . $disabledNext . '"><a class="page-link" href="?limit=' . $limit . '&page=' . $next . '&search=' . urlencode($searchTerm) . '">Próximo</a></li>';

  /* se estiver no fim, desabilitar o botão */
  $disabledEnd = ($page == $totalPages) ? 'disabled' : '';
  $pagination .= '<li class="page-item ' . $disabledEnd . '"><a class="page-link" href="?limit=' . $limit . '&page=' . $totalPages . '&search=' . urlencode($searchTerm) . '">Fim</a></li>';
  $pagination .= '</ul>';

  $limitDropdown = '<select name="limit">';
  foreach ($limitOptions as $option) {
    $selected = ($option == $limit) ? 'selected' : '';
    $limitDropdown .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
  }
  $limitDropdown .= '</select>';

  $searchFields = array('all', 'publicacoes', 'email', 'title', 'url');
  $searchFieldDropdown = '<select name="search_field">';
  foreach ($searchFields as $field) {
    $selected = ($field == $searchField) ? 'selected' : '';
    $searchFieldDropdown .= '<option value="' . $field . '" ' . $selected . '>' . $field . '</option>';
  }
  $searchFieldDropdown .= '</select>';
}
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
  ?><style>.pagination .page-item.disabled .page-link {
    background-color: #eeeeee;
    border-color: #aaaaaa;
    color: #343a40;
  }

  .pagination .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #ffffff;
  }

  .pagination .page-link:hover {
    background-color: #aae0f0;
    border-color: #007bff;
    color: #ffffff;
  }

  .pagination .page-link:active {
    background-color: #aae0f0;
    border-color: #007bff;
    color: #ffffff;
  }
</style>
</style>

<div class="container-xxl mx-4 my-4">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6">
          <h2 data-translation="duplicated-title">Duplicados</h2>
        </div>
        <div class="col-sm-6">
          <form method="post" action="check_duplicates.php">
            <input type="submit" class="btn btn-success" name="insert_data" value="Atualizar Análise de Publicações">
          </form>
        </div>
      </div>
    </div>

    <form action="" method="get" class="row mb-3 align-items-center">
      <div class="col-auto mx-4 my-4">
        <span data-translation="duplicated-show">Mostrar:</span> <?php echo $limitDropdown; ?> Resultados
      </div>
      <div class="col">
        <div class="input-group">
          <input class="form-control" type="text" name="search" placeholder="Inserir pesquisa" value="<?php echo $searchTerm; ?>">
          <div class="input-group-append">
            <?php echo $searchFieldDropdown; ?>
            <button type="submit" class="btn btn-primary">
              <img name="search-icon" src="../assets/icons/search.svg" style="width:20px">
            </button>
          </div>
        </div>
      </div>

      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="status[]" value="Por Verificar" <?php echo in_array('Por Verificar', $filterStatus) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="inlineCheckbox1" data-translation="duplicated-filter-unverified">Por Verificar</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="status[]" value="Aguarda Alteração" <?php echo in_array('Aguarda Alteração', $filterStatus) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="inlineCheckbox2" data-translation="duplicated-filter-awaiting-change">Aguarda Alteração</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="status[]" value="Verificado" <?php echo in_array('Verificado', $filterStatus) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="inlineCheckbox3" data-translation="duplicated-filter-verified">Verificado</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="numbered_titles" <?php echo $filterNumberedTitles ? 'checked' : ''; ?>>
        <label class="form-check-label" for="inlineCheckbox4" data-translation="duplicated-filter-numbered-titles">Títulos Numerados</label>
      </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <div class="dropdown-menu" aria-labelledby="updateBtn">
        <a class="dropdown-item" href="#" data-option="Por Verificar">Por Verificar</a>
        <a class="dropdown-item" href="#" data-option="Aguarda Alteração">Aguarda Alteração</a>
        <a class="dropdown-item" href="#" data-option="Verificado">Verificado</a>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-auto">
        <div class="col-auto ml-auto mx-4 my-4">
          <?php echo $pagination; ?>
        </div>
      </div>
      <div class="col-auto row">
        <button class="btn btn-primary my-4 mx-4" type="button" id="updateBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled data-translation="duplicated-button-update-state">
          Atualizar Estado
        </button>
      </div>
      </form>
    </div>

    <form id="update-form" action="update.php" method="post">
      <table id="resizeMe" class="table table-striped table-hover" style="width:100%; table-layout:fixed; word-wrap:break-word;">
        <thead>
          <tr>
            <th style="width:4%"><input type="checkbox" id="select-all-checkbox"></th>
            <th style="width:10%" data-translation="duplicated-table-state">Estado</th>
            <th style="width:10%">Id</th>
            <th style="width:10%">E-Mail</th>
            <th style="width:30%" data-translation="duplicated-table-title">Title</th>
            <th style="width:25%">url</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr border-top: 3px solid black;'>";
              echo "<td rowspan='2'>" . "<input type='checkbox' name='ids[]' value='" . $row['id'] . "'>" . "</td>";
              echo "<td rowspan='2'>" . $row['status'] . "</td>";
              echo "<td rowspan='1'>" . $row['publicacao1'] . "</td>";
              echo "<td rowspan='1'>" . $row['email1'] . "</td>";
              echo "<td rowspan='1'>" . stripslashes(stripslashes($row['title1'])) . "</td>";
              echo "<td rowspan='1' >" . $row['url1'] . "</td>";
              echo "</tr>";

              echo "<tr>";
              echo "<td rowspan='1'>" . $row['publicacao2'] . "</td>";
              echo "<td rowspan='1'>" . $row['email2'] . "</td>";
              echo "<td rowspan='1'>" . stripslashes(stripslashes($row['title2'])) . "</td>";
              echo "<td rowspan='1' >" . $row['url2'] . "</td>";
              echo "</tr>";
              echo "<tr style='border-bottom: 3px solid black;'>";
              echo "</tr>";
            }
          }
          ?>
        </tbody>
      </table>
    </form>
  </div>

  <script>
    $(document).ready(function() {
      var tableCheckboxes = $('form#update-form input[type="checkbox"]');
      var updateBtn = $('#updateBtn');
      var columnDropdown = $('#columnDropdown');

      // Close the column dropdown when the update dropdown is opened
      updateBtn.on('click', function() {
        columnDropdown.dropdown('hide');
      });

      // Close the update dropdown when the column dropdown is opened
      columnDropdown.on('click', function() {
        updateBtn.dropdown('hide');
      });

      // Close the column dropdown when clicking outside
      $(document).on('click', function(e) {
        if (!columnDropdown.is(e.target) && !columnDropdownMenu.is(e.target) && columnDropdownMenu.has(e.target).length === 0) {
          columnDropdown.dropdown('show');
        }
      })

      tableCheckboxes.on('change', function() {
        var selectedCheckboxes = tableCheckboxes.filter(':checked');
        if (selectedCheckboxes.length > 0) {
          updateBtn.removeClass('update-btn').addClass('update-btn active').prop('disabled', false);
        } else {
          updateBtn.removeClass('update-btn active').addClass('update-btn').prop('disabled', true);
        }
      });

      $('.dropdown-item').on('click', function(e) {
        e.preventDefault();
        var option = $(this).data('option');
        var selectedIds = tableCheckboxes.filter(':checked').map(function() {
          return $(this).val();
        }).get();

        if (selectedIds.length > 0) {
          $.ajax({
            type: "POST",
            url: "update.php",
            data: {
              ids: selectedIds,
              selected_state: option
            },
            success: function(response) {
              location.reload();
            }
          });
        }
      });
    });
  </script>

  <script>
    document.getElementById('select-all-checkbox').addEventListener('change', function() {
      var checkboxes = document.querySelectorAll('form#update-form input[type="checkbox"]');
      checkboxes.forEach(function(checkbox) {
        checkbox.checked = document.getElementById('select-all-checkbox').checked;
      });
    });
  </script>


  <?php
  mysqli_close($conn);
  ?>