<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM investigadores');
$stmt->execute();
$investigadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "technart";

$con = mysqli_connect($servername, $username, $password, $dbname);
$sql = "SELECT * FROM investigadores";
$result = mysqli_query($con, $sql);


?>

<?= template_header('Publicações'); ?>

<section class='product_section layout_padding'>
    <div style='padding-top: 50px; padding-bottom: 30px;'>
        <div class='container'>
            <div class='heading_container2 heading_center2'>
                <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 33px; color:#333f50; text-transform: uppercase;">
                    <?= change_lang("publications-page-heading") ?>
                </h3><br><br>

                <?php

                $login = 'IPT_ADMIN';
                $password = 'U6-km(jD8a68r';


                if ($result->num_rows > 0) {
                    $a = array();
                    while ($row = $result->fetch_assoc()) {

                        $variable = $row["ciencia_id"];
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

                        /* $name = $row["nome"]; */

                        if (isset($data->{"output"}))

                            foreach ($data->{"output"} as $key) {
                                $book = $key->{"book"};


                                if (isset($book)) {

                                    array_push($a, $book);
                                }
                            }
                    }

                    function cb($x, $y)
                    {
                        return $x->{'publication-year'} <= $y->{'publication-year'};
                    }
                    usort($a, 'cb');
                    $ano = '';
                    foreach ($a as $book) {
                        if ($ano != $book->{'publication-year'}) {
                            $ano = $book->{'publication-year'};
                            echo "<br><br><b>" . $ano . "</b><br>";
                        }


                        /* echo $name.", "; */

                        echo str_replace(";", " & ", $book->{"authors"}->{"citation"});

                        echo ". (" . $book->{'publication-year'} . "). ";

                        echo $book->{"title"};

                        if (isset($book->{"volume"})) {
                            echo ", " . $book->{"volume"};
                        }

                        if (isset($book->{"number-of-pages"})) {
                            echo ", " . $book->{"number-of-pages"};
                        }

                        echo "<br>";
                    }
                }

                ?>

            </div>
        </div>
    </div>
</section>

<?= template_footer(); ?>