<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();
$language = ($_SESSION["lang"] == "en") ? "_en" : "";
#Variavel que recebe a query para a base de dados 
$query = "";
#Variavel que Contem parte da string para preencher o place holder 
$placeholder = "Pesquisar Investigador por Nome";
#se o botao do reload for clicado mostra todos os investigadores 
if(isset($_POST["mostraTodos"])){
   $query = "SELECT id, email, nome,
   COALESCE(NULLIF(sobre{$language}, ''), sobre) AS sobre,
   COALESCE(NULLIF(areasdeinteresse{$language}, ''), areasdeinteresse) AS areasdeinteresse,
   ciencia_id, tipo, fotografia, orcid, scholar, research_gate, scopus_id
   FROM investigadores WHERE tipo = \"Integrado\" ORDER BY nome";
}
#se o botão do pesquisar for clicado mostra o/os investigadores que estejam dentro do contexto de pesquisa
else if(isset($_GET["pequisaInvestigador"])){
   $query = "SELECT id, email, nome,
   COALESCE(NULLIF(sobre{$language}, ''), sobre) AS sobre,
   COALESCE(NULLIF(areasdeinteresse{$language}, ''), areasdeinteresse) AS areasdeinteresse,
   ciencia_id, tipo, fotografia, orcid, scholar, research_gate, scopus_id
   FROM investigadores WHERE tipo = \"Integrado\" and {$_GET["selectContext"]} LIKE '%{$_GET["pequisaInvestigador"]}%' ORDER BY nome";
  			
}
#caso nehum botao seja clicado mostra todos 
else{ 
   $query = "SELECT id, email, nome,
   COALESCE(NULLIF(sobre{$language}, ''), sobre) AS sobre,
   COALESCE(NULLIF(areasdeinteresse{$language}, ''), areasdeinteresse) AS areasdeinteresse,
   ciencia_id, tipo, fotografia, orcid, scholar, research_gate, scopus_id
   FROM investigadores WHERE tipo = \"Integrado\" ORDER BY nome";
}

$stmt = $pdo->prepare($query);
$stmt->execute();
$investigadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<?= template_header('Integrados'); ?>

<!-- product section -->
<section class="product_section layout_padding">
   <div style="background-color: #dbdee1; padding-top: 50px; padding-bottom: 50px;">
      <div class="container">
         <div class="heading_container3">

            <h3 style="margin-bottom: 5px;">
               <?= change_lang("integrated-researchers-page-heading") ?>
            </h3>

            <h5 class="heading2_h5">
               <?= change_lang("integrated-researchers-page-heading-desc") ?>
            </h5>

         </div>
      </div>
   </div>
</section>
<!-- end product section -->

<section class="product_section layout_padding">
   <div>
      <div class="container">

         <div class="row justify-content-center mt-3">
            <div class="col-">
               <!--Formolario que permite pesquisa o ivestigador -->
               <form class="form-check form-check-inline"  id="formPesquisaInvestigador" method="get" >
                  <input type="text" name="pequisaInvestigador" placeholder="<?php echo $placeholder ?>"
                  style="max-width: 500px; min-width: 450px; display: inline-block; text-transform: none; margin-right: 5px;  height: 40px;">
            </div>
             <!--Select para selecionar o campo pelo  qual se quer perquisar  o investigador-->
            <select class="form-select form-select-lg mb-3" name="selectContext" id="selectContext"  onchange="atualizaPlaceHolder()">
  						<option value="nome">Nome</option>
  						<option value="email">Email</option>
  						<option value="ciencia_id">Ciência ID</option>
  						<option value="orcid">Orcid</option>
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

            <?php foreach ($investigadores as $investigador): ?>

               <div class="ml-5 imgList">
                  <a href="integrado.php?integrado=<?= $investigador['id'] ?>">
                     <div class="image_default">
                        <img class="centrare" style="object-fit: cover; width:225px; height:280px;"
                           src="../backoffice/assets/investigadores/<?= $investigador['fotografia'] ?>" alt="">
                        <div class="imgText justify-content-center m-auto"><?= $investigador['nome'] ?></div>
                     </div>
                  </a>
               </div>

            <?php endforeach; ?>
         </div>
      </div>


      <!--<div class="row justify-content-center mt-3">
               
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
</section>
<script>
   // metodo java scrip para altera o placeholder no input pesquisar 
   function atualizaPlaceHolder(){
     var index = document.getElementById("selectContext").selectedIndex; 
     var option = document.getElementById("selectContext").options;
     var text = "Procurar Investigador por ";
     var text = text.concat(option[index].text);
     document.getElementsByName('pequisaInvestigador')[0].placeholder = text ;

   }
</script>
<!-- end product section -->

<?= template_footer(); ?>

</body>

</html>