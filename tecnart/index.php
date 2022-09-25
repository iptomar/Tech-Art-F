<?php
session_start();
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM investigadores');
$stmt->execute();
$investigadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

      <?=template_header('Index');?>

         <!-- slider section -->
         <section class="home-slider owl-carousel">
      <div class="slider-item" style="background-image:url('https://cdn.pixabay.com/photo/2021/08/25/20/42/field-6574455__480.jpg');">
      	<div class="overlay"></div>
        
          <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate mb-md-5">
          <h1 style="padding-top: 180px;" class="mb-4">SOBRE O TECHN&ART</h1>
          	<span class="subheading">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                At augue eget arcu dictum. Iaculis eu non diam.</span>
            <p><a href="sobre.php" class="btn btn-primary px-4 py-3 mt-3">SAIBA MAIS</a></p>
          
        </div>
        </div>
      </div>

      <div class="slider-item" style="background-image:url('https://i0.wp.com/multarte.com.br/wp-content/uploads/2015/08/imagens-amor.jpg?fit=1680%2C1050&ssl=1');">
      	<div class="overlay"></div>
  
          <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate mb-md-5">
            <h1 style="padding-top: 180px;" class="mb-4">We Help to Grow Your Business</h1>
            <span class="subheading">Aliquam malesuada bibendum arcu vitae elementum. Risus at ultrices mi tempus imperdiet nulla malesuada. 
               Magna fringilla urna porttitor rhoncus. Magna fermentum iaculis eu nons.</span>
            <p><a href="sobre.php" class="btn btn-primary px-4 py-3 mt-3">SAIBA MAIS</a></p>

        </div>
        </div>
      </div>

      <div class="slider-item" style="background-image:url('https://www.2net.com.br//Repositorio/251/Publicacoes/23883/3c2fd25f-c.jpg');">
      	<div class="overlay"></div>
        
          <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate mb-md-5">
          <h1 style="padding-top: 180px;" class="mb-4">We Are The Best Consulting Agency</h1>
          	<span class="subheading">Pulvinar neque laoreet suspendisse interdum consectetur libero. Sed tempus urna et pharetra pharetra. 
                Et egestas quis ipsum suspendisse. Euismod in pellentesque massa placerat.</span>
            <p><a href="sobre.php" class="btn btn-primary px-4 py-3 mt-3">SAIBA MAIS</a></p>
       
        </div>
        </div>
      </div>

    </section>
         <!-- end slider section -->
      
      <!-- why section -->
      <section class="why_section layout_padding">
         <div class="container">
            <div class="heading_container heading_center">
               <h3>
                  VÍDEO INSTITUCIONAL
               </h3>
               <div class="tamanho">
                  <h5>
                     Orci a scelerisque purus semper eget duis at tellus at. Metus dictum at tempor commodo ullamcorper a lacus vestibulum Libero volutpat sed cras ornare.
                  </h5>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="ajustar">
                     <video src="./assets/images/TheRangeTechnology.mp4" controls width="800" height="500"></video>
                  </div>
                </div>
            </div>
         </div>
      </section>
      <!-- end why section -->
      
      <!-- product section -->
   <section class="product_section layout_padding">
      <div style="background-color: #d4ced0; padding-top: 50px; padding-bottom: 50px;">
         <div class="container">
            <div class="heading_container2 heading_center2">
               
                  <h3>
                     PROJETOS DE I&D &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
                     &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                  </h3>
               
                     <a style="display: inline-block; padding: 5px 25px; background-color:#333F50; border: 2px solid #000000; color: #ffffff; border-radius: 0; 
                     -webkit-transition: all 0.3s; transition: all 0.3s;  font-family: 'Quicksand', sans-serif;  font-size: 20px;" 
                     href="projetos.php">
                     VER TODOS
                     </a>
               
            </div>
            <div class="row">
            <?php 
             $sql = "SELECT id, nome, descricao, fotografia FROM projetos ORDER BY id DESC limit 4";
             $stmt = $pdo->prepare($sql);
             $stmt->execute();
             $projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);
             foreach($projetos as $row){
                     ?>
                     <div class="col">
                     <div style="padding-top: 40px">
                     <div class="img-box">
                     <a href="projeto.php?projeto=<?=$row["id"];?>">
                     <img style="object-fit: cover; width:230px; height:230px;" src="../projetos/<?=$row["fotografia"];?>" alt="">
                     </a>
                     </div>
                     </div>
                     <div class="detail-box">
                     <div style="color: #333F50; padding-left: 15px; padding-top: 15px; text-align: center; width:210px;">
                     <a href="projeto.php?projeto=<?=$row["id"];?>" style="color:#000000;">
                        <h5>
                            <?=$row["nome"];?>
                        </h5>
                     </a>
                     </div>
                     <div style="padding-left: 30px; text-align: center; width:210px;">
                        <h6>
                           <?=substr($row["descricao"],0,150);?>...
                        </h6>
                     </div>
                     </div>
               </div>
                     <?php
                    }
                
                ?>
               
              

               
            </div>     
         </div>
      </div>
   </section>
      <!-- end product section -->

      <!-- client section -->

    <section class="section-margin calc-60px">
    <div style="padding-bottom: 50px;">
      <div class="container">
        <div class="section-intro pb-60px">
          <h2 style="font-family: 'Quicksand', sans-serif; padding-bottom: 20px; padding-left: 50px;">ÚLTIMAS NOTÍCIAS</h2>
        </div>

        <div class="owl-carousel owl-theme" id="bestSellerCarousel">
          <div class="card-product">
                  <div class="absoluto">
                        <div class="image">
                           <img class="img-fluid" src="https://www.noticiasdafloresta.pt/images/2021/Ministra_Agricultura_visita_SGS.jpg" alt="">
                                 <div class="text-block">
                                       <h5 style="font-size: 20px; text-transform: uppercase; font-weight: 600;">Visita aos laboratórios</h5>
                                       <h6 style="font-size: 14px; font-weight: 100;">Nec feugiat in fermentum posuere urna nec tincidunt praesent semper.</h6>
                                       <h6 style="font-size: 11px; font-weight: 100;">31.01.2022</h6>
                                 </div>
                        </div>
                  </div>
          </div>

          <div class="card-product">
                  <div class="absoluto">
                        <div class="image">
                           <img class="img-fluid" src="https://www.ourem.pt/wp-content/uploads/2022/01/2022.01.03-Reuniao-da-Camara-Municipal-executivo--scaled.jpg" alt="">
                                 <div class="text-block">
                                       <h5 style="font-size: 20px; text-transform: uppercase; font-weight: 600;">Reunião com a CM Angra do Heroísmo</h5>
                                       <h6 style="font-size: 14px; font-weight: 100;">Nec feugiat in fermentum posuere urna nec tincidunt praesent semper.</h6>
                                       <h6 style="font-size: 11px; font-weight: 100;">27.01.2022</h6>
                                 </div>
                        </div>
                  </div>
          </div>

          <div class="card-product">
                  <div class="absoluto">
                        <div class="image">
                           <img class="img-fluid" src="https://static.globalnoticias.pt/dn/image.jpg?brand=DN&type=generate&guid=028a0e1a-ea3d-45a9-9a30-24679dcca4eb" alt="">
                                 <div class="text-block">
                                       <h5 style="font-size: 20px; text-transform: uppercase; font-weight: 600;">Aprovação do partido</h5>
                                       <h6 style="font-size: 14px; font-weight: 100;">Nec feugiat in fermentum posuere urna nec tincidunt praesent semper.</h6>
                                       <h6 style="font-size: 11px; font-weight: 100;">25.01.2022</h6>
                                 </div>
                        </div>
                  </div>
          </div>

          <div class="card-product">
                  <div class="absoluto">
                        <div class="image">
                           <img class="img-fluid" src="https://imagens.publico.pt/imagens.aspx/1619935?tp=UH&db=IMAGENS&type=JPG&w=320&act=resize" alt="">
                                 <div class="text-block">
                                       <h5 style="font-size: 20px; text-transform: uppercase; font-weight: 600;">Reunião com o presidente</h5>
                                       <h6 style="font-size: 14px; font-weight: 100;">Nec feugiat in fermentum posuere urna nec tincidunt praesent semper.</h6>
                                       <h6 style="font-size: 11px; font-weight: 100;">23.01.2022</h6>
                                 </div>
                        </div>
                  </div>
          </div>

          <div class="card-product">
                  <div class="absoluto">
                        <div class="image">
                           <img class="img-fluid" src="https://www.noticiasdafloresta.pt/images/2021/Ministra_Agricultura_visita_SGS.jpg" alt="">
                                 <div class="text-block">
                                       <h5 style="font-size: 20px; text-transform: uppercase; font-weight: 600;">Visita aos laboratórios</h5>
                                       <h6 style="font-size: 14px; font-weight: 100;">Nec feugiat in fermentum posuere urna nec tincidunt praesent semper.</h6>
                                       <h6 style="font-size: 11px; font-weight: 100;">31.01.2022</h6>
                                 </div>
                        </div>
                  </div>
          </div>

          <div class="card-product">
                  <div class="absoluto">
                        <div class="image">
                           <img class="img-fluid" src="https://www.ourem.pt/wp-content/uploads/2022/01/2022.01.03-Reuniao-da-Camara-Municipal-executivo--scaled.jpg" alt="">
                                 <div class="text-block">
                                       <h5 style="font-size: 20px; text-transform: uppercase; font-weight: 600;">Reunião com a CM Angra do Heroísmo</h5>
                                       <h6 style="font-size: 14px; font-weight: 100;">Nec feugiat in fermentum posuere urna nec tincidunt praesent semper.</h6>
                                       <h6 style="font-size: 11px; font-weight: 100;">27.01.2022</h6>
                                 </div>
                        </div>
                  </div>
          </div>


          <div class="card-product">
                  <div class="absoluto">
                        <div class="image">
                           <img class="img-fluid" src="https://static.globalnoticias.pt/dn/image.jpg?brand=DN&type=generate&guid=028a0e1a-ea3d-45a9-9a30-24679dcca4eb" alt="">
                                 <div class="text-block">
                                       <h5 style="font-size: 20px; text-transform: uppercase; font-weight: 600;">Aprovação do partido</h5>
                                       <h6 style="font-size: 14px; font-weight: 100;">Nec feugiat in fermentum posuere urna nec tincidunt praesent semper.</h6>
                                       <h6 style="font-size: 11px; font-weight: 100;">25.01.2022</h6>
                                 </div>
                        </div>
                  </div>
          </div>

          <div class="card-product">
                  <div class="absoluto">
                        <div class="image">
                           <img class="img-fluid" src="https://imagens.publico.pt/imagens.aspx/1619935?tp=UH&db=IMAGENS&type=JPG&w=320&act=resize" alt="">
                                 <div class="text-block">
                                       <h5 style="font-size: 20px; text-transform: uppercase; font-weight: 600;">Reunião com o presidente</h5>
                                       <h6 style="font-size: 14px; font-weight: 100;">Nec feugiat in fermentum posuere urna nec tincidunt praesent semper.</h6>
                                       <h6 style="font-size: 11px; font-weight: 100;">23.01.2022</h6>
                                 </div>
                        </div>
                  </div>
          </div>

        </div>

        <div style="padding-left: 480px;">
        <a style="display: inline-block; padding: 5px 25px; background-color:#333F50; border: 2px solid #000000; color: #ffffff; border-radius: 0; 
                     -webkit-transition: all 0.3s; transition: all 0.3s;  font-family: 'Quicksand', sans-serif;  font-size: 20px;" 
                     href="">
                     VER TODAS
                     </a>
         </div>

      </div>
      </div>
    </section>

   <!-- end client section -->

          <?=template_footer();?>

   </body>
</html>