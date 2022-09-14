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
            <div class="heading_container2 heading_center2">
               
                  <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 33px; margin-bottom: 5px; color:#333f50;">
                     Sobre o TECHN&ART
                  </h3>

                 
                     <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 16px; padding-right: 550px; color:#060633;">
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
               
               <div  class="ml-4 imgList">

                        <div class="image2">
                           <img class="centrare" style="object-fit: cover; width:350px; height:250px;" src="./assets/images/missao.jpg" alt="">
                           <button onclick="window.location.href='missao.php'" type="button" class="mybuttonoverlap btn">SAIBA MAIS</button>
                           <div class="qualquer">MISSÃO E OBJETIVOS</div>
                        </div>  

               </div>

               <div class="ml-4 imgList">
               
                  <div class="image2">
                     <img class="centrare" style="object-fit: cover; width:350px; height:250px;" src="./assets/images/eixos.jpg" alt="">
                     <button onclick="window.location.href='eixos.php'" type="button" class="mybuttonoverlap btn">SAIBA MAIS</button>
                     <div class="qualquer">EIXOS DE INVESTIGAÇÃO</div>
                  </div>

               </div>
               
            </div>
               
                      
            <div class="row justify-content-center mt-3">
               
               <div  class="ml-4 imgList">
               
                  <div  class="image2">
                     <img class="centrare" style="object-fit: cover; width:350px; height:250px;" src="./assets/images/estrutura.jpg" alt="">
                     <button onclick="window.location.href='estrutura.php'" type="button" class="mybuttonoverlap btn">SAIBA MAIS</button>
                     <div class="qualquer">ESTRUTURA ORGÂNICA</div>
                  </div>  
               
               </div>



               <div class="ml-4 imgList">
               
                  <div class="image2">
                     <img class="centrare" style="object-fit: cover; width:350px; height:250px;" src="./assets/images/oportunidades.jpg" alt="">
                     <button onclick="window.location.href='oportunidades.php'" type="button" class="mybuttonoverlap btn">SAIBA MAIS</button>
                     <div class="qualquer">OPORTUNIDADES</div>
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