<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();
$language = ($_SESSION["lang"] == "en") ? "_en" : "";

$placeholder = "Pesquisar Projeto por Nome";
$query = "SELECT id, COALESCE(NULLIF(nome{$language}, ''), nome) AS nome, fotografia FROM projetos WHERE concluido=true ORDER BY nome";

$stmt = $pdo->prepare($query);
$stmt->execute();
$projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
   function atualizaPlaceHolder(){
     var index = document.getElementById("selectContext").selectedIndex; 
     var option = document.getElementById("selectContext").options;
     var text = "Procurar Projeto por ";
     text = text.concat(option[index].text);
     document.getElementById('searchInput').placeholder = text;
   }
</script>

<!DOCTYPE html>
<html>

<?= template_header(change_lang("projects-finished-page-heading")); ?>

<body>

<section class="product_section layout_padding">
   <div style="background-color: #dbdee1; padding-top: 50px; padding-bottom: 50px;">
      <div class="container">
         <div class="heading_container3">
            <h3 style="margin-bottom: 5px;">
               <?= change_lang("projects-finished-page-heading") ?>
            </h3>
            <h5 class="heading2_h5">
               <?= change_lang("projects-finished-page-description") ?>
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
               <form class="form-check form-check-inline">
                  <input id="searchInput" type="text" class="form-control" placeholder="<?php echo $placeholder ?>" style="max-width: 500px; min-width: 450px; display: inline-block; text-transform: none; margin-right: 5px; height: 40px;">
                  <select class="form-select form-select-lg mb-3" name="selectContext" id="selectContext" onchange="atualizaPlaceHolder()">
                     <option value="nome">Nome</option>
                     <option value="descricao">Descrição</option>
                     <option value="referencia">Referência</option>
                     <option value="areapreferencial">TECHN&ART Área Preferencial</option>
                     <option value="financiamento">Financiamento</option>
                     <option value="ambito">Âmbito</option>
                     <option value="i.nome">Investigador</option>
                     <option value="g.nome">Gestor</option>
                  </select>
               </form>
            </div>
         </div>

         <div id="productListing" class="row justify-content-center mt-3">
            <?php foreach ($projetos as $projeto) : ?>
               <div class="ml-5 imgList">
                  <a href="projeto.php?projeto=<?= $projeto['id'] ?>">
                     <div class="image_default">
                        <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="../backoffice/assets/projetos/<?= $projeto['fotografia'] ?>" alt="">
                        <div class="imgText justify-content-center m-auto"><?= $projeto['nome'] ?></div>
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

   </div>
</section>

<?= template_footer(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('#searchInput');
        const searchResults = document.querySelector('#searchResults');
        const productListing = document.querySelector('#productListing');
        const selectContext = document.querySelector('#selectContext');

        function createProjectItem(project) {
            const projectItem = document.createElement('div');
            projectItem.classList.add('ml-5', 'imgList');

            const link = document.createElement('a');
            link.href = `projeto.php?projeto=${project.id}`;

            const imageDiv = document.createElement('div');
            imageDiv.classList.add('image_default');

            const image = document.createElement('img');
            image.classList.add('centrare');
            image.style.objectFit = 'cover';
            image.style.width = '225px';
            image.style.height = '280px';
            image.src = `../backoffice/assets/projetos/${project.fotografia}`;
            image.alt = '';

            const textDiv = document.createElement('div');
            textDiv.classList.add('imgText', 'justify-content-center', 'm-auto');
            textDiv.textContent = project.nome;

            imageDiv.appendChild(image);
            imageDiv.appendChild(textDiv);
            link.appendChild(imageDiv);
            projectItem.appendChild(link);

            return projectItem;
        }

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim();
            const context = selectContext.value;

            fetch(`search.php?query=${encodeURIComponent(query)}&concluido=1&context=${encodeURIComponent(context)}`)
                .then(response => response.json())
                .then(data => {
                    productListing.style.display = 'none';
                    searchResults.innerHTML = '';
                    data.forEach((result) => {
                        const resultItem = createProjectItem(result);
                        searchResults.appendChild(resultItem);                        
                    });
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                });
        });
    });
</script>

</body>
</html>
