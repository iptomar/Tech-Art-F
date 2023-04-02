<?php
include 'models/functions.php';
?>

<!DOCTYPE html>
<html>

<?= template_header('Estrutura'); ?>


<!-- product section -->
<section class="product_section layout_padding">
    <div style="padding-top: 50px; padding-bottom: 30px;">
        <div class="container">
            <div class="heading_container2 heading_center2">

                <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 33px; color:#333f50; text-transform: uppercase;">
                    <?= change_lang("org-struct-page-heading") ?>
                </h3>


                <h4 style="font-family: 'Quicksand', sans-serif; font-size: 26px; padding-right: 660px; color:#060633; text-transform: uppercase; padding-top: 25px;">
                    <?= change_lang("org-struct-page-subtitle") ?>
                </h4>

                <div class="flex-container mobile_reverse">
                    <div class="flex-left">
                        <figure class="imgfigura">
                            <img class="imgestrutura w-100" style="max-width:330px;" src="./assets/images/P1010947.JPG" alt="Boat">
                            <figcaption class="imgs">O encontro, Luís Marques</figcaption>
                        </figure>
                    </div>
                    <div class="flex-right">
                        <?= change_lang("org-struct-page-description") ?><br><br>

                        <b><?= change_lang("org-struct-page-director-tag") ?><br> </b>Célio Gonçalo Marques<br><br>

                        <b><?= change_lang("org-struct-page-deputy-director-tag") ?><br> </b>Hermínia Maria Pimenta Ferreira Sol<br><br>

                        <b><?= change_lang("org-struct-page-admin-directors-tag") ?><br> </b>Hirondina Alves São Pedro<br><br>

                        <b><?= change_lang("org-struct-page-board-of-directors-tag") ?><br> </b><?= change_lang("director-deputy-director") ?><br>
                        Ricardo Pereira Triães<br>
                        Eunice Ferreira Ramos Lopes<br>
                        Regina Aparecida Delfino<br>
                        Marta Margarida S. Dionísio<br>
                        Ana Cláudia Pires da Silva<br><br>

                        <b><?= change_lang("org-struct-page-scinetific-conucil-tag") ?><br> </b><?= change_lang("all-integrated-members") ?><br><br>

                        <b><?= change_lang("org-struct-page-advisory-board-tag") ?><br>
                        </b><?= change_lang("advisory-board-one") ?><br>
                        <?= change_lang("advisory-board-two") ?><br>
                        <?= change_lang("advisory-board-three") ?><br>
                        <?= change_lang("advisory-board-four") ?><br>
                        <?= change_lang("advisory-board-five") ?><br>
                        <?= change_lang("advisory-board-six") ?><br><br>

                    </div>
                </div>

                <!--                 <div class="flex-container">
                    
                    <div class="flex-left2">
                        "tempor pulvinar. Vivamus ultrices egestas posuere. Integer magna orci, vestibulum."
                    </div>

                    <div class="flex-right">
                        luctus. Maecenas et quam rutrum, dignissim orci sodales, eleifend elit. Praesent viverra odio at volutpat aliquam. Aliquam vitae libero molestie,
                        laoreet tellus non, pretium orci. Maximus lacus sed, aliquet ex. Integer faucibus ante et magna finibus, ac consequat sapien commodo.
                        Aenean a condimentum diam. Sed facilisis felis neque, a volutpat libero euismod ut. Donec pellentesque metus at enim tempor fringilla.
                        Morbi dictum mauris sem, in commodo magna elementum eu. Uis ornare, ex ac rhoncus dictum, magna mauris tincidunt dolor
                        ed odio lacus, bibendum sed leo fringilla, vehicula finibus sem. Fusce urna sem, vehicula a accumsan sed, molestie id mi.
                        Donec tempus odio nec nisi euismod, ac volutpat purus laoreet. Luctus eu liber a fermentum. Sed pretium turpis enim.
                    </div>

                </div> -->


            </div>
        </div>
    </div>
</section>
<!-- end product section -->

<?= template_footer(); ?>

</body>

</html>