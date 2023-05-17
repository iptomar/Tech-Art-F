<?php
include 'models/functions.php';
?>

<!DOCTYPE html>
<html>

<?= template_header('Eixos'); ?>


<!-- product section -->
<section class="product_section layout_padding">
    <div style="padding-top: 50px; padding-bottom: 30px;">
        <div class="container">
            <div class="heading_container3">

                <h3 style="text-transform: uppercase;">
                    <?= change_lang("axes-page-heading") ?>
                </h3>

                <div class="flex-container mobile_reverse">
                    <div class="flex-left">
                        <figure class="imgfigura">
                            <img class="imgeixos w-100" style="max-width: 330px;" src="./assets/images/eixos.jpg" alt="Boat">
                            <figcaption class="imgs"></figcaption>
                        </figure>
                    </div>
                    <div class="flex-right">

                        <p><?= change_lang("axes-page-p1-txt") ?></p>

                        <p class="text-uppercase"><b>a) <?= change_lang("axes-page-a-txt") ?></b></p>
                        <p class="text-uppercase"><b>b) <?= change_lang("axes-page-b-txt") ?></b></p>
                        <br><br>
                        <p><?= change_lang("axes-page-p2-txt") ?></p>


                        <p><b>a1) </b><?= change_lang("axes-page-a-one-txt") ?></p>
                        <p><b>a2) </b><?= change_lang("axes-page-a-two-txt") ?></p>
                        <br>
                        <p><?= change_lang("axes-page-p3-txt") ?></p>
                        <p><b>b1) </b><?= change_lang("axes-page-b-one-txt") ?></p>

                        <p><b>b2) </b><?= change_lang("axes-page-b-two-txt") ?></p>

                        <p><?= change_lang("bottom-text") ?></p>

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