<?php
include 'models/functions.php';
?>

<!DOCTYPE html>
<html>

      <?=template_header('Missão');?>


      <!-- product section -->
      <section class="product_section layout_padding">
      <div style="padding-top: 50px; padding-bottom: 30px;">
         <div class="container">
            <div class="heading_container3">
               
                <h3 style="text-transform: uppercase;">
                    <?= change_lang("mission-and-goals-page-heading") ?>
                </h3>

                <div class="flex-container mobile_reverse">
                    <div class="flex-left">
                        <figure class="imgfigura">
                            <img class="imgmissao w-100" style="max-width:330px;" src="./assets/images/missao.jpg" alt="Boat">
                            <figcaption class="imgs"></figcaption>
                        </figure>
                    </div>
                    <div class="flex-right">
                        <?= change_lang("mission-and-goals-page-point-one") ?><br><br>

                        <?= change_lang("mission-and-goals-page-point-two") ?><br><br>

                        <b>a) </b><?= change_lang("mission-and-goals-page-a-txt") ?><br><br>

                        <b>b) </b><?= change_lang("mission-and-goals-page-b-txt") ?><br><br>

                        <b>c) </b><?= change_lang("mission-and-goals-page-c-txt") ?><br><br>

                        <b>d) </b><?= change_lang("mission-and-goals-page-d-txt") ?><br><br>

                        <b>e) </b><?= change_lang("mission-and-goals-page-e-txt") ?><br><br>

                        <b>f) </b><?= change_lang("mission-and-goals-page-f-txt") ?><br><br>

                        <b>g) </b><?= change_lang("mission-and-goals-page-g-txt") ?><br><br>
                    </div>
                </div>

                
<!--                 <div class="flex-container">
                    
                    <div class="flex-left2">
                        "tempor pulvinar. Vivamus ultrices egestas posuere. Integer magna orci, vestibulum."
                    </div> 

                    <div class="flex-right">
                        <b>c) </b>Difundir a cultura científica, tecnológica e artística através da organização de conferências, colóquios, seminários, exposições
                        e sessões culturais;<br><br>

                        <b>d) </b>Promover a formação avançada dos recursos humanos, fomentando a sua constante valorização científica e cultural;<br><br>

                        <b>e) </b>Estabelecer a cooperação interinstitucional com entidades nacionais e internacionais;<br><br>

                        <b>f) </b>Utilizar com eficácia os financiamentos de que é beneficiária e outros recursos disponíveis;<br><br>

                        <b>g) </b>Prestar serviços à comunidade no âmbito das suas atividades.<br><br>
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