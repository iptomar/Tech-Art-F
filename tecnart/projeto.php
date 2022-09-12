<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM projetos WHERE id=?');
$stmt->bindParam(1,$_GET["projeto"],PDO::PARAM_INT);
$stmt->execute();
$projetos = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<?=template_header('Projeto');?>

<section class="product_section layout_padding3">
    <div
        style="height:300px; background: url('../projetos/<?=$projetos['fotografia']?>'); background-size: cover; background-position:100%;">
    </div>
</section>


<!-- product section -->
<section>

    <div class="totall">
        <div class="barraesquerda">

            <h3
                style="font-family: 'Merriweather Sans', sans-serif; font-size: 38px; margin-bottom: 20px; color:#333f50; padding-top: 60px; padding-left: 45px;  text-transform: uppercase;">
                <?=$projetos['nome']?>
            </h3>
            <h5
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 40px; color:#060633; padding-left: 45px;  padding-bottom: 50px;">
                <?=$projetos['descricao']?>
            </h5>



            <button class="divbotao" id="showit">
                <span href="#" class="innerButton">
                    sobre o projeto
                </span>
            </button>

            <button class="divbotao" id="showit2">
                <span href="#" class="innerButton">
                    equipa e intervenientes
                </span>
            </button>

            <button class="divbotao" id="showit3">
                <span href="#" class="innerButton">
                    notícias e eventos
                </span>
            </button>

            <button class="divbotao" id="showit4" style="margin-bottom: 220px;">
                <span href="#" class="innerButton">
                    publicações
                </span>
            </button>

            <h5 class="nofinal"
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; color:#060633; padding-bottom: 45px; padding-left: 190px;">
                Ligações externas
            </h5>

            <a href="https://www.researchgate.net/"
                style="font-size:28px; color:#04d7aa; position: absolute; bottom: 11px; left: 207px;"><i
                    class="fab fa-researchgate"></i></a>
            <a href="https://www.youtube.com/"
                style="font-size:30px; color:red; position: absolute; bottom: 10px; left: 240px;"><i
                    class="fa fa-youtube-play"></i></a>
            <a href="https://www.facebook.com/"
                style="font-size:25px; color:#2c61a0; position: absolute; bottom: 13px; left: 280px;"><i
                    class="fa fa-facebook-official"></i></a>


        </div>

        <div class="resto">

            <h3
                style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 60px; padding-left: 50px;">
                Sobre o projeto
            </h3>

            <h5
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 20px;">
                <?=$projetos['sobreprojeto']?>
            </h5>

            <h5
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px; padding-bottom: 45px;">
                <b>duis a mollis urna. In hac habitasse platea dictumst. Vestibulum nisi nunc, elementum et vehicula
                    vel, rhoncus non metus.
                    In vel dapibus dolor. Sed at laoreet turpis. Donec nec aliquam velit. Quisque blandit nisi
                    mauris.</b>
            </h5>

            <h4
                style="font-family: 'Quicksand', sans-serif; font-size: 26px; color:#060633; text-transform: uppercase; padding-left: 50px; padding-bottom: 30px;">
                subtítulo
            </h4>

            <h5
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;">
                <b>Referência:</b> <?=$projetos['referencia']?>
            </h5>

            <h5
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;">
                <b>Techn&Art área preferencial:</b> <?=$projetos['areapreferencial']?>
            </h5>

            <h5
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;">
                <b>Financiamento:</b> <?=$projetos['financiamento']?>
            </h5>

            <h5
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px; padding-bottom: 150px;">
                <b>Âmbito:</b> <?=$projetos['ambito']?>
            </h5>

        </div>

        <div class="resto2" style="display: none;">

            <h3
                style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 60px; padding-left: 50px;">
                Equipa e intervenientes
            </h3>

            <div style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 20px;">
                <?php 
            $stmt = $pdo->prepare('SELECT i.* FROM investigadores i INNER JOIN investigadores_projetos ip ON ip.projetos_id = ? and ip.investigadores_id = i.id');
            $stmt->bindParam(1,$_GET["projeto"],PDO::PARAM_INT);
            $stmt->execute();
            $investigadores = $stmt->fetchall(PDO::FETCH_ASSOC);
            ?>
                <section class="product_section layout_padding">
                    <div style="padding-top: 20px;">
                        <div class="container">
                            <div class="row justify-content-center mt-3">

                                <?php foreach ($investigadores as $investigador): ?>

                                <div class="ml-5 imgList">
                                    <a href="integrado.php?integrado=<?=$investigador['id']?>">
                                        <div class="image">
                                            <img class="centrare" style="object-fit: cover; width:225px; height:280px;"
                                                src="../investigadores/<?=$investigador['fotografia']?>" alt="">
                                            <div class="imgText justify-content-center m-auto">
                                                <?=$investigador['nome']?>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <?php endforeach; ?>

                            </div>


                        </div>

                    </div>
                </section>

            </div>
        <div style="clear:all;"></div>

        </div>

        <div class="resto3" style="display: none;">

            <h3
                style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 60px; padding-left: 50px;">
                Notícias e eventos
            </h3>

            <h5
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 20px;">
                Duis a mollis urna. In hac habitasse platea dictumst. Vestibulum nisi nunc, elementum et vehicula vel,
                rhoncus non metus.
                In vel dapibus dolor. Sed at laoreet turpis. Donec nec aliquam velit. Quisque blandit nisi mauris.
                Nunc euismod lacus ante, id ornare dolor aliquet nec. Aenean aliquam vestibulum metus, a vestibulum sem
                eleifend id.
                Donec at quam purus. Integer lobortis sapien at arcu feugiat, sed aliquam lectus laoreet.
                Vestibulum dictum sollicitudin mauris, id condimentum libero venenatis pellentesque. Nullam lacinia
                pretium sem, ac mattis lectus tempus ut.
                Nullam eget odio eu odio feugiat placerat at a risus. Nullam id ligula in quam cursus hendrerit. Donec
                facilisis ultrices elit.Sed a odio tortor.
                Phasellus non accumsan est. Sed eu nibh quis mauris finibus viverra ac sit amet eros. Nullam vel
                sagittis massa. Quisque faucibus egestas aliquet.
                Duis facilisis ipsum ut convallis egestas. Nam aliquam risus dictum erat aliquam egestas. Quisque et
                orci ut nulla accumsan congue ut et eros.
                Praesent vitae ipsum vel enim rutrum volutpat et non tortor. Donec egestas venenatis ipsum, sit amet
                imperdiet orci luctus in.
                Nulla malesuada sem turpis, sit amet dignissim dolor efficitur eu. In dui diam, sagittis rutrum
                fermentum sed, sodales sed nunc.
                Icitudin mauris, id condimentum libero venenatis pellentesque.
            </h5>

            <h5
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px; padding-bottom: 45px;">
                <b>duis a mollis urna. In hac habitasse platea dictumst. Vestibulum nisi nunc, elementum et vehicula
                    vel, rhoncus non metus.
                    In vel dapibus dolor. Sed at laoreet turpis. Donec nec aliquam velit. Quisque blandit nisi
                    mauris.</b>
            </h5>

        </div>

        <div class="resto4" style="display: none;">
            <h3
                style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 60px; padding-left: 50px;">
                Publicações
            </h3>

            <h5
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 20px;">
                Duis a mollis urna. In hac habitasse platea dictumst. Vestibulum nisi nunc, elementum et vehicula vel,
                rhoncus non metus.
                In vel dapibus dolor. Sed at laoreet turpis. Donec nec aliquam velit. Quisque blandit nisi mauris.
                Nunc euismod lacus ante, id ornare dolor aliquet nec. Aenean aliquam vestibulum metus, a vestibulum sem
                eleifend id.
                Donec at quam purus. Integer lobortis sapien at arcu feugiat, sed aliquam lectus laoreet.
                Vestibulum dictum sollicitudin mauris, id condimentum libero venenatis pellentesque. Nullam lacinia
                pretium sem, ac mattis lectus tempus ut.
                Nullam eget odio eu odio feugiat placerat at a risus. Nullam id ligula in quam cursus hendrerit. Donec
                facilisis ultrices elit.Sed a odio tortor.
                Phasellus non accumsan est. Sed eu nibh quis mauris finibus viverra ac sit amet eros. Nullam vel
                sagittis massa. Quisque faucibus egestas aliquet.
                Duis facilisis ipsum ut convallis egestas. Nam aliquam risus dictum erat aliquam egestas. Quisque et
                orci ut nulla accumsan congue ut et eros.
                Praesent vitae ipsum vel enim rutrum volutpat et non tortor. Donec egestas venenatis ipsum, sit amet
                imperdiet orci luctus in.
                Nulla malesuada sem turpis, sit amet dignissim dolor efficitur eu. In dui diam, sagittis rutrum
                fermentum sed, sodales sed nunc.
                Icitudin mauris, id condimentum libero venenatis pellentesque.
            </h5>

            <h5
                style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px; padding-bottom: 45px;">
                <b>duis a mollis urna. In hac habitasse platea dictumst. Vestibulum nisi nunc, elementum et vehicula
                    vel, rhoncus non metus.
                    In vel dapibus dolor. Sed at laoreet turpis. Donec nec aliquam velit. Quisque blandit nisi
                    mauris.</b>
            </h5>

        </div>
    </div>

</section>
<!-- end product section -->

<?=template_footer();?>

<script>
$(function() {

    $('button#showit').on('click', function() {
        $('.resto').show();
        $('.resto2').hide();
        $('.resto3').hide();
        $('.resto4').hide();
    });

    $('button#showit2').on('click', function() {
        $('.resto2').show();
        $('.resto').hide();
        $('.resto3').hide();
        $('.resto4').hide();
    });

    $('button#showit3').on('click', function() {
        $('.resto3').show();
        $('.resto').hide();
        $('.resto2').hide();
        $('.resto4').hide();
    });

    $('button#showit4').on('click', function() {
        $('.resto4').show();
        $('.resto').hide();
        $('.resto3').hide();
        $('.resto2').hide();
    });

});
</script>
</body>

</html>