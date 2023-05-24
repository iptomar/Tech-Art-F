<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM investigadores WHERE id=?');
$stmt->bindParam(1, $_GET["integrado"], PDO::PARAM_INT);
$stmt->execute();
$investigadores = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?= template_header('Integrado'); ?>

<!-- product section -->
<section>
    <div class="totall">
        <div class="barraesquerda">
            <h3
                class="heading_h3" style="font-size: 38px; margin-bottom: 20px; padding-top: 60px; padding-right: 10px; padding-left: 60px; word-wrap: break-word;">
                <?= $investigadores['nome'] ?>
            </h3>
            <div class="canvasEmail" style="height:150px; padding-right: 10px;">

                <div class="emailScroll">
                    <canvas id="canvas" ></canvas>
                    <script>
                        const ratio = Math.ceil(window.devicePixelRatio);
                        const canvas = document.getElementById("canvas");
                        const txt= "<?= $investigadores['email'] ?>";
                        const context = canvas.getContext("2d");
                        context.font = "15px 'Montserrat', sans-serif";

                        width = context.measureText(txt).width+5
                        height = canvas.offsetHeight

                        canvas.width = width * ratio;
                        canvas.height = height * ratio;
                        canvas.style.width = `${width}px`;
                        canvas.style.height = `${height}px`;

                        context.font = "15px 'Montserrat', sans-serif";
                        context.fillStyle = "#060633";
                        context.setTransform(ratio, 0, 0, ratio, 0, 0);
                        context.fillText(txt, 0, 20);
                    </script>
                </div>
            </div>



            <button class="divbotao" id="showit">
                <span href="#" class="innerButton">
                    <?= change_lang("about-btn-class") ?>
                </span>
            </button>

            <button class="divbotao" id="showit2">
                <span href="#" class="innerButton">
                    <?= change_lang("areas-btn-class") ?>
                </span>
            </button>

            <button class="divbotao" id="showit3">
                <span href="#" class="innerButton">
                    <?= change_lang("publications-btn-class") ?>
                </span>
            </button>

            <button class="divbotao lastBtn" id="showit4">
                <span href="#" class="innerButton">
                    <?= change_lang("projects-btn-class") ?>
                </span>
            </button>

            <h5 class="nofinal">
                <?= change_lang("ext-links") ?>
            </h5>

            <div class="alinhado">
                <?= !empty(trim($investigadores['orcid'])) ? "<a class='link_externo orcid' href='https://orcid.org/" . $investigadores['orcid'] . "'></a>" : "" ?>
                <?= !empty(trim($investigadores['ciencia_id'])) ? "<a class='link_externo ciencia_id' href='https://www.cienciavitae.pt/" . $investigadores['ciencia_id'] . "'></a>" : "" ?>
                <?= !empty(trim($investigadores['research_gate'])) ? "<a class='link_externo research_gate' href=" . $investigadores['research_gate'] . "></a>" : "" ?> 
            </div>
        </div>
        <div id="resto" class="infoCorpo">
            <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px"
                src="../backoffice/assets/investigadores/<?= $investigadores['fotografia'] ?>" alt="">

            <h3
                class="heading_h3" style="font-size: 30px; margin-bottom: 20px; padding-top: 30px; padding-right: 10px; padding-left: 50px;">
                <?= change_lang("about-tab-title-class") ?>
            </h3>

            <div class="textInfo" style="padding-bottom: 80px;">
                <?= $investigadores['sobre'] ?>
            </div>

        </div>

        <div id="resto2" class="infoCorpo" style="display: none;">
            <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px"
                src="../backoffice/assets/investigadores/<?= $investigadores['fotografia'] ?>" alt="">

            <h3
                class="heading_h3" style="font-size: 30px; margin-bottom: 20px; padding-top: 30px; padding-left: 50px;">
                <?= change_lang("areas-tab-title-class") ?>
            </h3>

            <div class="textInfo" style="padding-bottom: 40px;">
                <?= $investigadores['areasdeinteresse'] ?>
            </div>

        </div>

        <div id="resto3" class="infoCorpo" style="display: none;">
            <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px"
                src="../backoffice/assets/investigadores/<?= $investigadores['fotografia'] ?>" alt="">

            <h3
                class="heading_h3" style="font-size: 30px; margin-bottom: 20px; padding-top: 30px; padding-left: 50px;">
                <?= change_lang("publications-tab-title-class") ?>
            </h3>


            <?php


            $login = 'IPT_ADMIN';
            $password = 'U6-km(jD8a68r';


            $variable = $investigadores['ciencia_id'];
            $url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/" . $variable . "/output?lang=User%20defined";

            $ch = curl_init();

            $headers = array(
                "Content-Type: application/json",
                "Accept: application/json",
            );


            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");


            $holder = "publication-year";
            $result_curl = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($result_curl);
            $publication_year = "publication-year";

            $name = $investigadores['nome'];

            if (isset($data->{"output"}))

                foreach ($data->{"output"} as $key) {
                    $book = $key->{"book"};


                    if (isset($book)) {




                        echo "<div class='textInfo' style='padding-bottom: 10px;'>";
                        echo str_replace(";", " & ", $book->{"authors"}->{"citation"});

                        echo ". (" . $book->{$publication_year} . "). ";

                        echo $book->{"title"};

                        if (isset($book->{"volume"})) {
                            echo ", " . $book->{"volume"};
                        }

                        if (isset($book->{"number-of-pages"})) {
                            echo ", " . $book->{"number-of-pages"};
                        }

                        echo "<br>" . "</div>";

                    }



                }

            echo "<br><br><br>"

                ?>


        </div>

        <div id="resto4" class="infoCorpo" style="display: none;">
            <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px"
                src="../backoffice/assets/investigadores/<?= $investigadores['fotografia'] ?>" alt="">

            <h3
                class="heading_h3" style="font-size: 30px; margin-bottom: 20px; padding-top: 30px; padding-left: 50px;">
                <?= change_lang("projects-tab-title-class") ?>
            </h3>

            <div class="textInfo" style="padding-bottom: 20px;">
                <?php
                $stmt = $pdo->prepare('SELECT p.* FROM investigadores_projetos ip INNER JOIN projetos p ON p.id = ip.projetos_id Where ip.investigadores_id = ?');
                $stmt->bindParam(1, $_GET["integrado"], PDO::PARAM_INT);
                $stmt->execute();
                $projetos = $stmt->fetchall(PDO::FETCH_ASSOC);
                ?>
                <section class="product_section layout_padding">
                    <div style="padding-top: 20px;">
                        <div class="container">
                            <div class="row justify-content-center mt-3">
                                <?php foreach ($projetos as $projeto): ?>

                                    <div class="ml-5 imgList">
                                        <a href="projeto.php?projeto=<?= $projeto['id'] ?>">
                                            <div class="image_default">
                                                <img class="centrare" style="object-fit: cover; width:225px; height:280px;"
                                                    src="../backoffice/assets/projetos/<?= $projeto['fotografia'] ?>" alt="">
                                                <div class="imgText justify-content-center m-auto">
                                                    <?= $projeto['nome'] ?>
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

        </div>
    </div>


</section>
<!-- end product section -->

<?= template_footer(); ?>

<script>
    $(function () {

        $('button#showit').on('click', function () {
            $('#resto').show();
            $('#resto2').hide();
            $('#resto3').hide();
            $('#resto4').hide();
        });

        $('button#showit2').on('click', function () {
            $('#resto2').show();
            $('#resto').hide();
            $('#resto3').hide();
            $('#resto4').hide();
        });

        $('button#showit3').on('click', function () {
            $('#resto3').show();
            $('#resto').hide();
            $('#resto2').hide();
            $('#resto4').hide();
        });

        $('button#showit4').on('click', function () {
            $('#resto4').show();
            $('#resto').hide();
            $('#resto3').hide();
            $('#resto2').hide();
        });

    });

</script>
</body>

</html>