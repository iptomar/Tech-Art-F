<?php
session_start();
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM investigadores WHERE tipo = "Colaborador"');
$stmt->execute();
$investigadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

      <?=template_header('Colaboradores');?>
      
      <!-- product section -->
      <section class="product_section layout_padding">
      <div style="background-color: #dbdee1; padding-top: 50px; padding-bottom: 50px;">
         <div class="container">
            <div class="heading_container2 heading_center2">
               
                <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 33px; margin-bottom: 5px; color:#333f50;">
                    Investigadores/as Colaboradores/as
                </h3>
                 
                <h5 class="heading2_h5">
                    Cras massa velit, vehicula nec tincidunt at, aliquet porttitor ligula. Nullam faucibus est nunc, at tincidunt odio efficitur eget. 
                    Pellentesque justo ex, tristique sed sapien ac, tempor venenatis odio liquet tincidun.  
                </h5>

            </div>
         </div>
      </div>
   </section>
      <!-- end product section -->

<section class="product_section layout_padding">
      <div style="padding-top: 20px;">
         <div class="container">
      <div class="row justify-content-center mt-3">

         <?php foreach ($investigadores as $investigador): ?>

               <div  class="ml-5 imgList">
                  <a href="colaborador.php?colaborador=<?=$investigador['id']?>">
                        <div  class="image">
                        <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="../backoffice/assets/investigadores/<?=$investigador['fotografia']?>" alt="">
                           <div class="imgText justify-content-center m-auto"><?=$investigador['nome']?></div>
                        </div>
                  </a> 
               </div>

         <?php endforeach; ?>

      </div>
      
                      
<!--             <div class="row justify-content-center mt-3">
               
               <div  class="ml-4 imgList">
               
                  <div  class="image">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/joana-bento-rodrigues.jpg" alt="">
                     <div class="imgText justify-content-center m-auto">teresa silva</div>
                  </div>  
               
               </div>

               <div class="ml-4 imgList">

                  <div  class="image">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/maisum.jpg" alt="">
                     <div class="imgText justify-content-center m-auto">josé constâncio</div>
                  </div>

               </div>

               <div class="ml-4 imgList">
               
                  <div class="image">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/pexels-photo-2272853.jpeg" alt="">
                     <div class="imgText justify-content-center m-auto">josefa vasconcelos</div>
                  </div>


               </div>
   
            </div>


            <div class="row justify-content-center mt-3">
               
               <div  class="ml-4 imgList">
               
                  <div  class="image">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/whatsapp-image-2021.jpg" alt="">
                     <div class="imgText justify-content-center m-auto">ana maria simões</div>
                  </div>  
               
               </div>

               <div class="ml-4 imgList">

                  <div  class="image">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/55918.jpg" alt="">
                     <div class="imgText justify-content-center m-auto">maria bettencourt</div>
                  </div>

               </div>

               <div class="ml-4 imgList">
               
                  <div class="image">
                  <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="./assets/images/5591801.jpg" alt="">
                     <div class="imgText justify-content-center m-auto">cristina marques</div>
                  </div>


               </div>
            
            </div> -->

                
         </div>

      </div>
   </section>

      <!-- end product section -->

      <?=template_footer();?>

   </body>
</html>