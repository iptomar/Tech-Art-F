<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM investigadores WHERE id=?');
$stmt->bindParam(1, $_GET["aluno"], PDO::PARAM_INT);
$stmt->execute();
$investigadores = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?= template_header('Aluno'); ?>

<!-- product section -->
<section>
    <div class="totall">
        <div class="barraesquerda">
            <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 38px; margin-bottom: 20px; color:#333f50; padding-top: 60px; padding-left: 60px; word-wrap: break-word;">
                <?= $investigadores['nome'] ?>
            </h3>
            <h5 class="canvasEmail">

                <canvas id="e"></canvas>
                <script>
                    var canvas = document.getElementById("e");
                    var context = canvas.getContext("2d");
                    context.fillStyle = "#060633";
                    context.font = "17px Arial Narrow, sans-serif";
                    context.fillText("<?= $investigadores['email'] ?>", 60, 20);
                </script>

            </h5>


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
                <a href="<?= $investigadores['orcid'] ?>"><span class="dot"></span></a>
                <a href="<?= $investigadores['scholar'] ?>"><span class="dot2"></span></a>
            </div>

        </div>

        <div id="resto" class="infoCorpo">
            <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px"
                src="../backoffice/assets/investigadores/<?= $investigadores['fotografia'] ?>" alt="">

            <h3
                style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 30px; padding-left: 50px;">
                <?= change_lang("about-tab-title-class") ?>
            </h3>

            <h5 class="textInfo" style="padding-bottom: 80px;">
                <?= $investigadores['sobre'] ?>
            </h5>

        </div>

        <div id="resto2" class="infoCorpo" style="display: none;">
            <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px"
                src="../backoffice/assets/investigadores/<?= $investigadores['fotografia'] ?>" alt="">

            <h3
                style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 30px; padding-left: 50px;">
                <?= change_lang("areas-tab-title-class") ?>
            </h3>

            <h5 class="textInfo" style="padding-bottom: 40px;">
                <?= $investigadores['areasdeinteresse'] ?>
            </h5>

            <!--                         <h5 class="textInfo" style="padding-bottom: 40px;">
                        Phasellus non accumsan est. Sed eu nibh quis mauris finibus viverra ac sit amet eros. Nullam vel sagittis massa. Quisque faucibus egestas aliquet. 
                        Duis facilisis ipsum ut convallis egestas. Nam aliquam risus dictu.
                        </h5>
                    
                        <h5 class="textInfo" style="padding-bottom: 40px;">
                        Duis facilisis ipsum ut convallis egestas. Nam aliquam risus dictum erat aliquam egestas. Quisque et orci ut nulla accumsan congue ut et eros. 
                        Praesent vitae ipsum vel enim rutrum volutpat et non tortor. Donec egestas vene.
                        </h5>
                     -->
        </div>

        <div id="resto3" class="infoCorpo" style="display: none;">
            <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px"
                src="../backoffice/assets/investigadores/<?= $investigadores['fotografia'] ?>" alt="">

            <h3
                style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 30px; padding-left: 50px;">
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




                        echo "<h5 class='textInfo' style='padding-bottom: 10px;'>";
                        echo str_replace(";", " & ", $book->{"authors"}->{"citation"});

                        echo ". (" . $book->{$publication_year} . "). ";

                        echo $book->{"title"};

                        if (isset($book->{"volume"})) {
                            echo ", " . $book->{"volume"};
                        }

                        if (isset($book->{"number-of-pages"})) {
                            echo ", " . $book->{"number-of-pages"};
                        }

                        echo "<br>" . "</h5>";

                    }
                }

            echo "<br><br><br>"

                ?>

            <!--                         <h5 class="textInfo" style="padding-bottom: 120px;">
                            Uis falus non accumsan est.
                        </h5> -->

        </div>

        <div id="resto4" class="infoCorpo" style="display: none;">
            <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px"
                src="../backoffice/assets/investigadores/<?= $investigadores['fotografia'] ?>" alt="">

            <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 30px; padding-left: 50px;">
                <?= change_lang("projects-tab-title-class") ?>
            </h3>

            <div class="textInfo" style="padding-bottom: 20px;">
                <?php
                $stmt = $pdo->prepare('SELECT p.* FROM investigadores_projetos ip INNER JOIN projetos p ON p.id = ip.projetos_id Where ip.investigadores_id = ?');
                $stmt->bindParam(1, $_GET["aluno"], PDO::PARAM_INT);
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
                                            <div class="image">
                                                <img class="centrare" style="object-fit: cover; width:225px; height:280px;"
                                                    src="../backoffice/assets/projetos/<?= $projeto['fotografia'] ?>"
                                                    alt="">
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