<?php
include 'models/functions.php';
?>

<!DOCTYPE html>
<html>

      <?=template_header('Eixos');?>


      <!-- product section -->
      <section class="product_section layout_padding">
      <div style="padding-top: 50px; padding-bottom: 30px;">
         <div class="container">
            <div class="heading_container2 heading_center2">
               
                <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 33px; color:#333f50; text-transform: uppercase;">
                    <?= change_lang("axes-page-heading") ?>
                </h3>

                 
                <h4 style="font-family: 'Quicksand', sans-serif; font-size: 26px; padding-right: 660px; color:#060633; text-transform: uppercase; padding-top: 25px;">
                    <?= change_lang("axes-page-subtitle") ?>
                </h4>

                <div class="flex-container mobile_reverse">
                    <div class="flex-left">
                        <figure class="imgfigura">
                            <img class="imgeixos w-100" style="max-width: 330px;" src="./assets/images/DSC00513.JPG" alt="Boat">
                            <figcaption class="imgs">O encontro, Luís Marques</figcaption>
                        </figure>
                    </div>
                    <div class="flex-right">

                        <?= change_lang("axes-page-description") ?><br><br>

                        <b>a) </b><?= change_lang("axes-page-a-txt") ?><br><br>

                        <b>a1) </b><?= change_lang("axes-page-a-one-txt") ?><br><br>

                        <b>a2) </b><?= change_lang("axes-page-a-two-txt") ?><br><br>

                        <b>b) </b><?= change_lang("axes-page-b-txt") ?><br><br>
                        
                        <b>b1) </b><?= change_lang("axes-page-b-one-txt") ?><br><br>
                        
                        <b>b2) </b><?= change_lang("axes-page-b-two-txt") ?><br><br>

                        <?= change_lang("bottom-text") ?>

                    </div>
                </div>

<!--                 <div class="flex-container">
                    
                    <div class="flex-left2">
                        "tempor pulvinar. Vivamus ultrices egestas posuere. Integer magna orci, vestibulum."
                    </div> 

                    <div class="flex-right">
                        <b>b) </b>Valorização do Património Artístico e Cultural<br><br>
                        
                        <b>b1) </b>Didática, Tecnologia e Comunicação<br><br>
                        
                        <b>b2) </b>Design e Inovação<br><br>

                        Estas linhas de ação complementam-se e imbricam-se para que o todo que a missão do Techn&Art seja coerente e tire partido do visando 
                        a transferência de conhecimento, de competências e de experiências de todos os investigadores e colaboradores do nosso centro.
                        
                    </div>

                </div> -->
               

            </div>
         </div>
      </div>
   </section>
      <!-- end product section -->
      
      <?=template_footer();?>

   </body>
</html>