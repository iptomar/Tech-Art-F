<?php
include 'config/dbconnection.php';
include 'models/functions.php';
$pdo = pdo_connect_mysql();
$language = ($_SESSION["lang"] == "en") ? "_en" : "";
$unsubscribe_message = isset($_SESSION['unsubscribe_message']) ? $_SESSION['unsubscribe_message'] : '';
unset($_SESSION['unsubscribe_message']);
?>

<link href="assets/css/newsletter.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

<!DOCTYPE html>
<html>

<?= template_header('TECHN&ART'); ?>
<!-- slider section -->
<section class="home-slider owl-carousel">
   <?php
   $pdo = pdo_connect_mysql();
   //Selecionar no máximo 6 notícias, ordenadas pela data mais recente, e que tenham data anterior ou igual à atual
   $query = "SELECT id, titulo, titulo_en, conteudo, conteudo_en, imagem, link FROM slider WHERE visibilidade = '1'";
   $stmt = $pdo->prepare($query);
   $stmt->execute();
   $itensSlider = $stmt->fetchAll(PDO::FETCH_ASSOC);
   ?>
   <?php foreach ($itensSlider as $itemSlider): ?>
      <div class="slider-item" style="background-image:url('../backoffice/assets/slider/<?= $itemSlider["imagem"] ?>');">
         <div class="overlay"></div>
         <div class="row no-gutters slider-text justify-content-start"
            style="position: relative; height: 100%; max-width:100%;" data-scrollax-parent="true">
            <div class="align-text-slider">
               <div class="col-md-7 mobile_adjust ftco-animate mb-md-5">
                  <h1 class="mb-4">
                     <?php
                     if ($language === "_en") {
                        echo "" . $itemSlider["titulo_en"];
                     } else {
                        echo "" . $itemSlider["titulo"];
                     }
                     ?>
                  </h1>
                  <span class="subheading">
                     <?php
                     if ($language === "_en") {
                        echo "" . $itemSlider["conteudo_en"];
                     } else {
                        echo "" . $itemSlider["conteudo"];
                     }
                     ?>
                  </span>
                  <div><a href='<?= $itemSlider["link"] ?>' class="btn btn-primary px-4 py-3 mt-3 btn_no_left">
                        <?= change_lang("know-more-btn-txt-slider") ?>
                     </a></div>
               </div>
            </div>
         </div>
      </div>
      </div>
   <?php endforeach; ?>
</section>
<!-- end slider section -->

<!-- why section -->
<section class="why_section layout_padding">
   <div class="container">
      <div class="heading_container">
         <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 32px; font-weight: 300; color:002169;">
            <?= change_lang("institutional-video-heading"); ?>
         </h3>
      </div>
      <div class="pt-3">
         <div class="embed-responsive embed-responsive-16by9 mx-auto" style="max-width: 800px;">
            <iframe src="https://www.youtube.com/embed/pzXQaQe3pBw"> </iframe>
         </div>
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
               <?= change_lang("rd-projects-heading"); ?> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
               &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
               &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
            </h3>

            <a style="display: inline-block; padding: 5px 25px; background-color:#000033; border: 2px solid #000000; color: #ffffff; border-radius: 0; 
                     -webkit-transition: all 0.3s; transition: all 0.3s;  font-family: 'Quicksand', sans-serif;  font-size: 20px;"
               href="projetos_em_curso.php">
               <?= change_lang("see-all-btn-rd-projects"); ?>
            </a>

         </div>
         <div class="row">
            <?php
            $sql = "SELECT id,
                     COALESCE(NULLIF(nome{$language}, ''), nome) AS nome,
                     COALESCE(NULLIF(descricao{$language}, ''), descricao) AS descricao,
                     fotografia FROM projetos WHERE concluido = 0 ORDER BY id DESC LIMIT 4";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($projetos as $row) {
               ?>
               <div class="col">
                  <div style="padding-top: 40px">
                     <div class="img-box">
                        <a href="projeto.php?projeto=<?= $row["id"]; ?>">
                           <img style="object-fit: cover; width:230px; height:230px;"
                              src="../backoffice/assets/projetos/<?= $row["fotografia"]; ?>" alt="">
                        </a>
                     </div>
                  </div>
                  <div class="detail-box">
                     <div style="color: #000033; padding-left: 15px; padding-top: 15px; text-align: center; width:210px;">
                        <a href="projeto.php?projeto=<?= $row["id"]; ?>" style="color:#000033;">
                           <h5>
                              <?= $row["nome"]; ?>
                           </h5>
                        </a>
                     </div>
                     <div style="padding-left: 30px; text-align: center; width:210px;">
                        <h6>
                           <?=
                              strlen($row["descricao"]) > 145 ?
                              preg_split("/\s+(?=\S*+$)/", substr($row["descricao"], 0, 150))[0] . "..."
                              : $row["descricao"];
                           ?>
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
            <h2 style="font-family: 'Quicksand', sans-serif; padding-bottom: 20px; padding-left: 50px;">
               <?= change_lang("latest-news-heading") ?>
            </h2>
         </div>

         <div class="owl-carousel owl-theme" id="bestSellerCarousel">
            <?php
            $pdo = pdo_connect_mysql();
            //Selecionar no máximo 6 notícias, ordenadas pela data mais recente, e que tenham data anterior ou igual à atual
            $query = "SELECT id,
            COALESCE(NULLIF(titulo{$language}, ''), titulo) AS titulo,
            COALESCE(NULLIF(conteudo{$language}, ''), conteudo) AS conteudo,
            imagem,data
            FROM noticias WHERE data<=NOW() ORDER BY DATA DESC LIMIT 6";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($noticias as $noticia): ?>
               <div class="card-product">
                  <div class="absoluto">
                     <a href="noticia.php?noticia=<?= $noticia['id'] ?>">
                        <div style="z-index: 1; object-fit: cover; width:230px; height:230px;" class="image_default">
                           <img style="object-fit: cover; width:230px; height:230px;" class="img-fluid"
                              src="../backoffice/assets/noticias/<?= $noticia['imagem'] ?>" alt="">
                           <div class="text-block">
                              <h5 style="font-size: 16px; text-transform: uppercase; font-weight: 400;">
                                 <?php
                                 //Limitar o título a 35 caracteres e cortar pelo último espaço
                                 $titulo = trim($noticia['titulo']);
                                 if (strlen($noticia['titulo']) > 35) {
                                    $titulo = preg_split("/\s+(?=\S*+$)/", substr($noticia['titulo'], 0, 40))[0];
                                 }
                                 echo ($titulo != trim($noticia['titulo'])) ? $titulo . "..." : $titulo;
                                 ?>
                              </h5>
                              <h6 style="font-size: 14px; font-weight: 100;">
                                 <?php
                                 //Adicionar espaços antes das etiquetas html,
                                 $espacos = str_replace('<', ' <', $noticia['conteudo']);
                                 // Remover as etiquetas de HTML e realizar o trim para remover espaços extras, incluindo &nbsp;
                                 $textNoticiaOrig = trim(str_replace('&nbsp;', '', strip_tags($espacos)));
                                 // Verificar se o texto tem mais de 100 caracteres
                                 if (strlen($textNoticiaOrig) > 100) {
                                    $textNoticia = preg_split("/\s+(?=\S*+$)/", substr($textNoticiaOrig, 0, 105))[0];
                                 } else {
                                    $textNoticia = $textNoticiaOrig;
                                 }
                                 //Se o texto da notícia foi cortado, imprimir com reticencias
                                 echo ($textNoticia != $textNoticiaOrig) ? $textNoticia . "..." : $textNoticia;
                                 ?>
                              </h6>
                           </div>
                        </div>
                     </a>

                  </div>
               </div>
            <?php endforeach; ?>
         </div>

         <div class="text-center">
            <a style="display: inline-block; padding: 5px 25px; background-color:#000033; border: 2px solid #000000; color: #ffffff; border-radius: 0; 
                     -webkit-transition: all 0.3s; transition: all 0.3s;  font-family: 'Quicksand', sans-serif;  font-size: 20px;"
               href="noticias.php">
               <?= change_lang("see-all-btn-latest-news") ?>
            </a>
         </div>

      </div>
   </div>

</section>

<?php if (!empty($unsubscribe_message)): ?>
<div class="newsletter-popup open">
    <div class="newsletter-popup-container open">
    <a href="#" class="newsletter-popup-close-btn" onclick="closeNewsletterPopup()">&times;</a>
        <h3><i class="fa-regular fa-envelope"></i>Cancelar subscrição</h3>
        <p><?= $unsubscribe_message ?></p>
    </div>
</div>
<?php endif; ?>

<?php if (empty($unsubscribe_message)): ?>
<div class="newsletter-popup">
   <div class="newsletter-popup-container">
      <a href="#" class="newsletter-popup-close-btn">&times;</a>
      <h3><i class="fa-regular fa-envelope"></i>Subscreva a nossa newsletter</h3>
      <p>Subscreva a nossa newsletter para receber as últimas novidades no seu email.</p>
      <form action="subscrever.php" method="post">
         <div style="text-align: center;">
            <input type="email" name="email" placeholder="Endereço de email" required style="text-transform: none;">
            <input type="radio" class="btn-check" name="idioma" id="idioma-pt" autocomplete="off" checked value="pt">
            <label class="btn btn-outline-secondary" for="idioma-pt" style="width:120px">Português</label>
            <input type="radio" class="btn-check" name="idioma" id="idioma-en" autocomplete="off" value="en">
            <label class="btn btn-outline-secondary" for="idioma-en" style="width:120px;">Inglês</label>
            <br /><br />
            <button type="submit" style="height: 40px">Subscrever</button>
         </div>
      </form>
      <p class="newsletter-msg"></p>
   </div>
</div>
<?php endif; ?>



<!-- end client section -->

<?= template_footer(); ?>

<script>
   const openNewsletterPopup = () => {
      if (!document.cookie.includes('nonews=true')) {
         document.querySelector('.newsletter-popup').style.display = 'flex';
         document.querySelector('.newsletter-popup').getBoundingClientRect();
         document.querySelector('.newsletter-popup').classList.add('open');
         document.querySelector('.newsletter-popup-container').getBoundingClientRect();
         document.querySelector('.newsletter-popup-container').classList.add('open');
      }
   };

   const closeNewsletterPopup = () => {
      document.querySelector('.newsletter-popup').style.display = 'none';
      document.querySelector('.newsletter-popup').classList.remove('open');
      document.querySelector('.newsletter-popup-container').classList.remove('open');
      document.querySelector('.newsletter-popup-close-btn').addEventListener('click', closeNewsletterPopup);
      document.cookie = "nonews=true; expires=" + new Date(Date.now() + 31536000000).toUTCString() + "; path=/";
   };

   const newsletterForm = document.querySelector('.newsletter-popup form');
   newsletterForm.onsubmit = event => {
      event.preventDefault();
      fetch(newsletterForm.action, {
         method: 'POST',
         body: new FormData(newsletterForm)
      }).then(response => response.text()).then(data => {
         document.querySelector('.newsletter-msg').innerHTML = data;
         document.cookie = "nonews=true; expires=" + new Date(Date.now() + 31536000000).toUTCString() + "; path=/";
      });
   };

   document.querySelector('.newsletter-popup-close-btn').onclick = event => {
      event.preventDefault();
      closeNewsletterPopup();
   };

   document.addEventListener('scroll', () => {
      if (window.scrollY >= 400 && !document.cookie.includes('nonews=true')) {
         openNewsletterPopup();
      }
   });
</script>

</body>

</html>