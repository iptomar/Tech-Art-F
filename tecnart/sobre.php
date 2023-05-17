<?php
include 'models/functions.php';
?>

<!DOCTYPE html>
<html>

      <?=template_header('Sobre');?>

      <!-- product section -->
      <section class="product_section layout_padding">
      <div style="background-color: #dbdee1; padding-top: 50px; padding-bottom: 50px;">
         <div class="container">
            <div class="heading_container3">
               
                  <h3 style="margin-bottom: 5px;">
                     <?= change_lang("about-technart-page-heading") ?>
                  </h3>

                 
                  <h5 class="heading2_h5">
                     <?= change_lang("about-technart-page-subtitle") ?>
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
               
               <div  class="ml-4 imgList">

                        <div class="image2">
                           <img class="centrare" style="object-fit: cover; width:350px; height:250px;" src="./assets/images/missao.jpg" alt="">
                           <button onclick="window.location.href='missao.php'" type="button" class="mybuttonoverlap btn"><?= change_lang("opportunities-know-more-btn") ?></button>
                           <div class="qualquer"><?= change_lang("mission-and-goals-caption") ?></div>
                        </div>  

               </div>

               <div class="ml-4 imgList">
               
                  <div class="image2">
                     <img class="centrare" style="object-fit: cover; width:350px; height:250px;" src="./assets/images/eixos.jpg" alt="">
                     <button onclick="window.location.href='eixos.php'" type="button" class="mybuttonoverlap btn"><?= change_lang("opportunities-know-more-btn") ?></button>
                     <div class="qualquer"><?= change_lang("research-axes-caption") ?></div>
                  </div>

               </div>
               
            </div>
               
                      
            <div class="row justify-content-center mt-3">
               
               <div  class="ml-4 imgList">
               
                  <div  class="image2">
                     <img class="centrare" style="object-fit: cover; width:350px; height:250px;" src="./assets/images/estrutura.jpg" alt="">
                     <button onclick="window.location.href='estrutura.php'" type="button" class="mybuttonoverlap btn"><?= change_lang("opportunities-know-more-btn") ?></button>
                     <div class="qualquer"><?= change_lang("organic-struct-caption") ?></div>
                  </div>  
               
               </div>



               <div class="ml-4 imgList">
               
                  <div class="image2">
                     <img class="centrare" style="object-fit: cover; width:350px; height:250px;" src="./assets/images/oportunidades.jpg" alt="">
                     <button onclick="window.location.href='oportunidades.php'" type="button" class="mybuttonoverlap btn"><?= change_lang("opportunities-know-more-btn") ?></button>
                     <div class="qualquer"><?= change_lang("opportunities-caption") ?></div>
                  </div>


               </div>
   
            </div>

                
         </div>

      </div>
   </section>

      <!-- end product section -->

      <?=template_footer();?>

   </body>
</html>