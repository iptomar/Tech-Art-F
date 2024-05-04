<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

$language = ($_SESSION["lang"] == "en") ? "_en" : "";
$query = "";

$limit = 9;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

#se o botao do reload for clicado mostra todas as noticias 
if (isset($_POST["limpaFiltro"])) {
   $query = "SELECT id,
        COALESCE(NULLIF(titulo{$language}, ''), titulo) AS titulo,
        COALESCE(NULLIF(conteudo{$language}, ''), conteudo) AS conteudo,
        imagem,data
        FROM noticias WHERE data<=NOW() ORDER BY DATA DESC LIMIT $start, $limit;";
}


#se o botão do pesquisar for clicado mostra o/os investigadores que contem esse nome  
else if (isset($_GET["pesquisaNoticia"])) {
   $query = "SELECT id,
   COALESCE(NULLIF(titulo{$language}, ''), titulo) AS titulo,
   COALESCE(NULLIF(conteudo{$language}, ''), conteudo) AS conteudo,
   imagem,data
   FROM noticias WHERE data<=NOW() and titulo LIKE '%{$_GET["pesquisaNoticia"]}%' ORDER BY DATA DESC;";
}
#caso nehum botao seja clicado mostra todos 
else {
   $query = "SELECT id,
        COALESCE(NULLIF(titulo{$language}, ''), titulo) AS titulo,
        COALESCE(NULLIF(conteudo{$language}, ''), conteudo) AS conteudo,
        imagem,data
        FROM noticias WHERE data<=NOW() ORDER BY DATA DESC LIMIT $start, $limit";
}

$stmt = $pdo->prepare($query);
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

/* obter a quantidade de notícias */
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM noticias");
$total = (int) $stmt->fetchColumn();

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


            <div class="col-">
               <!--Formolario que permite pesquisa o ivestigasdor por nome-->
               <form class="form-check form-check-inline" id="formPesquisaNoticia" method="get">
                  <input type=" text" name="pesquisaNoticia" placeholder="Título da noticia a pesquisar"
                     style="max-width: 500px; min-width: 450px; display: inline-block; text-transform: none;  ">
            </div>
            <div class="col-">
               <button type="submit" style="height: 50px; margin-right:10px;">
                  <img name="search-icon" src='assets/icons/search.svg' style="width:40px">
               </button>
               </form>
            </div>
            <div class="col-">
               <!--Formulario que permite limpar a pesquisa feita pelo utilizador-->
               <form id="formLimpaFiltroNoticias" method="post">
                  <button type="submit" style="height: 50px;" name="limpaFiltro" value="vertodos"> <img
                        name="reload_icon" src='assets\icons\reload.svg' style="width:35px"></button>
               </form>
            </div>
         </div>
         <?php echo $pagination; ?>
         <div class="row justify-content-center mt-3">
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

</body>

</html>