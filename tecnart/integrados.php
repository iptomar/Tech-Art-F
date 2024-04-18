<?php
include 'config/dbconnection.php';
include 'models/functions.php';

function mostratodos(){
  echo "ceanmara "; 
}

$pdo = pdo_connect_mysql();
$language = ($_SESSION["lang"] == "en") ? "_en" : "";
$query = "";
if(isset($_POST["mostraTodos"])){
   $query = "SELECT id, email, nome,
   COALESCE(NULLIF(sobre{$language}, ''), sobre) AS sobre,
   COALESCE(NULLIF(areasdeinteresse{$language}, ''), areasdeinteresse) AS areasdeinteresse,
   ciencia_id, tipo, fotografia, orcid, scholar, research_gate, scopus_id
   FROM investigadores WHERE tipo = \"Integrado\" ORDER BY nome";
}
else if(isset($_GET["pequisaInvestigador"])){
   $query = "SELECT id, email, nome,
   COALESCE(NULLIF(sobre{$language}, ''), sobre) AS sobre,
   COALESCE(NULLIF(areasdeinteresse{$language}, ''), areasdeinteresse) AS areasdeinteresse,
   ciencia_id, tipo, fotografia, orcid, scholar, research_gate, scopus_id
   FROM investigadores WHERE tipo = \"Integrado\" and nome LIKE '%{$_GET["pequisaInvestigador"]}%' ORDER BY nome";
   }
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
               <form class="form-check form-check-inline"  id="formPesquisaInvestigador" method="get" >
                  <input type=" text" name="pequisaInvestigador" placeholder="Nome do investigador a perquisar"
                  style="max-width: 500px; min-width: 450px; display: inline-block;  ">
            </div>
            <div class="col-">
               <button type="submit" style="height: 50px; margin-right:10px;">
                  <img name="search-icon" src='assets/icons/search.svg' style="width:40px">
               </button>
               </form>
            </div>
            <div class="col-">
               <form  id="formmostraTodosInvestigadores" method="post">
                  <button type="submit" style="height: 50px;" name="mostraTodos" value="vertodos"> <img name="reload_icon" src='assets\icons\reload.svg' style="width:35px"></button>
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
</section>

<!-- end product section -->

<?= template_footer(); ?>

</body>

</html>