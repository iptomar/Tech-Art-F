<?php
session_start();
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM investigadores WHERE id=?');
$stmt->bindParam(1,$_GET["colaborador"],PDO::PARAM_INT);
$stmt->execute();
$investigadores = $stmt->fetch(PDO::FETCH_ASSOC);
?>

      <?=template_header('Colaborador');?>

      <!-- product section -->
      <section>
                <div class="totall">
                    <div class="barraesquerda">
                        <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 38px; margin-bottom: 20px; color:#333f50; padding-top: 60px; padding-left: 60px;">
                        <?=$investigadores['nome']?>
                        </h3>
                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 60px; color:#060633; padding-left: 60px;  padding-bottom: 80px;">
                        <?=$investigadores['email']?>
                        </h5>


                            <button class="divbotao" id="showit">
                                <span href="#" class="innerButton">
                                    sobre
                                </span>
                            </button>

                            <button class="divbotao" id="showit2">
                                <span href="#" class="innerButton">
                                    áreas de interesse
                                </span>
                            </button>

                            <button class="divbotao" id="showit3">
                                <span href="#" class="innerButton">
                                    publicações
                                </span>
                            </button>

                            <button class="divbotao" id="showit4" style="margin-bottom: 350px;">
                                <span href="#" class="innerButton">
                                    projetos
                                </span>
                            </button>

                        <h5 class="nofinal" style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; color:#060633; padding-bottom: 45px; padding-left: 190px;">
                            Ligações externas
                        </h5>

                        <div class="alinhado">
                            <a href="<?=$investigadores['orcid']?>"><span class="dot"></span></a>
                            <a href="<?=$investigadores['scholar']?>"><span class="dot2"></span></a>
                        </div>
  
                    </div>

                    <div class="resto">
                        <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px" src="../investigadores/<?=$investigadores['fotografia']?>" alt="">
                    
                        <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 30px; padding-left: 50px;">
                            Sobre
                        </h3>

                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 80px;">
                        <?=$investigadores['sobre']?>
                        </h5>
                    
                    </div>

                    <div class="resto2" style="display: none;">
                        <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px" src="../investigadores/<?=$investigadores['fotografia']?>" alt="">
                    
                        <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 30px; padding-left: 50px;">
                            Áreas de interesse
                        </h3>

                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 40px;">
                        Duis a mollis urna. In hac habitasse platea dictumst. Vestibulum nisi nunc, elementum et vehicula vel, rhoncus non metus.
                        In vel dapibus dolor. Sed at laoreet turpis. Donec nec aliquam velit. Quisque blandit nisi mauris.
                        </h5>

                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 40px;">
                        Phasellus non accumsan est. Sed eu nibh quis mauris finibus viverra ac sit amet eros. Nullam vel sagittis massa. Quisque faucibus egestas aliquet. 
                        Duis facilisis ipsum ut convallis egestas. Nam aliquam risus dictu.
                        </h5>
                    
                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 40px;">
                        Duis facilisis ipsum ut convallis egestas. Nam aliquam risus dictum erat aliquam egestas. Quisque et orci ut nulla accumsan congue ut et eros. 
                        Praesent vitae ipsum vel enim rutrum volutpat et non tortor. Donec egestas vene.
                        </h5>
                    
                    </div>

                    <div class="resto3" style="display: none;">
                        <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px" src="../investigadores/<?=$investigadores['fotografia']?>" alt="">
                    
                        <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 30px; padding-left: 50px;">
                            Publicações
                        </h3>
                    
                        <?php

                                $login = 'IPT_ADMIN';
                                $password = 'U6-km(jD8a68r';


                                $variable = $investigadores['ciencia_id'];
                                $url = "https://qa.cienciavitae.pt/api/v1.1/curriculum/". $variable ."/output?lang=User%20defined";
                            
                                $ch = curl_init();

                                $headers = array(
                                    "Content-Type: application/json",
                                    "Accept: application/json",
                                );


                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch, CURLOPT_URL,$url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
                                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                                curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");


                                $holder = "publication-year";
                                $result_curl = curl_exec($ch);
                                curl_close($ch);
                                $data = json_decode($result_curl);
                                $publication_year = "publication-year";

                                $name = $investigadores['nome'];

                                if(isset($data->{"output"}))

                                foreach($data->{"output"} as $key) {
                                $book=$key->{"book"};
                                if(isset($book)){
                                    

                                echo "<h5 style='font-size: 16px; padding-right: 200px; color:#060633; padding-left: 50px;'>". $name.", ";
                                echo $book->{"title"}.", (";
                                echo $book->{$publication_year}.")"."</h5>";
                                    
                                }
                                }
                           
                                echo "<br><br><br>"

                        ?>

<!--                         <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 120px;">
                            Uis falus non accumsan est.
                        </h5> -->

                    </div>

                    <div class="resto4" style="display: none;">
                        <img style="object-fit: cover; width:255px; height:310px; padding-left: 50px; padding-top: 50px" src="../investigadores/<?=$investigadores['fotografia']?>" alt="">
                    
                        <h3 style="font-family: 'Merriweather Sans', sans-serif; font-size: 30px; margin-bottom: 20px; color:#333f50; padding-top: 30px; padding-left: 50px;">
                            Projetos
                        </h3>

                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 20px;">
                            Convallis egestas.
                        </h5>
                    
                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 20px;">
                            Onvallis egestas.
                        </h5>

                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 20px;">
                            Accumsan est.
                        </h5>

                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 20px;">
                            Convallis egestas.
                        </h5>

                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 20px;">
                            Non accumsan est.
                        </h5>

                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 20px;">
                            Nam aliquam risu.
                        </h5>
                        
                        <h5 style="font-family: 'Arial Narrow, sans-serif'; font-size: 17px; padding-right: 200px; color:#060633; padding-left: 50px;  padding-bottom: 120px;">
                            Habitasse platea dictumst.
                        </h5>
                    
                    </div>  
                </div>
               

   </section>
      <!-- end product section -->

      <?=template_footer();?>

      <script>
            $(function(){

            $('button#showit').on('click',function(){  
                $('.resto').show();
                $('.resto2').hide();
                $('.resto3').hide();
                $('.resto4').hide();   
            });

            $('button#showit2').on('click',function(){  
                $('.resto2').show();
                $('.resto').hide();
                $('.resto3').hide();
                $('.resto4').hide();   
            });

            $('button#showit3').on('click',function(){  
                $('.resto3').show();
                $('.resto').hide();
                $('.resto2').hide();
                $('.resto4').hide();   
            });

            $('button#showit4').on('click',function(){  
                $('.resto4').show();
                $('.resto').hide();
                $('.resto3').hide();
                $('.resto2').hide();   
            });

            });
            
      </script>
   </body>
</html>