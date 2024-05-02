<?php
include 'models/functions.php';
include 'config/dbconnection.php';
?>

<!DOCTYPE html>
<html>

<?= template_header(change_lang("new-admissions-title")); ?>


<!-- product section -->
<section class="product_section layout_padding">
    <div style="padding-top: 50px; padding-bottom: 30px;">
        <div class="container">
            <div class="heading_container3">

                <h3 class="heading_h3" style="text-transform: uppercase;">
                    <?= change_lang("new-admissions-title") ?>
                </h3>

                <div class="flex-container mobile_reverse">
                    <div class="flex-left">
                        <figure class="imgfigura">
                           <!-- <img class="w-100" style="max-width: 330px;" src="./assets/images/technart_color.png" alt="Techn&Art"> -->
                            <?php
                                $pdo = pdo_connect_mysql();
                                $query = "SELECT fotografia 
                                            FROM technart.areas_website 
                                            WHERE titulo = 'Novas admissões'";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();
                                $imagemFetched = $stmt->fetch(PDO::FETCH_ASSOC);
                                $imagem = $imagemFetched['fotografia'];
                                echo '<img class="w-100" style="max-width: 330px;" src="./assets/images/'. $imagem . '" alt="Techn&Art">';   
                            ?>
                        </figure>
                    </div>
                    <div class="flex-right">
                    <?php
                           $pdo = pdo_connect_mysql();
                           $query = "SELECT texto 
                                     FROM technart.areas_website 
                                     WHERE titulo = 'Novas admissões'";
                           $stmt = $pdo->prepare($query);
                           $stmt->execute();
                           $textoFetched = $stmt->fetch(PDO::FETCH_ASSOC);
                           $texto = $textoFetched['texto'];
                           echo $texto;
                        ?>
                    </div>
                </div>
                <a style="display: inline-block; padding: 5px 25px; background-color:#333F50; border: 2px solid #000000; color: #ffffff; border-radius: 0; 
                     -webkit-transition: all 0.3s; transition: all 0.3s;  font-family: 'Quicksand', sans-serif;  font-size: 20px;" href="admissao.php">
                            <?= change_lang("new-admissions-regulations-fill") ?>
                        </a>
            </div>
        </div>
    </div>
</section>
<!-- end product section -->

<?= template_footer(); ?>

</body>

</html>