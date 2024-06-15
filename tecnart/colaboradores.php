<?php

include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();
$language = ($_SESSION["lang"] == "en") ? "_en" : "";

#recebe a query que pesquisa pelos colaborador 
$query = "";
#variaveis para  a paginação dos investigadores
$limit = 9;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
#Variavel que Contem parte da string para preencher o place holder 
$placeholder = "Pesquisar Colaborador por Nome ";
$query = "SELECT id, email, nome,
          COALESCE(NULLIF(sobre{$language}, ''), sobre) AS sobre,
          COALESCE(NULLIF(areasdeinteresse{$language}, ''), areasdeinteresse) AS areasdeinteresse,
          ciencia_id, tipo, fotografia, orcid, scholar, research_gate, scopus_id
          FROM investigadores WHERE tipo = \"Colaborador\" ORDER BY nome LIMIT $start, $limit";

   /* Obter a quantidade total de investigadores */
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM investigadores WHERE tipo = \"Colaborador\"");
$total = (int) $stmt->fetchColumn();

$stmt = $pdo->prepare($query);
$stmt->execute();
$investigadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
#Cria a lista paginada dos infestigadores 
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
   $pagination .= '</ul>';}

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

<?= template_header('Colaboradores'); ?>

<!-- product section -->
<section class="product_section layout_padding">
   <div style="background-color: #dbdee1; padding-top: 50px; padding-bottom: 50px;">
      <div class="container">
         <div class="heading_container3">

            <h3 style="margin-bottom: 5px;">
               <?= change_lang("colaborative-researchers-page-heading") ?>
            </h3>

            <h5 class="heading2_h5">
               <?= change_lang("colaborative-researchers-page-heading-desc") ?>
            </h5>

         </div>
      </div>
   </div>
</section>
<section class="product_section layout_padding">
   <div>
      <div class="container">
         <div class="row justify-content-center mt-3">
            <div class="col-">
               <!--Formolario que permite pesquisa o ivestigador -->
               <form class="form-check form-check-inline">
                  <input type="text" id="searchInput" placeholder="<?php echo $placeholder ?>"
                        style="max-width: 500px; min-width: 450px; display: inline-block; text-transform: none; margin-right: 5px;  height: 40px;">
            </div>
            <!--Select para selecionar o campo pelo  qual se quer perquisar  o investigador-->
            <select class="form-select form-select-lg mb-3" name="selectContext" id="selectContext"  onchange="atualizaPlaceHolder()">
               <option value="nome">Nome</option>
               <option value="email">Email</option>
               <option value="ciencia_id">Ciência ID</option>
               <option value="orcid">Orcid</option>
            </select>
            </form>
         </div>
         <?php echo $pagination; ?>
         <div id="productListing" class="row justify-content-center mt-3">
            <?php foreach ($investigadores as $investigador): ?>
               <div class="ml-5 imgList">
                  <a href="colaborador.php?colaborador=<?= $investigador['id'] ?>">
                     <div class="image_default">
                        <img class="centrare" style="object-fit: cover; width:225px; height:280px;"
                           src="../backoffice/assets/investigadores/<?= $investigador['fotografia'] ?>" alt="">
                        <div class="imgText justify-content-center m-auto"><?= $investigador['nome'] ?></div>
                     </div>
                  </a>
               </div>
            <?php endforeach; ?>
         </div>

         <div class="row justify-content-center mt-3">
            <div class="col-md-9">
               <div id="searchResults"></div>
            </div>
         </div>
      </div>
         <?php echo $pagination; ?>
      </div>
         </div>


         <!--             <div class="row justify-content-center mt-3">
               
               <div  class="ml-4 imgList">
               
                  <div  class="image_default">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/joana-bento-rodrigues.jpg" alt="">
                     <div class="imgText justify-content-center m-auto">teresa silva</div>
                  </div>  
               
               </div>

               <div class="ml-4 imgList">

                  <div  class="image_default">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/maisum.jpg" alt="">
                     <div class="imgText justify-content-center m-auto">josé constâncio</div>
                  </div>

               </div>

               <div class="ml-4 imgList">
               
                  <div class="image_default">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/pexels-photo-2272853.jpeg" alt="">
                     <div class="imgText justify-content-center m-auto">josefa vasconcelos</div>
                  </div>


               </div>
   
            </div>


            <div class="row justify-content-center mt-3">
               
               <div  class="ml-4 imgList">
               
                  <div  class="image_default">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/whatsapp-image-2021.jpg" alt="">
                     <div class="imgText justify-content-center m-auto">ana maria simões</div>
                  </div>  
               
               </div>

               <div class="ml-4 imgList">

                  <div  class="image_default">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/55918.jpg" alt="">
                     <div class="imgText justify-content-center m-auto">maria bettencourt</div>
                  </div>

               </div>

               <div class="ml-4 imgList">
               
                  <div class="image_default">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/5591801.jpg" alt="">
                     <div class="imgText justify-content-center m-auto">cristina marques</div>
                  </div>


               </div>
            
            </div> -->


      </div>

   </div>
</section>
<script>
   // metodo java scrip para altera o placeholder no input pesquisar 
   function atualizaPlaceHolder(){
     var index = document.getElementById("selectContext").selectedIndex; 
     var option = document.getElementById("selectContext").options;
     var text = "Pesquisar Colaborador por ";
     var text = text.concat(option[index].text);
     document.getElementById('searchInput').placeholder = text;
   }

   document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.querySelector('#searchInput');
      const searchResults = document.querySelector('#searchResults');
      const productListing = document.querySelector('#productListing');
      const selectContext = document.querySelector('#selectContext');

      function createInvestigadorItem(investigador) {
         const investigadorItem = document.createElement('div');
         investigadorItem.classList.add('ml-5', 'imgList');

         const link = document.createElement('a');
         link.href = `colaborador.php?colaborador=${investigador.id}`;

         const imageDiv = document.createElement('div');
         imageDiv.classList.add('image_default');

         const image = document.createElement('img');
         image.classList.add('centrare');
         image.style.objectFit = 'cover';
         image.style.width = '225px';
         image.style.height = '280px';
         image.src = `../backoffice/assets/investigadores/${investigador.fotografia}`;
         image.alt = '';

         const textDiv = document.createElement('div');
         textDiv.classList.add('imgText', 'justify-content-center', 'm-auto');
         textDiv.textContent = investigador.nome;

         imageDiv.appendChild(image);
         imageDiv.appendChild(textDiv);
         link.appendChild(imageDiv);
         investigadorItem.appendChild(link);

         return investigadorItem;
      }

      function createResultsRow() {
         const resultsRow = document.createElement('div');
         resultsRow.classList.add('row', 'justify-content-center', 'mt-3');
         return resultsRow;
      }

      searchInput.addEventListener('input', function() {
         const query = searchInput.value.trim();
         const context = selectContext.value;
         fetch(`search.php?query=${encodeURIComponent(query)}&context=${encodeURIComponent(context)}&origin=colaboradores`)
            .then(response => response.json())
            .then(data => {
               productListing.style.display = 'none';
               searchResults.innerHTML = '';
               if (Array.isArray(data)) {
                  let resultsRow = createResultsRow();
                  data.forEach((result, index) => {
                     const resultItem = createInvestigadorItem(result);
                     resultsRow.appendChild(resultItem);
                     if ((index + 1) % 3 === 0) {
                        searchResults.appendChild(resultsRow);
                        resultsRow = createResultsRow();
                     }
                  });
                  if (resultsRow.children.length > 0) {
                     searchResults.appendChild(resultsRow);
                  }
               } else {
                  console.log('Erro na resposta:', data);
               }
            })
            .catch(error => {
               console.error('Error fetching search results:', error);
            });
      });
   });
</script>

<!-- end product section -->

<?= template_footer(); ?>

</body>

</html>