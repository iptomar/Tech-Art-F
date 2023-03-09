<?php
session_start();
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM noticias');
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<?= template_header('Notícias'); ?>


<section class="product_section layout_padding">
   <div style="background-color: #dbdee1; padding-top: 50px; padding-bottom: 50px;">
      <div class="container">
         <div class="heading_container2 heading_center2">
            <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 33px; margin-bottom: 5px; color:#333f50;">
               Notícias
            </h3>
            <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 16px; padding-right: 660px; color:#060633;">
               Cras massa velit, vehicula nec tincidunt at, aliquet porttitor ligula. Nullam faucibus est nunc, at tincidunt odio efficitur eget.
               Pellentesque justo ex, tristique sed sapien ac, tempor venenatis odio liquet tincidun.
            </h5>

         </div>
      </div>
   </div>
</section>


<section class="product_section layout_padding">
   <div style="padding-top: 20px;">
      <div class="container">
         <div class="row justify-content-center mt-3">

            <?php foreach ($noticias as $noticia) : ?>
               <div class="ml-5 imgList">
                  <a href="noticia.php?noticia=<?= $noticia['id'] ?>">
                     <div class="image">
                        <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="../backoffice/assets/noticias/<?= $noticia['imagem'] ?>" alt="">
                        <div class="imgText justify-content-center m-auto" style="top:75%">
                           <?=
                           $titulo = preg_split("/\s+(?=\S*+$)/", substr($noticia['titulo'], 0, 35))[0];
                           echo ($titulo != $noticia['titulo']) ? "..." : "";
                           ?>
                        </div>
                     </div>
                  </a>
               </div>

            <?php endforeach; ?>

         </div>

      </div>

   </div>
</section>


<?= template_footer(); ?>

</body>

</html>