<?php
include 'models/functions.php';
include 'config/dbconnection.php';
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
                            
                            <!-- <img class="imgmissao w-100" style="max-width:330px;" src="./assets/images/missao.jpg" alt="Boat"> -->
                            <?php
                                $pdo = pdo_connect_mysql();
                                $query = "SELECT fotografia 
                                            FROM technart.areas_website 
                                            WHERE titulo = 'Missão e Objetivos'";
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
                                     WHERE titulo = 'Missão e Objetivos'";
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