<?php
require "../verifica.php";
require "../config/basedados.php";

$limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchField = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
$escapedSearchTerm = $conn->real_escape_string($searchTerm);

$searchCondition = '';

if (!empty($searchTerm)) {
  if ($searchField == 'all') {
    $searchCondition = "CONCAT_WS(' ', email, dados) LIKE '%$escapedSearchTerm%'";
  } else {
    $searchCondition = "$searchField LIKE '%$escapedSearchTerm%'";
  }
}

if (!empty($filterStatus)) {
  $statusCondition = "status IN ('" . implode("','", $filterStatus) . "')";
}

$conditions = array_filter(array($searchCondition));
$whereClause = implode(" AND ", $conditions);
$whereClause = $whereClause ? "WHERE $whereClause" : "";

$sql = "SELECT idPublicacao as id, i.email as email, REGEXP_SUBSTR(dados, 'title = {(.*?)}') as title,
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
JOIN investigadores AS i ON pi2.investigador = i.id

                $whereClause
                
                LIMIT $start, $limit";

$result = mysqli_query($conn, $sql);

$countQuery = "SELECT COUNT(*) AS total FROM publicacoes";
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
}

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

  .pagination .page-item.disabled .page-link {
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
          <h2 data-translation='publications-title'>Publicações</h2>
        </div>
      </div>
    </div>

    <form action="" method="get" class="row mb-3 align-items-center">
      <div class="col-auto mx-4 my-4">
        <span data-translation="duplicated-show">Mostrar:</span> <?php echo $limitDropdown; ?> entradas
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
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <div class="col-auto ml-auto mx-4 my-4">
        <?php echo $pagination; ?>
      </div>
    </div>
    </form>

  </div>
  </form>
  <table id="resizeMe" class="table" style="width:100%; table-layout:fixed; word-wrap:break-word;" class="table table-striped table-hover">
    <thead>


      <tr style="width:100%">
        <th style="width:5%">Id</th>
        <th style="width:10%">Email</th>
        <th style="width:30%" data-translation='publications-table-title'>Title</th>
        <th data-translation='publications-table-journal'>Journal</th>
        <th>Volume</th>
        <th data-translation='publications-table-number'>Number</th>
        <th data-translation='publications-table-pages'>Pages</th>
        <th data-translation='publications-table-year'>Year</th>
        <th style="width:9%">url</th>
        <th data-translation='publications-table-author'>Author</th>
        <th data-translation='publications-table-keywords'>Keywords</th>
      </tr>
    </thead>
    <tbody>

      <?php
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row["id"] . "</td>";
          echo "<td>" . $row["email"] . "</td>";
          echo "<td>" . $row["title"] . "</td>";
          echo "<td>" . $row["journal"] . "</td>";
          echo "<td>" . $row["volume"] . "</td>";
          echo "<td>" . $row["pnumber"] . "</td>";
          echo "<td>" . $row["pages"] . "</td>";
          echo "<td>" . $row["pyear"] . "</td>";
          echo "<td>" . $row["purl"] . "</td>";
          echo "<td>" . $row["author"] . "</td>";
          echo "<td>" . $row["keywords"] . "</td>";
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