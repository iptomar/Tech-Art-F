<?php
include 'config/dbconnection.php';
include 'models/functions.php';
$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM investigadores');
$stmt->execute();
$investigadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<?= template_header('Index'); ?>

<!-- slider section -->
<section class="home-slider owl-carousel">
   <div class="slider-item" style="background-image:url('https://cdn.pixabay.com/photo/2021/08/25/20/42/field-6574455__480.jpg');">
      <div class="overlay"></div>

      <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
         <div class="col-md-7 ftco-animate mb-md-5">
            <h1 style="padding-top: 180px;" class="mb-4"><?= change_lang("about-technart-slider"); ?></h1>
            <span class="subheading"><?= change_lang("about-technart-slider-desc"); ?></span>
            <p><a href="sobre.php" class="btn btn-primary px-4 py-3 mt-3"><?= change_lang("know-more-btn-txt-slider") ?></a></p>

         </div>
      </div>
   </div>

   <div class="slider-item" style="background-image:url('https://i0.wp.com/multarte.com.br/wp-content/uploads/2015/08/imagens-amor.jpg?fit=1680%2C1050&ssl=1');">
      <div class="overlay"></div>

      <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
         <div class="col-md-7 ftco-animate mb-md-5">
            <h1 style="padding-top: 180px;" class="mb-4"><?= change_lang("we-help-grow-slider"); ?></h1>
            <span class="subheading"><?= change_lang("we-help-grow-slider-desc"); ?></span>
            <p><a href="sobre.php" class="btn btn-primary px-4 py-3 mt-3"><?= change_lang("know-more-btn-txt-slider") ?></a></p>

         </div>
      </div>
   </div>

   <div class="slider-item" style="background-image:url('https://www.2net.com.br//Repositorio/251/Publicacoes/23883/3c2fd25f-c.jpg');">
      <div class="overlay"></div>

      <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
         <div class="col-md-7 ftco-animate mb-md-5">
            <h1 style="padding-top: 180px;" class="mb-4"><?= change_lang("best-consulting-agency-slider"); ?></h1>
            <span class="subheading"><?= change_lang("best-consulting-agency-slider-desc"); ?></span>
            <p><a href="sobre.php" class="btn btn-primary px-4 py-3 mt-3"><?= change_lang("know-more-btn-txt-slider") ?></a></p>

         </div>
      </div>
   </div>

</section>
<!-- end slider section -->

<!-- why section -->
<section class="why_section layout_padding">
   <div class="container">
      <div class="heading_container heading_center">
         <h3>
            <?= change_lang("institutional-video-heading"); ?>
         </h3>
         <div class="tamanho">
            <h5>
            <?= change_lang("institutional-video-heading-desc"); ?> 
            </h5>
         </div>
      </div>
      <div class="row">
         <div class="col-md-4">
            <div class="ajustar">
               <video src="./assets/images/TheRangeTechnology.mp4" controls width="800" height="500"></video>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- end why section -->

<!-- product section -->
<section class="product_section layout_padding">
   <div style="background-color: #dbdee1; padding-top: 50px; padding-bottom: 50px;">
      <div class="container">
         <div class="heading_container2 heading_center2">

            <h3>
            <?= change_lang("rd-projects-heading"); ?> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
               &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
            </h3>

            <a style="display: inline-block; padding: 5px 25px; background-color:#333F50; border: 2px solid #000000; color: #ffffff; border-radius: 0; 
                     -webkit-transition: all 0.3s; transition: all 0.3s;  font-family: 'Quicksand', sans-serif;  font-size: 20px;" href="projetos.php">
               <?= change_lang("see-all-btn-rd-projects"); ?>
            </a>

         </div>
         <div class="row">
            <?php
            $sql = "SELECT id, nome, descricao, fotografia FROM projetos ORDER BY id DESC limit 4";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($projetos as $row) {
            ?>
               <div class="col">
                  <div style="padding-top: 40px">
                     <div class="img-box">
                        <a href="projeto.php?projeto=<?= $row["id"]; ?>">
                           <img style="object-fit: cover; width:230px; height:230px;" src="../backoffice/assets/projetos/<?= $row["fotografia"]; ?>" alt="">
                        </a>
                     </div>
                  </div>
                  <div class="detail-box">
                     <div style="color: #333F50; padding-left: 15px; padding-top: 15px; text-align: center; width:210px;">
                        <a href="projeto.php?projeto=<?= $row["id"]; ?>" style="color:#333F50;">
                           <h5>
                              <?= $row["nome"]; ?>
                           </h5>
                        </a>
                     </div>
                     <div style="padding-left: 30px; text-align: center; width:210px;">
                        <h6>
                           <?= substr($row["descricao"], 0, 150); ?>...
                        </h6>
                     </div>
                  </div>
               </div>
            <?php
            }

            ?>




         </div>
      </div>
   </div>
</section>
<!-- end product section -->

<!-- client section -->

<section class="section-margin calc-60px">
   <div style="padding-bottom: 50px;">
      <div class="container">
         <div class="section-intro pb-60px">
            <h2 style="font-family: 'Quicksand', sans-serif; padding-bottom: 20px; padding-left: 50px;">ÚLTIMAS NOTÍCIAS</h2>
         </div>

         <div class="owl-carousel owl-theme" id="bestSellerCarousel">
            <?php
            $pdo = pdo_connect_mysql();
            //Selecionar no máximo 6 notícias, ordenadas pela data mais recente, e que tenham data anterior ou igual à atual
            $stmt = $pdo->prepare('SELECT id, imagem, titulo, conteudo, data FROM noticias WHERE data<=NOW() ORDER BY DATA DESC LIMIT 6;');
            $stmt->execute();
            $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($noticias as $noticia) : ?>
               <div class="card-product">
                  <div class="absoluto">
                     <a href="noticia.php?noticia=<?= $noticia['id'] ?>">
                        <div style="z-index: 1000;" class="image">
                           <img class="img-fluid" src="../backoffice/assets/noticias/<?= $noticia['imagem'] ?>" alt="">
                           <div class="text-block">
                              <h5 style="font-size: 20px; text-transform: uppercase; font-weight: 600;">
                                 <?=
                                 //Limitar o título a 35 caracteres e cortar pelo último espaço
                                 $titulo = preg_split("/\s+(?=\S*+$)/", substr($noticia['titulo'], 0, 35))[0];
                                 echo ($titulo != $noticia['titulo']) ? "..." : "";
                                 ?>
                              </h5>
                              <h6 style="font-size: 14px; font-weight: 100;">
                                 <?php
                                 //Adicionar espaços antes das etiquetas html,
                                 $spaces = str_replace('<', ' <', $noticia['conteudo']);
                                 //remover as etiquetas de html e limitar a string a 100 caracteres
                                 $textNoticia = substr(strip_tags($spaces), 0, 100);
                                 //Se o texto da notícia foi cortado, imprimir com reticencias
                                 echo ($textNoticia != strip_tags($spaces)) ? $textNoticia . "..." : $textNoticia;
                                 ?>
                              </h6>
                              <h6 style="font-size: 11px; font-weight: 100;"><?= date("d.m.Y", strtotime($noticia['data'])) ?></h6>
                           </div>
                        </div>
                     </a>

                  </div>
               </div>
            <?php endforeach; ?>
         </div>

         <div style="padding-left: 480px;">
            <a style="display: inline-block; padding: 5px 25px; background-color:#333F50; border: 2px solid #000000; color: #ffffff; border-radius: 0; 
                     -webkit-transition: all 0.3s; transition: all 0.3s;  font-family: 'Quicksand', sans-serif;  font-size: 20px;" href="noticias.php">
               <?= change_lang("see-all-btn-latest-news") ?>
            </a>
         </div>

      </div>
   </div>
</section>

<!-- end client section -->

<?= template_footer(); ?>

</body>

</html>