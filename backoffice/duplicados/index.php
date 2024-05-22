<?php
require "../verifica.php";
require "../config/basedados.php";
require "./check_duplicates.php";
require "../assets/models/functions.php";

// Define o limite de resultados por página e a página atual. Se não estiverem definidos nos parâmetros GET, assume valores padrão.
$limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Verifica se há um termo de pesquisa e um campo de pesquisa definidos nos parâmetros GET. Caso contrário, assume valores padrão.
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchField = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';
$escapedSearchTerm = $conn->real_escape_string($searchTerm);

// Filtra o status, caso esteja definido nos parâmetros GET. Por defeito, será um array vazio.
$filterStatus = isset($_GET['status']) ? $_GET['status'] : array();

// Verifica se o filtro para títulos numerados está ativo.
$filterNumberedTitles = isset($_GET['numbered_titles']) && $_GET['numbered_titles'] == 'on';

// Inicializa as condições de pesquisa, status e títulos numerados como strings vazias.
$searchCondition = '';
$statusCondition = '';
$numberedTitlesCondition = '';

// Se houver um termo de pesquisa, constrói a condição de pesquisa consoante o campo selecionado.
if (!empty($searchTerm)) {
  if ($searchField == 'all') {
    $searchCondition = "CONCAT_WS(' ', publicacoes, email, title, url) LIKE '%$escapedSearchTerm%'";
  } else {
    $searchCondition = "$searchField LIKE '%$escapedSearchTerm%'";
  }
}

// Se houver filtro de status, constrói a condição correspondente.
if (!empty($filterStatus)) {
  $statusCondition = "status IN ('" . implode("','", $filterStatus) . "')";
}

// Se o filtro de títulos numerados estiver ativo, define a condição correspondente.
if ($filterNumberedTitles) {
  $numberedTitlesCondition = "(
      CASE
          WHEN isRomanOrNumber(getLastWord(SUBSTRING_INDEX(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(title, '$[0].title1')), ' ', -1), ' ', 1))) THEN 1
          WHEN isRomanOrNumber(getLastWord(SUBSTRING_INDEX(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(title, '$[0].title2')), ' ', -1), ' ', 1))) THEN 1
          ELSE 0
      END
  ) = 1";
}

// Filtra as condições para remover entradas vazias e junta-as numa única string.
$conditions = array_filter(array($searchCondition, $statusCondition, $numberedTitlesCondition));
$whereClause = implode(" AND ", $conditions);
$whereClause = $whereClause ? "WHERE $whereClause" : "";

// Função para verificar se uma string é um número romano ou um número.
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

// Função para obter a última palavra de uma string.
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

// Consulta SQL para obter as publicações duplicadas com as condições aplicadas.
// Como estamos a extrair do json das duas string que estao a ser comparadas temos que extrair do json
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

// Conta o total de duplicados para calcular a paginação.
$countQuery = "SELECT COUNT(*) AS total FROM publicacoes_duplicados";
$countResult = $conn->query($countQuery);
$row = $countResult->fetch_assoc();
$total = $row['total'];

// Calcula o total de páginas com base no limite definido.
$totalPages = ceil($total / $limit);

// Define as opções de limite de resultados por página.
$limitOptions = array(5, 10, 20, 50);
$pagination = '';

// Se houver mais de uma página, constrói a navegação da paginação.
if ($totalPages > 1) {
  $pagination .= '<ul class="pagination justify-content-center">';
  $prev = max($page - 1, 1);
  $next = min($page + 1, $totalPages);
  $disabledStart = ($page == 1) ? 'disabled' : '';
  $pagination .= '<li class="page-item ' . $disabledStart . '"><a class="page-link" href="?limit=' . $limit . '&page=1&search=' . urlencode($searchTerm) . '">Início</a></li>';
  $disabledPrev = ($page == 1) ? 'disabled' : '';
  $pagination .= '<li class="page-item ' . $disabledPrev . '"><a class="page-link" href="?limit=' . $limit . '&page=' . $prev . '&search=' . urlencode($searchTerm) . '">Anterior</a></li>';

  for ($i = max(1, $page - 2); $i <= min($page + 2, $totalPages); $i++) {
    $activeClass = ($i == $page) ? 'disabled' : '';
    $pagination .= '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?limit=' . $limit . '&page=' . $i . '&search=' . urlencode($searchTerm) . '">' . $i . '</a></li>';
  }

  $disabledNext = ($page == $totalPages) ? 'disabled' : '';
  $pagination .= '<li class="page-item ' . $disabledNext . '"><a class="page-link" href="?limit=' . $limit . '&page=' . $next . '&search=' . urlencode($searchTerm) . '">Próximo</a></li>';
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
<link rel="stylesheet" href="./style.css">

<!-- Script para exibir mensagens temporárias -->
<script>
  $(document).ready(function() {
    setTimeout(function() {
      $(".alert").fadeOut("slow", function() {
        $(this).remove();
      });
    }, 5000);
  });
</script>

<div class="container-xl">
  <div class="table-responsive">
    <div class="table-wrapper">
      <!-- Formulário de pesquisa -->
      <form method="GET" action="index.php">
        <div class="search-box">
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Procurar..." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary">Pesquisar</button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="search_field">Pesquisar por:</label>
          <?php echo $searchFieldDropdown; ?>
        </div>
        <div class="form-group">
          <label for="limit">Resultados por página:</label>
          <?php echo $limitDropdown; ?>
        </div>
        <div class="form-group">
          <label for="status">Status:</label>
          <div>
            <input type="checkbox" name="status[]" value="1" <?php echo in_array('1', $filterStatus) ? 'checked' : ''; ?>> 1
            <input type="checkbox" name="status[]" value="2" <?php echo in_array('2', $filterStatus) ? 'checked' : ''; ?>> 2
            <input type="checkbox" name="status[]" value="3" <?php echo in_array('3', $filterStatus) ? 'checked' : ''; ?>> 3
            <input type="checkbox" name="status[]" value="4" <?php echo in_array('4', $filterStatus) ? 'checked' : ''; ?>> 4
          </div>
        </div>
        <div class="form-group">
          <input type="checkbox" name="numbered_titles" <?php echo $filterNumberedTitles ? 'checked' : ''; ?>> Títulos Numerados
        </div>
      </form>

      <!-- Tabela de resultados -->
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Publicação 1</th>
            <th>Email 1</th>
            <th>Título 1</th>
            <th>URL 1</th>
            <th>Publicação 2</th>
            <th>Email 2</th>
            <th>Título 2</th>
            <th>URL 2</th>
            <th>Percentual Título</th>
            <th>Percentual URL</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['publicacao1']}</td>
                      <td>{$row['email1']}</td>
                      <td>{$row['title1']}</td>
                      <td><a href='{$row['url1']}' target='_blank'>{$row['url1']}</a></td>
                      <td>{$row['publicacao2']}</td>
                      <td>{$row['email2']}</td>
                      <td>{$row['title2']}</td>
                      <td><a href='{$row['url2']}' target='_blank'>{$row['url2']}</a></td>
                      <td>{$row['percenttitle']}%</td>
                      <td>{$row['percenturl']}%</td>
                      <td>{$row['status']}</td>
                      <td>
                        <a href='update_status.php?id={$row['id']}&status=1' class='btn btn-success btn-sm'>1</a>
                        <a href='update_status.php?id={$row['id']}&status=2' class='btn btn-warning btn-sm'>2</a>
                        <a href='update_status.php?id={$row['id']}&status=3' class='btn btn-danger btn-sm'>3</a>
                        <a href='update_status.php?id={$row['id']}&status=4' class='btn btn-secondary btn-sm'>4</a>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='13'>Nenhum resultado encontrado</td></tr>";
          }
          ?>
        </tbody>
      </table>
      <?php echo $pagination; ?>
    </div>
  </div>
</div>

<?php
$conn->close();
?>