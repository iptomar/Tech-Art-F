<?php
include 'config/dbconnection.php';
include 'models/functions.php';

?>

<?= template_header('Publicações'); ?>
<section class='product_section layout_padding'>
    <div style='padding-top: 50px; padding-bottom: 30px;'>
        <div class='container'>
            <div class='heading_container3'>
                <h3 class="heading_h3" style="text-transform: uppercase;">
                    <?= change_lang("publications-page-heading") ?>
                </h3><br><br>
                <?php
                $pdo = pdo_connect_mysql();
                $query = "SELECT dados, YEAR(data) AS publication_year FROM publicacoes WHERE visivel = true ORDER BY data DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $publicacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $groupedPublicacoes = array();
                foreach ($publicacoes as $publicacao) {
                    $year = $publicacao['publication_year'];
                    $groupedPublicacoes[$year][] = $publicacao['dados'];
                } ?>
                <script src="../backoffice/assets/js/citation-js-0.6.8.js"></script>
                <script>
                    const Cite = require('citation-js');
                </script>

                <div id="publications">
                    <?php foreach ($groupedPublicacoes as $year => $publicacoes) : ?>
                        <div class="mb-5"> 
                            <b><?= $year ?></b><br>
                            <?php foreach ($publicacoes as $publicacao) : ?>
                                <div style="margin-left: 20px;">
                                    <script>
                                        var formattedCitation = new Cite(`<?= $publicacao ?>`).format('bibliography', {
                                            format: 'html',
                                            template: 'apa',
                                            lang: 'en-US'
                                        });;
                                        var citationContainer = document.createElement('div');
                                        citationContainer.innerHTML = formattedCitation;
                                        citationContainer.classList.add('mb-3'); 
                                        document.getElementById('publications').appendChild(citationContainer);
                                    </script>
                                </div>
                            <?php endforeach; ?>
                        </div><br>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= template_footer(); ?>