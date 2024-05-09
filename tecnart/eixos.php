<?php
include 'models/functions.php';
include 'config/dbconnection.php';
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
                            <!-- <img class="imgeixos w-100" style="max-width: 330px;" src="./assets/images/eixos.jpg" alt="Boat"> -->
                            <?php
                                $pdo = pdo_connect_mysql();
                                $query = "SELECT fotografia 
                                            FROM technart.areas_website 
                                            WHERE titulo = 'Eixos de Investigação'";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();
                                $imagemFetched = $stmt->fetch(PDO::FETCH_ASSOC);
                                $imagem = $imagemFetched['fotografia'];
                                echo '<img class="w-100" style="max-width: 330px;" src="./assets/images/'. $imagem . '" alt="Boat">';   
                            ?>
                            <figcaption class="imgs"></figcaption>
                        </figure>
                    </div>
                    <div class="flex-right">
                        <?php
                           $language = $_SESSION["lang"];
                           $pdo = pdo_connect_mysql();
                           $query = "";
                            if ($language == "pt") {
                                $query .= "SELECT texto ";
                            } else {
                                $query .= "SELECT texto_en ";
                            }
                           $query .= "FROM technart.areas_website 
                                     WHERE titulo = 'Eixos de Investigação'";
                           $stmt = $pdo->prepare($query);
                           $stmt->execute();
                           $textoFetched = $stmt->fetch(PDO::FETCH_ASSOC);
                           $texto = ($language === 'en') ? $textoFetched['texto_en'] : $textoFetched['texto'];
                           echo $texto;
                        ?>
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