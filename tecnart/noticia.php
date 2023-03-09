<?php
session_start();
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM noticias WHERE id=?');
$stmt->bindParam(1, $_GET["noticia"], PDO::PARAM_INT);
$stmt->execute();
$noticias = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?= template_header('Notícia'); ?>

<section>
    <div class="totall">
        <div class="barraesquerda">
            <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 38px; margin-bottom: 20px; color:#333f50; padding-top: 60px; padding-left: 45px; word-wrap: break-word;">
                <?= $noticias['titulo'] ?>
            </h3>
            <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 40px; color:#060633; padding-left: 45px;  padding-bottom: 50px;">
                <?= date("l jS \of F Y", strtotime($noticias['data'])) ?>
            </h5>

        </div>

        <div class="resto">
            <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px" src="../backoffice/assets/noticias/<?= $noticias['imagem'] ?>" alt="">

            <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 30px; padding-left: 50px;">
                Conteúdo da Notícia
            </h3>

            <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 80px;">
                <?= $noticias['conteudo'] ?>
            </h5>

        </div>


    </div>
</section>

</div>

</div>
</div>


</section>

<?= template_footer(); ?>

<script>
</script>
</body>

</html>