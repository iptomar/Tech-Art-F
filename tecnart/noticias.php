<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

$language = ($_SESSION["lang"] == "en") ? "_en" : "";
$query = "";

$limit = 9;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$query = "SELECT id,
        COALESCE(NULLIF(titulo{$language}, ''), titulo) AS titulo,
        COALESCE(NULLIF(conteudo{$language}, ''), conteudo) AS conteudo,
        imagem,data
        FROM noticias WHERE data<=NOW() ORDER BY DATA DESC LIMIT $start, $limit";
/* obter a quantidade de notícias */
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM noticias");
$total = (int) $stmt->fetchColumn();

$stmt = $pdo->prepare($query);
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

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
   $disabledNext =($page == $totalPages) ? 'disabled' : '';
   $pagination .= '<li class="page-item ' . $disabledNext . '"><a class="page-link" href="?limit=' . $limit . '&page=' . $next . '&search=' . urlencode($searchTerm) . '">Próximo</a></li>';
   /* se estiver no fim, desabilitar o botão */
   $disabledEnd = ($page == $totalPages) ? 'disabled' : '';
   $pagination .= '<li class="page-item ' . $disabledEnd . '"><a class="page-link" href="?limit=' . $limit . '&page=' . $totalPages . '&search=' . urlencode($searchTerm) . '">Fim</a></li>';
   $pagination .= '</ul>';
}
?>
<!DOCTYPE html>
<html>
<head>
   <style>
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
</head>
<?= template_header('Notícias'); ?>
<section class="product_section layout_padding">
   <div style="background-color: #dbdee1; padding-top: 50px; padding-bottom: 50px;">
      <div class="container">
         <div class="heading_container3">
            <h3 style="margin-bottom: 5px;">
               <?= change_lang("news-page-heading") ?>
            </h3>
            <h5 class="heading2_h5">
               <?= change_lang("news-page-heading-desc") ?>
            </h5>
         </div>
      </div>
   </div>
</section>
<section class="product_section layout_padding">
   <div style="padding-top: 20px;">
      <div class="container">
         <div class="row justify-content-center mt-3">
            <div class="col-md-6">
               <!-- Formulário de pesquisa -->
               <input id="searchInput" type="text" class="form-control" placeholder="Título da noticia a pesquisar" style="max-width: 500px; min-width: 450px; display: inline-block; text-transform: none;">
            </div>
         </div>

         <div id="searchResults" class="row justify-content-center mt-3"></div>

         <?php echo $pagination; ?>
         <div id="news-list" class="row justify-content-center mt-3">
            <?php foreach ($noticias as $noticia): ?>
               <div class="ml-5 imgList">
                  <a href="noticia.php?noticia=<?= $noticia['id'] ?>">
                     <div class="image_default">
                        <img class="centrare" style="object-fit: cover; width:225px; height:280px;"
                           src="../backoffice/assets/noticias/<?= $noticia['imagem'] ?>" alt="">
                        <div class="imgText justify-content-center m-auto" style="top:75%">
                           <?php
                           $titulo = trim($noticia['titulo']);
                           if (strlen($noticia['titulo']) > 35) {
                              $titulo = preg_split("/\s+(?=\S*+$)/", substr($noticia['titulo'], 0, 35))[0];
                           }
                           echo ($titulo != trim($noticia['titulo'])) ? $titulo . "..." : $titulo;
                           ?>
                        </div>
                        <h6 class="imgText m-auto" style="font-size: 11px; font-weight: 100; top:95%">
                           <?= date("d.m.Y", strtotime($noticia['data'])) ?>
                        </h6>
                     </div>
                  </a>
               </div>
            <?php endforeach; ?>
         </div>
         <?php echo $pagination; ?>
      </div>
   </div>
</section>
<?= template_footer(); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('#searchInput');
        const searchResults = document.querySelector('#searchResults');
        const newsList = document.querySelector('#news-list');

        function createNewsItem(news) {
            const newsItem = document.createElement('div');
            newsItem.classList.add('ml-5', 'imgList');

            const link = document.createElement('a');
            link.href = `noticia.php?noticia=${news.id}`;

            const imageDiv = document.createElement('div');
            imageDiv.classList.add('image_default');

            const image = document.createElement('img');
            image.classList.add('centrare');
            image.style.objectFit = 'cover';
            image.style.width = '225px';
            image.style.height = '280px';
            image.src = `../backoffice/assets/noticias/${news.imagem}`;
            image.alt = '';

            const titleDiv = document.createElement('div');
            titleDiv.classList.add('imgText', 'justify-content-center', 'm-auto');
            titleDiv.style.top = '75%';

            let titulo = news.titulo.trim();
            if (titulo.length > 35) {
               titulo = titulo.substr(0, 35).split(/\s+(?=\S*$)/)[0];
            }
            titleDiv.textContent = (titulo !== news.titulo.trim()) ? titulo + "..." : titulo;

            const dateDiv = document.createElement('h6');
            dateDiv.classList.add('imgText', 'm-auto');
            dateDiv.style.fontSize = '11px';
            dateDiv.style.fontWeight = '100';
            dateDiv.style.top = '95%';
            dateDiv.textContent = new Date(news.data).toLocaleDateString('pt-PT');

            imageDiv.appendChild(image);
            imageDiv.appendChild(titleDiv);
            imageDiv.appendChild(dateDiv);
            link.appendChild(imageDiv);
            newsItem.appendChild(link);

            return newsItem;
        }

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim();
            const context = 'titulo';

            fetch(`search.php?query=${encodeURIComponent(query)}&context=${encodeURIComponent(context)}&origin=noticias`)
                .then(response => response.json())
                .then(data => {
                    newsList.style.display = 'none';
                    searchResults.innerHTML = '';
                    if (Array.isArray(data)) {
                        data.forEach((result) => {
                            const resultItem = createNewsItem(result);
                            searchResults.appendChild(resultItem);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                });
        });
    });
</script>
</body>
</html>