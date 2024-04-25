<?php
function template_header_en()
{
  echo '
    <!DOCTYPE html>
    <style>
    @media (max-width: 767px) {
      .item {
        align-items: center;
        width:320px;
      }
    
      .image-link {
        margin-right: 0;
        margin-bottom: 10px;
      }
    
      .textarea {
        display: none;
      }
    }
    
    p {
      margin-top: 0;
      margin-bottom: 0;
    }
    
    main {
      font-family: Roboto, Arial;
      background-color: rgb(247, 247, 247);
      margin: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    header {
      display: flex;
      flex-direction: column;
      align-items: flex-start; 
      justify-content: center;
      background-color: #333f50;
      width: 100%;
      padding: 10px;
      margin-bottom:20px;
    }
    
    .middle-section {
      display: flex;
      align-items: center;
    }
    
    footer {
      height: 50px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: center;
      background-color: #333f50;
      width: 100%;
      padding: 10px;
      margin-top:20px; 
    }
    
    .logo {
      width: 190px;
    }
    
    .unsubscribe {
      color: white;
      text-decoration: none;
      margin-right: 20px;
    }
    
    .content {
      display: grid;
      grid-template-columns: 1fr;
      column-gap: 15px;
      row-gap: 30px;
      width: 100%;
      max-width: 800px;
    }
    
    .item {
      display: grid;
      grid-template-rows: auto 1fr;
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .item-top {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    @media (min-width: 768px) {
      .item-top {
        flex-direction: row;
        align-items: flex-start;
      }
    }
    
    .image-link {
      display: block;
      margin-bottom: 10px;
    }
    
    @media (min-width: 768px) {
      .image-link {
        margin-right: 20px;
        margin-bottom: 0;
      }
    }
    
    .image {
      width: 270px;
      height: 270px;
      border-radius: 10px;
    }
    
    .item-bottom {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 10px;
    }
    
    @media (min-width: 768px) {
      .item-bottom {
        align-items: flex-start;
      }
    }
    
    .title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 5px;
      text-align: center;
    }
    
    @media (min-width: 768px) {
      .title {
        text-align: left;
      }
    }
    
    .date {
      font-size: 14px;
      color: #888;
      text-align: center;
    }
    
    @media (min-width: 768px) {
      .date {
        text-align: left;
      }
    }
    
    .textarea {
      width: 100%;
      height: 270px;
      resize: none;
      overflow-y: auto;
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 10px;
      box-sizing: border-box;
      font-family: "Georgia", serif;
      font-size: 16px;
      line-height: 1.5;
      color: #333;
    }
    </style>
<html>
  <main>
    <header>
      <div></div>
      <div class="middle-section">
        <img class="logo" src="../assets/newsletter/TechnArt11FundoTrans.png" />
      </div>
    </header>
    ';
}
function template_noticias_en($title, $noticias)
{
  $noticias_json = json_decode($noticias, true);
  echo "<div class='content'>
    <h1 class='item'>$title</h1>";
  foreach ($noticias_json as $noticia) {
    echo "
        <div class='item'>
        <div class='item-top'>
          <a href='http://localhost/Tech-Art-F/tecnart/noticia.php?noticia=$noticia[id]' class='image-link'>
            <img class='image' src='../../backoffice/assets/noticias/$noticia[imagem]' />
          </a>
          <textarea class='textarea' readonly>$noticia[conteudoEn]</textarea>
        </div>
        <div class='item-bottom'>
          <div class='title'>$noticia[tituloEn]</div>
          <div class='date'>$noticia[data]</div>
        </div>
      </div>
        ";
  }
}

function template_footer_en($token)
{
  echo "<footer>
    <a href='#' class='unsubscribe'>Unsubscribe</a>
  </footer>
</main>
</html>";
}
?>
