<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();
$language = ($_SESSION["lang"] == "en") ? "_en" : "";


#Variavel que recebe a query para a base de dados 
$query = "";

#Variavel que contem parte da string para preencher o place holder 
$placeholder = "Pesquisar Projeto por Nome";
#se o botao do reload for clicado mostra todos os projetos concluidos 
if(isset($_POST["mostraTodos"])){
   $query = "SELECT id,COALESCE(NULLIF(nome{$language}, ''), nome) AS nome,fotografia FROM projetos WHERE concluido=true ORDER BY nome";
}
#se o botão do pesquisar for clicado mostra o/os projetos concluidos que estejam dentro do contexto de pesquisa
else if(isset($_GET["pesquisaProjeto"])){  
   if($_GET["selectContext"]=="i.nome" || $_GET["selectContext"]=="g.nome"){
   $query = "SELECT DISTINCT p.id,COALESCE(NULLIF(p.nome{$language}, ''), p.nome) AS nome, p.fotografia
   FROM projetos p 
   LEFT JOIN investigadores_projetos ip on ip.projetos_id =p.id 
   LEFT JOIN investigadores i on ip.investigadores_id=i.id 
   LEFT JOIN gestores_projetos gp on gp.projetos_id = p.id
   LEFT JOIN investigadores g on gp.gestores_id=g.id
   WHERE concluido=true and {$_GET["selectContext"]} LIKE '%{$_GET["pesquisaProjeto"]}%' ORDER BY nome";
   }else if($_GET["selectContext"]=="financiamento"){
      $query = "SELECT id,COALESCE(NULLIF(nome{$language}, ''), nome) AS nome, fotografia
      FROM projetos 
      WHERE concluido=true and REPLACE({$_GET["selectContext"]}, ' ', '') LIKE REPLACE('%{$_GET["pesquisaProjeto"]}%', ' ', '') ORDER BY nome";
   }else{
      $query = "SELECT id,COALESCE(NULLIF(nome{$language}, ''), nome) AS nome, fotografia
      FROM projetos 
      WHERE concluido=true and {$_GET["selectContext"]} LIKE '%{$_GET["pesquisaProjeto"]}%' ORDER BY nome";
   }
}
#caso nehum botao seja clicado mostra todos 
else{ 
   $query = "SELECT id,COALESCE(NULLIF(nome{$language}, ''), nome) AS nome,fotografia FROM projetos WHERE concluido=true ORDER BY nome";

}


$stmt = $pdo->prepare($query);
$stmt->execute();
$projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<script>
   // metodo java scrip para altera o placeholder no input pesquisar 
   function atualizaPlaceHolder(){
     var index = document.getElementById("selectContext").selectedIndex; 
     var option = document.getElementById("selectContext").options;
     var text = "Procurar Projeto por ";
     var text = text.concat(option[index].text);
     document.getElementsByName('pesquisaProjeto')[0].placeholder = text ;

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
            <div class="col-">
               <!--Formulario que permite pesquisar o projeto -->
               <form class="form-check form-check-inline"  id="formPesquisaProjeto" method="get" >
                  <input type="text" name="pesquisaProjeto" placeholder="<?php echo $placeholder ?>"
                  style="max-width: 500px; min-width: 450px; display: inline-block; text-transform: none; margin-right: 5px;  height: 40px;">
            </div>
             <!--Select para selecionar o campo pelo  qual se quer pesquisar o projeto-->
            <select class="form-select form-select-lg mb-3" name="selectContext" id="selectContext"  onchange="atualizaPlaceHolder()">
  						<option value="nome">Nome</option>
                  <option value="descricao">Descrição</option>
  						<option value="referencia">Referência</option>
  						<option value="areapreferencial">TECHN&ART Área Preferencial</option>
  						<option value="financiamento">Financiamento</option>
                  <option value="ambito">Âmbito</option>
                  <option value="i.nome">Investigador</option>
                  <option value="g.nome">Gestor</option>
						</select>
            <div class="col-">
               <button type="submit" style="height: 40px; margin-right:10px; margin-left:15px;">
                  <img name="search-icon" src='assets/icons/search.svg' style="width:30px">
               </button>
               </form>
            </div>
            <div class="col-">
                <!--Formulario que permite limpar a pesquisa feita pelo utilizador-->
               <form  id="formmostraTodosInvestigadores" method="post">
                  <button type="submit" style="height: 40px;" name="mostraTodos" value="vertodos"> <img name="reload_icon" src='assets\icons\reload.svg' style="width:30px"></button>
               </form>
            </div>
         </div>


         <div class="row justify-content-center mt-3">

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

      </div>


   </div>
</section>

<?= template_footer(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('#searchInput');
        const searchResults = document.querySelector('#searchResults');
        const productListing = document.querySelector('#productListing');

        // Function to generate HTML for project item
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

            fetch(`search.php?query=${encodeURIComponent(query)}&concluido=1`)
                .then(response => response.json())
                .then(data => {
                    productListing.style.display = 'none';
                    searchResults.innerHTML = '';
                    data.forEach((result, index) => {
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
