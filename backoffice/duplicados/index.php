<?php
require "../verifica.php";
require "../config/basedados.php";
require "./check_duplicates.php";

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
    $searchCondition = "CONCAT_WS(' ', publicacoes, email, title, journal, volume, numbers, pages, years, url, authors, keywords) LIKE '%$escapedSearchTerm%'";
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

                JSON_UNQUOTE(JSON_EXTRACT(journal, '$[0].journal1')) as journal1,
                JSON_UNQUOTE(JSON_EXTRACT(journal, '$[0].journal2')) as journal2,
                JSON_UNQUOTE(JSON_EXTRACT(journal, '$[0].percentjournal')) as percentjournal,

                JSON_UNQUOTE(JSON_EXTRACT(volume, '$[0].volume1')) as volume1,
                JSON_UNQUOTE(JSON_EXTRACT(volume, '$[0].volume2')) as volume2,
                JSON_UNQUOTE(JSON_EXTRACT(volume, '$[0].percentvolume')) as percentvolume,

                JSON_UNQUOTE(JSON_EXTRACT(numbers, '$[0].number1')) as number1,
                JSON_UNQUOTE(JSON_EXTRACT(numbers, '$[0].number2')) as number2,
                JSON_UNQUOTE(JSON_EXTRACT(numbers, '$[0].percentnumber')) as percentnumber,

                JSON_UNQUOTE(JSON_EXTRACT(pages, '$[0].page1')) as page1,
                JSON_UNQUOTE(JSON_EXTRACT(pages, '$[0].page2')) as page2,
                JSON_UNQUOTE(JSON_EXTRACT(pages, '$[0].percentpage')) as percentpage,

                JSON_UNQUOTE(JSON_EXTRACT(years, '$[0].year1')) as year1,
                JSON_UNQUOTE(JSON_EXTRACT(years, '$[0].year2')) as year2,
                JSON_UNQUOTE(JSON_EXTRACT(years, '$[0].percentyear')) as percentyear,

                JSON_UNQUOTE(JSON_EXTRACT(url, '$[0].url1')) as url1,
                JSON_UNQUOTE(JSON_EXTRACT(url, '$[0].url2')) as url2,
                JSON_UNQUOTE(JSON_EXTRACT(url, '$[0].percenturl')) as percenturl,

                JSON_UNQUOTE(JSON_EXTRACT(authors, '$[0].author1')) as author1,
                JSON_UNQUOTE(JSON_EXTRACT(authors, '$[0].author2')) as author2,
                JSON_UNQUOTE(JSON_EXTRACT(authors, '$[0].percentauthor')) as percentauthor,

                JSON_UNQUOTE(JSON_EXTRACT(keywords, '$[0].keyword1')) as keyword1,
                JSON_UNQUOTE(JSON_EXTRACT(keywords, '$[0].keyword2')) as keyword2,
                JSON_UNQUOTE(JSON_EXTRACT(keywords, '$[0].percentkeyword')) as percentkeyword

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

$pagination = '';
if ($totalPages > 1) {
  $pagination .= '<ul class="pagination">';
  $prev = max($page - 1, 1);
  $next = min($page + 1, $totalPages);

  $pagination .= '<li><a href="?limit=' . $limit . '&page=1&search=' . urlencode($searchTerm) . '&search_field=' . $searchField;
if (!empty($filterStatus)) {
  $pagination .= '&status[]=' . implode('&status[]=', $filterStatus);
}
$pagination .= '">Início</a></li>';

if ($page > 1) {
  $pagination .= '<li><a href="?limit=' . $limit . '&page=' . $prev . '&search=' . urlencode($searchTerm) . '&search_field=' . $searchField;
  if (!empty($filterStatus)) {
    $pagination .= '&status[]=' . implode('&status[]=', $filterStatus);
  }
  $pagination .= '">Anterior</a></li>';
}

for ($i = max(1, $page - 2); $i <= min($page + 2, $totalPages); $i++) {
  $pagination .= '<li><a href="?limit=' . $limit . '&page=' . $i . '&search=' . urlencode($searchTerm) . '&search_field=' . $searchField;
  if (!empty($filterStatus)) {
    $pagination .= '&status[]=' . implode('&status[]=', $filterStatus);
  }
  $pagination .= '">' . $i . '</a></li>';
}

if ($page < $totalPages) {
  $pagination .= '<li><a href="?limit=' . $limit . '&page=' . $next . '&search=' . urlencode($searchTerm) . '&search_field=' . $searchField;
  if (!empty($filterStatus)) {
    $pagination .= '&status[]=' . implode('&status[]=', $filterStatus);
  }
  $pagination .= '">Próximo</a></li>';
}

$pagination .= '<li><a href="?limit=' . $limit . '&page=' . $totalPages . '&search=' . urlencode($searchTerm) . '&search_field=' . $searchField;
if (!empty($filterStatus)) {
  $pagination .= '&status[]=' . implode('&status[]=', $filterStatus);
}
$pagination .= '">Fim</a></li>';
  $pagination .= '</ul>';
}

$limitDropdown = '<select name="limit">';
foreach ($limitOptions as $option) {
  $selected = ($option == $limit) ? 'selected' : '';
  $limitDropdown .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
}
$limitDropdown .= '</select>';

$searchFields = array('all', 'publicacoes', 'email', 'title', 'journal', 'volume', 'numbers', 'pages', 'years', 'url', 'authors', 'keywords'); 
$searchFieldDropdown = '<select name="search_field">';
foreach ($searchFields as $field) {
  $selected = ($field == $searchField) ? 'selected' : '';
  $searchFieldDropdown .= '<option value="' . $field . '" ' . $selected . '>' . $field . '</option>';
}
$searchFieldDropdown .= '</select>';

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
  ?>.update-btn {
    opacity: 0.5;
    pointer-events: none;
  }

  .update-btn.active {
    opacity: 1;
    pointer-events: auto;
  }


  .table {
    border-collapse: collapse;
  }

  .table,
  .table th,
  .table td {
    border: 1px solid #ccc;
  }

  .table th,
  .table td {
    padding: 0.5rem;
  }

  .table th {
    position: relative;
  }

  .resizer {
    position: absolute;
    top: 0;
    right: 0;
    width: 5px;
    cursor: col-resize;
    user-select: none;
  }

  .resizer:hover,
  .resizing {
    border-right: 2px solid blue;
  }

  .resizable {
    border: 1px solid gray;
    height: 100px;
    width: 100px;
    position: relative;
  }
</style>

</style>

<div class="container-xxl">
  <div class="container-xxl">
    <div class="table-responsive">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h2>Duplicados</h2>
            </div>
            <div class="col-sm-6">
              <form method="post" action="check_duplicates.php">
                <input type="submit" class="btn btn-success" name="insert_data" value="Atualizar Análise de Publicações">
              </form>

            </div>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div>

      <form action="" method="get">
        Mostrar: <?php echo $limitDropdown; ?> entradas

        <?php echo $pagination; ?>


        Pesquisar:
        <input type="text" name="search" value="<?php echo $searchTerm; ?>" placeholder="Search term">
        no campo:
        <?php echo $searchFieldDropdown; ?>
        Filtrar por Estado:
        <label><input type="checkbox" name="status[]" value="Por Verificar" <?php echo in_array('Por Verificar', $filterStatus) ? 'checked' : ''; ?>> Por Verificar</label>
        <label><input type="checkbox" name="status[]" value="Aguarda Alteração" <?php echo in_array('Aguarda Alteração', $filterStatus) ? 'checked' : ''; ?>> Aguarda Alteração</label>
        <label><input type="checkbox" name="status[]" value="Verificado" <?php echo in_array('Verificado', $filterStatus) ? 'checked' : ''; ?>> Verificado</label>
        <label><input type="checkbox" name="numbered_titles" <?php echo $filterNumberedTitles ? 'checked' : ''; ?>> Títulos Numerados</label>
        <button type="submit" class="btn btn-primary">Atualizar Campos</button>
      </form>
      <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle update-btn" type="button" id="updateBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
          Atualizar Estado
        </button>
        <div class="dropdown-menu" aria-labelledby="updateBtn">
          <a class="dropdown-item" href="#" data-option="Por Verificar">Por Verificar</a>
          <a class="dropdown-item" href="#" data-option="Aguarda Alteração">Aguarda Alteração</a>
          <a class="dropdown-item" href="#" data-option="Verificado">Verificado</a>
        </div>
      </div>
      <form id="update-form" action="update.php" method="post">
        <table id="resizeMe" class="table" style="width:100%; table-layout:fixed; word-wrap:break-word;" class="table table-striped table-hover">
          <thead>


            <tr style="width:100%">
              <th class="form-check" style="width:5%"><input type="checkbox" id="select-all-checkbox"></th>
              <th style="width:5%">Estado</th>
              <th style="width:10%">Id</th>
              <th style="width:10%">E-Mail</th>
              <th style="width:30%">Title</th>
              <th>Journal</th>
              <th>Volume</th>
              <th>Number</th>
              <th>Pages</th>
              <th>Year</th>
              <th style="width:9%">url</th>
              <th>Author</th>
              <th>Keywords</th>
            </tr>
          </thead>
          <tbody>

            <?php
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr border-top: 3px solid black;'>";
                echo "<td rowspan='3'>" . "<input type='checkbox' name='ids[]' value='" . $row['id'] . "'>" . "</td>";
                echo "<td rowspan='3'>" . $row['status'] . "</td>";
                echo "<td rowspan='1'>" . $row['publicacao1'] . "</td>";
                echo "<td rowspan='1'><a href='mailto:" . $row['email1'] . "'>" . $row['email1'] . "</a></td>";
                echo "<td rowspan='1'>" . stripslashes(stripslashes($row['title1'])) . "</td>";
                echo "<td rowspan='1'>" . $row['journal1'] . "</td>";
                echo "<td rowspan='1'>" . $row['volume1'] . "</td>";
                echo "<td rowspan='1'>" . $row['number1'] . "</td>";
                echo "<td rowspan='1'>" . $row['page1'] . "</td>";
                echo "<td rowspan='1'>" . $row['year1'] . "</td>";
                echo "<td rowspan='1' style='width:9%' >" . $row['url1'] . "</td>";
                echo "<td rowspan='1'>" . $row['author1'] . "</td>";
                echo "<td rowspan='1'>" . $row['keyword1'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td rowspan='1'>" . $row['publicacao2'] . "</td>";
                echo "<td rowspan='1'><a href='mailto:" . $row['email2'] . "'>" . $row['email2'] . "</a></td>";
                echo "<td rowspan='1'>" . stripslashes(stripslashes($row['title2'])) . "</td>";
                echo "<td rowspan='1'>" . $row['journal2'] . "</td>";
                echo "<td rowspan='1'>" . $row['volume2'] . "</td>";
                echo "<td rowspan='1'>" . $row['number2'] . "</td>";
                echo "<td rowspan='1'>" . $row['page2'] . "</td>";
                echo "<td rowspan='1'>" . $row['year2'] . "</td>";
                echo "<td rowspan='1' style='width:9%' >" . $row['url2'] . "</td>";
                echo "<td rowspan='1'>" . $row['author2'] . "</td>";
                echo "<td rowspan='1'>" . $row['keyword2'] . "</td>";
                echo "</tr>";

                echo "<tr style='border-bottom: 3px solid black;'>";
                echo "<td rowspan='1'></td>";
                echo "<td rowspan='1'></td>";
                echo "<td rowspan='1'>" . round($row['percenttitle']) . "</td>";
                echo "<td rowspan='1'>" . round($row['percentjournal']) . "</td>";
                echo "<td rowspan='1'>" . round($row['percentvolume']) . "</td>";
                echo "<td rowspan='1'>" . round($row['percentnumber']) . "</td>";
                echo "<td rowspan='1'>" . round($row['percentpage']) . "</td>";
                echo "<td rowspan='1'>" . round($row['percentyear']) . "</td>";
                echo "<td rowspan='1' style='width:9%' >" . round($row['percenturl']) . "</td>";
                echo "<td rowspan='1'>" . round($row['percentauthor']) . "</td>";
                echo "<td rowspan='1'>" . round($row['percentkeyword']) . "</td>";
                echo "</tr>";
              }
            }

            ?>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var tableCheckboxes = $('form#update-form input[type="checkbox"]');
    var updateBtn = $('#updateBtn');

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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const createResizableTable = function(table) {
      const cols = table.querySelectorAll('th');
      [].forEach.call(cols, function(col) {

        const resizer = document.createElement('div');
        resizer.classList.add('resizer');

        resizer.style.height = `${table.offsetHeight}px`;

        col.appendChild(resizer);

        createResizableColumn(col, resizer);
      });
    };

    const createResizableColumn = function(col, resizer) {
      let x = 0;
      let w = 0;

      const mouseDownHandler = function(e) {
        x = e.clientX;

        const styles = window.getComputedStyle(col);
        w = parseInt(styles.width, 10);

        document.addEventListener('mousemove', mouseMoveHandler);
        document.addEventListener('mouseup', mouseUpHandler);

        resizer.classList.add('resizing');
      };

      const mouseMoveHandler = function(e) {
        const dx = e.clientX - x;
        col.style.width = `${w + dx}px`;
      };

      const mouseUpHandler = function() {
        resizer.classList.remove('resizing');
        document.removeEventListener('mousemove', mouseMoveHandler);
        document.removeEventListener('mouseup', mouseUpHandler);
      };

      resizer.addEventListener('mousedown', mouseDownHandler);
    };

    createResizableTable(document.getElementById('resizeMe'));
  });
</script>

<?php
mysqli_close($conn);
?>