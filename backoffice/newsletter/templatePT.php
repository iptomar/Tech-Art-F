<?php
function template_header_pt()
{
  echo '
    <!DOCTYPE html>
<style>
  p {
    margin-top: 0;
    margin-bottom: 0;
  }
  main {
    font-family: Roboto, Arial;
    background-color: rgb(247, 247, 247);
    margin: 0;
  }
  header {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    background-color: #333f50;
    top: 0;
    left: 0;
    right: 0;
    padding: 10px;
  }
  footer {
    height: 50px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    background-color: #333f50;
    bottom: 0;
    left: 0;
    right: 0;
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
  }
  .image-link {
    display: block;
    margin-right: 20px;
  }
  .image {
    width: 270px;
    height:270px;
    border-radius: 10px;
  }
  .item-bottom {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-top: 10px;
  }
  .title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
  }
  .date {
    font-size: 14px;
    color: #888;
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
        <img class="logo" src="../assets/newsletter/TechnArt12FundoTrans.png" />
      </div>
    </header>
    ';
}
function template_noticias_pt($titulo, $noticias)
{
  $noticias_json = json_decode($noticias, true);
  echo "<div class='content'>
    <h1 class='item'>$titulo</h1>";
  foreach ($noticias_json as $noticia) {
    echo "
        <div class='item'>
        <div class='item-top'>
          <a href='http://localhost/Tech-Art-F/tecnart/noticia.php?noticia=$noticia[id]' class='image-link'>
            <img class='image' src='../../backoffice/assets/noticias/$noticia[imagem]' />
          </a>
          <textarea class='textarea' readonly>$noticia[conteudo]</textarea>
        </div>
        <div class='item-bottom'>
          <div class='title'>$noticia[titulo]</div>
          <div class='date'>$noticia[data]</div>
        </div>
      </div>
        ";
  }
}

function template_footer_pt($token)
{
  echo "<footer>
    <a href='#' class='unsubscribe'>Unsubscribe</a>
  </footer>
</main>
</html>";
}
?>
