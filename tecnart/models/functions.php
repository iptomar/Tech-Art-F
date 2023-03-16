<?php


function template_header($title){
    echo <<<EOT

                <head>
                <!-- Basic -->
                <meta charset="utf-8" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                <!-- Mobile Metas -->
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
                <!-- Site Metas -->
                <meta name="keywords" content="" />
                <meta name="description" content="" />
                <meta name="author" content="" />
                <link rel="shortcut icon" href="images/favicon.png" type="">
                <title>$title</title>
                <!-- bootstrap core css -->
                <link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.css" />
                <!-- font awesome style -->
                <link href="./assets/css/font-awesome.min.css" rel="stylesheet" />
                <!-- Custom styles for this template -->
                <link href="./assets/css/style.css" rel="stylesheet" />
                <!-- responsive style -->
                <link href="./assets/css/responsive.css" rel="stylesheet" />
                <link rel="stylesheet" href="./assets/css/owl.carousel.min.css">
                <link href="https://fonts.googleapis.com/css?family=Mansalva|Roboto&display=swap" rel="stylesheet">

                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="./assets/fonts/icomoon/style.css">

                <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" 
                integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@700&display=swap" rel="stylesheet">
          
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@700&family=PT+Sans&display=swap" rel="stylesheet">

                <link rel="stylesheet" type="text/css" href="./assets/css/font-awesome.css">
                <link rel="stylesheet" href="./assets/css/owl-carousel.css">

                <link rel="stylesheet" href="./assets/css/lightbox.css'">

                <link rel="stylesheet" href="https://code.jquery.com/jquery-3.4.1.min.js">

                <link rel="stylesheet" href="./assets/css/open-iconic-bootstrap.min.css">
                <link rel="stylesheet" href="./assets/css/animate.css">
                <link rel="stylesheet" href="./assets/css/owl.carousel.min.css">
                <link rel="stylesheet" href="./assets/css/owl.theme.default.min.css">
                <link rel="stylesheet" href="./assets/css/magnific-popup.css">
                <link rel="stylesheet" href="./assets/css/aos.css">
                <link rel="stylesheet" href="./assets/css/ionicons.min.css">
                <link rel="stylesheet" href="./assets/css/flaticon.css">
                <link rel="stylesheet" href="./assets/css/icomoon.css">


                <link rel="stylesheet" href="./assets/vendors/fontawesome/css/all.min.css">
                <link rel="stylesheet" href="./assets/vendors/themify-icons/themify-icons.css">
                <link rel="stylesheet" href="./assets/vendors/nice-select/nice-select.css">
                <link rel="stylesheet" href="./assets/vendors/owl-carousel/owl.theme.default.min.css">
                <link rel="stylesheet" href="./assets/vendors/owl-carousel/owl.carousel.min.css">

                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                
                <style type="text/css">
 
                body > .skiptranslate {
                    display: none;
                }
                body {
                    top: 0px !important; 
                    }
                 
                 .goog-logo-link {
                    display:none !important;
                } 
                    
                .goog-te-gadget{
                    color: transparent !important;
                }

                #developmentWarningEN,#developmentWarningPT{
                  position:fixed;
                  top:0;
                  right:0;
                  z-index: 2;
                  opacity: 0.8;
                  max-width: 190px;
                  width:25%
                }
                 
                </style>
                
               
               

            
                </head>
                
                <body>

                <!--Image warns users that website is in development-->
                <div id="developmentWarningEN">
                  <a href="http://www.techneart.ipt.pt/"><img class="w-100" src="./assets/images/developmentWarningEN.png" alt="#" /></a> 
                </div>
                <div id="developmentWarningPT">
                  <a href="http://www.techneart.ipt.pt/"><img class="w-100" src="./assets/images/developmentWarningPT.png" alt="#" /></a>
                </div>

                <div style="padding-bottom: 0px;" class="hero_area">
                    <!-- header section strats --><!--duplicar o tamanho do header -->
                    <header style="padding-bottom: 0px;" class="header_section2">
                    
                            <nav style="padding-bottom: 0px; height: 40px;" class="navbar navbar-expand-lg custom_nav-container ">
                                <div style="padding-bottom: 0px;" class="collapse navbar-collapse" id="navbarSupportedContent">
                                        
                                <!-- <form class="form-inline">
                                        <button class="btn  my-2 my-sm-0 nav_search-btn">
                                        <i style="padding-left: 1125px; padding-top: 19px;" class="fa fa-search" aria-hidden="true"></i>
                                        </button> 
                                    </form> -->


                                <ul class="navbar-nav">
                                
                                    <li style="padding-top: 25px;" class="nav-item">
                                        <div style="margin-right: 140px;" id='google_translate_element'></div>
                                    </li>
                                
                                </ul>
                                                        
                                </div>
                            </nav>
                        
                    </header>
                    </div>

                    <div style="padding-top: 0px;"class="hero_area">
                    <!-- header section strats -->
                    <header style="padding-top: 0px;" class="header_section">
                        <div style="padding-top: 0px;" class="container">
                            <nav style="padding-top: 0px;" class="navbar navbar-expand-lg custom_nav-container ">
                                
                                <div id="logo2" style="max-width:300px; width:85%;">
                                  <a class="navbar-brand" href="index.php"><img class="w-100" src="./assets/images/TechnArt5FundoTrans.png" alt="#" /></a> <!--Logo que redireciona para o index.html-->
                                </div>
                                
                                <div style="display: none; max-width:300px; width:70%;" id="logo">
                                  <a class="navbar-brand" href="index.php"><img class="w-100" src="./assets/images/TechnArt11FundoTrans.png" alt="#" /></a> <!--Logo que redireciona para o index.html-->
                                </div>

                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span></span>
                                </button>
                                
                                <div style="padding-top: 0px;" class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav">

                                <li class="nav-item dropdown">
                                        <a class="nav-link" id="sobretechn" href="sobre.php" role="button" aria-haspopup="true" aria-expanded="true"> <span class="nav-label">Sobre o Techn&art <span class="caret"></span></a>
                                        <div class="dropdown-content">
                                            <a href="missao.php">Missão e Objetivos</a>
                                            <a href="eixos.php">Eixos de Investigação</a>
                                            <a href="estrutura.php">Estrutura Orgânica</a>
                                            <a href="oportunidades.php">Oportunidades</a>
                                    </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="projetos.php">Projetos</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" id="sobretechn" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> <span class="nav-label">INVESTIGADORES/AS <span class="caret"></span></a>
                                        <div class="dropdown-content">
                                            <a href="integrados.php">Integrados/as</a>
                                            <a href="colaboradores.php">Colaboradores/as</a>
                                            <a href="alunos.php">Alunos/as</a>
                                    </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="noticias.php">Notícias</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="publicacoes.php">Publicações</a>
                                    </li>                     
                                </div>
                            </nav>
                        </div>
                    </header>
                    </div>
                    <!-- end header section -->

EOT;
}

function template_footer(){

    echo <<<EOT
                <!-- footer start -->
                <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">

                        <div class="full">

                        <div class="logo_footer" id="logo4">
                        <a href="#"><img width="320" src="./assets/images/TechnArt6FundoTrans.png" alt="#" /></a>
                        </div>

                        <div style="display: none;" class="logo_footer" id="logo3">
                        <a href="#"><img width="320" src="./assets/images/TechnArt12FundoTrans.png" alt="#" /></a>
                        </div>

                        </div>

                    </div>
                        <div class="col-md-8">
                            <div class="row">
                            <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="widget_menu">
                                        <ul>
                                        <li><a style="color: white;">Quinta do Contador,</a></li>
                                        <li><a style="color: white;">Estrada da Serra</a></li>
                                        <li><a style="color: white;">2300-313 Tomar - Portugal</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                                <div class="widget_menu">
                                    <br><ul><li><a style="color: white;">sec.techenart@ipt.pt</a></li></ul>
                                </div>
                                <div class="widget_menu">
                                    <br><ul><li><a style="color: white;"><strong>SIGA-NOS</strong></a></li></ul>
                                </div>
                                <div class="container">
                                    <span><a href="https://www.facebook.com"><i id ="fateste" class="fab fa-facebook-f"></i>&nbsp</a></span>
                                    <span><a style="color: white; font-size: 19px;" href="https://www.youtube.com"><i class="fab fa-youtube"></i></a></span>
                                </div>
                            </div> 

                            <div class="col-md-5">
                            <div class="full">
                            <div class="logo_footer">
                                    <a href="#"><img width="210" src="./assets/images/politecnico-de-tomar-verde.png" alt="#" /></a>
                                </div>
                                <div class="logo_footer">
                                    <a href="#"><img width="270" src="./assets/images/2017_FCT_H_branco.png" alt="#" /></a>
                                </div>
                                <div class="information_f">
                                    <p style="color: white; font-size: 13px;">Projeto UD/05488/2020</p>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                </footer>
                <!-- footer end -->
                <div class="cpy_">
                <p class="mx-auto" style="font-size: 13px; padding-bottom: 20px;">©Instituto Politécnico de Tomar | Todos os direitos reservados<br></p>
                </div>

                <!-- jQery -->
                <script src="./assets/js/jquery-3.4.1.min.js"></script>
                <!-- popper js -->
                <script src="./assets/js/popper.min.js"></script>
                <!-- bootstrap js -->
                <script src="./assets/js/bootstrap.js"></script>
                <!-- custom js -->
                <script src="./assets/js/custom.js"></script>
                <script src="./assets/js/owl.carousel.min.js"></script>
            <!-- <script src="./assets/js/jquery.min.js"></script> -->
                <script src="./assets/js/jquery-migrate-3.0.1.min.js"></script>
                <script src="./assets/js/popper2.min.js"></script>
                <script src="./assets/js/bootstrap.min.js"></script>
                <script src="./assets/js/jquery.easing.1.3.js"></script>
                <script src="./assets/js/jquery.waypoints.min.js"></script>
                <script src="./assets/js/jquery.stellar.min.js"></script>
                <script src="./assets/js/owl.carousel.min.js"></script>
                <script src="./assets/js/jquery.magnific-popup.min.js"></script>
                <script src="./assets/js/aos.js"></script>
                <script src="./assets/js/jquery.animateNumber.min.js"></script>
                <script src="./assets/js/scrollax.min.js"></script>
                <script src="./assets/js/main.js"></script>
            <!--  <script src="./assets/js/jquery-2.1.0.min.js"></script> -->
                <script src="./assets/js/owl-carousel.js"></script>
                <script src="./assets/js/accordions.js"></script>
                <script src="./assets/js/datepicker.js"></script>
                <script src="./assets/js/scrollreveal.min.js"></script>
                <script src="./assets/js/waypoints.min.js"></script>
                <script src="./assets/js/jquery.counterup.min.js"></script>
                <script src="./assets/js/imgfix.min.js"></script> 
                <script src="./assets/js/slick.js"></script> 
                <script src="./assets/js/lightbox.js"></script> 
                <script src="./assets/js/isotope.js"></script> 
                
            <!--  <script src="./assets/vendors/jquery/jquery-3.2.1.min.js"></script> -->
                <script src="./assets/vendors/bootstrap/bootstrap.bundle.min.js"></script>
                <script src="./assets/vendors/skrollr.min.js"></script>
                <script src="./assets/vendors/owl-carousel/owl.carousel.min.js"></script>
                <script src="./assets/vendors/nice-select/jquery.nice-select.min.js"></script>
                <script src="./assets/vendors/jquery.ajaxchimp.min.js"></script>
                <script src="./assets/vendors/mail-script.js"></script>
                <script src="./assets/js/main2.js"></script>


                <script type="text/javascript">

                function googleTranslateElementInit() {
                  const lang = getCookie("googtrans");
                  if (lang == "") {
                    setCookie('googtrans', '/en/pt', 1);
                  }
            
                  new google.translate.TranslateElement({
                    autoDisplay: 'true',
                    includedLanguages: 'pt,en',
                    layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
                  }, 'google_translate_element');
            
                  document.getElementsByClassName("goog-te-combo")[0].addEventListener("change", function () {
                    imagens();
                  })

                 
                          
                  if (lang == "/en/pt") {
                    
                    document.getElementById('logo2').className = "show";
                    document.getElementById('logo').className = "hidden"; 
                    document.getElementById('logo4').className = "show";
                    document.getElementById('logo3').className = "hidden"; 
                    document.getElementById('developmentWarningEN').className = "hidden";
                    document.getElementById('developmentWarningPT').className = "show";       
                  } else {
                    
                    document.getElementById('logo').className = "show";
                    document.getElementById('logo2').className = "hidden";
                    document.getElementById('logo3').className = "show";
                    document.getElementById('logo4').className = "hidden";
                    document.getElementById('developmentWarningEN').className = "show";
                    document.getElementById('developmentWarningPT').className = "hidden";       
                  }
                }

                function getLangSelecionada() {
                    const e = document.getElementsByClassName("goog-te-combo")[0];
                    return e.options[e.selectedIndex].value;
                  }


            
                function imagens() {
                  const lang = getLangSelecionada();
                  
                  if (lang == "pt") {
                    setCookie('googtrans', '/en/pt', 1);
                    document.getElementById('logo2').className = "show";
                    document.getElementById('logo').className = "hidden"; 
                    document.getElementById('logo4').className = "show";
                    document.getElementById('logo3').className = "hidden"; 
                    document.getElementById('developmentWarningEN').className = "hidden";
                    document.getElementById('developmentWarningPT').className = "show";                       
                  } else {
                    setCookie('googtrans', '/en/en', 1);
                    document.getElementById('logo').className = "show";
                    document.getElementById('logo2').className = "hidden";
                    document.getElementById('logo3').className = "show";
                    document.getElementById('logo4').className = "hidden";
                    
                    document.getElementById('developmentWarningEN').className = "show";
                    document.getElementById('developmentWarningPT').className = "hidden";                        
                  }
                }
            
                function getCookie(cname) {
                  let name = cname + "=";
                  let decodedCookie = decodeURIComponent(document.cookie);
                  let ca = decodedCookie.split(';');
                  for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') {
                      c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                      return c.substring(name.length, c.length);
                    }
                  }
                  return "";
                }
            
                function setCookie(key, value, expiry) {
                  var expires = new Date();
                  expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
                  document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
                }
            
            
              </script>

                <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>




EOT;

}