<?php
include 'models/functions.php';
?>

<!DOCTYPE html>
<html>

<?= template_header('copyright-title'); ?>


<!-- product section -->
<section class="product_section layout_padding">
    <div style="padding-top: 50px; padding-bottom: 30px;">
        <div class="container">
            <div class="heading_container3">

                <h3 style="font-size: 33px; text-transform: uppercase;">
                    <?= change_lang("copyright-title") ?>
                </h3>

                <div>
                    <b><?= change_lang("copyright-design") ?></b>
                    <div class="ml-2 mt-1">
                        Andreia Nogueira<br>
                        João Pedro
                    </div><br>
                </div> 
                <b><p class="mb-1"><?= change_lang("copyright-p1") ?></p></b>
                <b><?= change_lang("copyright-advisor") ?></b>
                <div class="ml-2 mt-1">
                    Paulo Alexandre Gomes dos Santos <br>
                </div><br>

                <div>
                    <b><?= change_lang("copyright-students") ?></b>
                    <div class="ml-2 mt-1">
                        <b>2022/2023</b>
                        <br>Ângela Daniela Violante dos Reis nº 20946<br>
                        <br>Miguel Bruno Gonçalves Modesto nº 23033<br><br>

                        <b>2021/2022</b>
                        <br>David Alexandre Oliveira dos Santos nº 21293<br>
                        <br>Miguel António Cerejo Esteves nº 21292<br><br>
                    </div><br>
                </div>


            </div>
        </div>
    </div>
    </div>
</section>
<!-- end product section -->

<?= template_footer(); ?>

</body>

</html>