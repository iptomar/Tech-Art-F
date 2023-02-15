<?php
require "config/basedados.php";
// Inicia sessões 
session_start();
//Verifica se os estão inseridos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"]) && isset($_POST["senha"])) {
  //Verifica se os dados correspondem a um administrador
  $sql = "SELECT id FROM administradores WHERE email=? AND password=?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, 'ss', $login, $senha);
  $login = addslashes(trim($_POST["login"]));
  $senha = md5(trim($_POST["senha"]));
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if (mysqli_num_rows($result) == 1) {
    //Se for um admisnistrador guardar este facto nas variaveis de sessão
    $_SESSION["autenticado"] = 'administrador';
    header("Location: projetos/index.php");
  } else {
    // se não for um administrador verificar se os dados pertencem a um investigador
    $sql = "SELECT id, ultimologin FROM investigadores WHERE email=? AND password=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $login, $senha);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
      //se este é o seu primeiro login, guardar o facto que deve reiniciar a password
      if ($row["ultimologin"] == NULL) {
        $_SESSION["resetpassword"] = true;
      }
      //se pertencer a um investigador guardar o id do investigador
      $_SESSION["autenticado"] = $row["id"];
      header("Location: projetos/index.php");
      return;
    }
    //se os dados de autenticação não pertencerem nem a um administrador, nem a um investigador, mostrar mensagem
    echo "Login ou senha errados! <br><br>";
    //guardar o facto que não há nenhum utilizador autenticado
    $_SESSION["autenticado"] = false;
  }
}
?>
<HTML>

<BODY>

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="style.css" rel="stylesheet" />
  <!------ Include the above in your HEAD tag ---------->

  <div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Tabs Titles -->

      <!-- Login Form -->
      <form action="login.php" method="post">
        <input type="text" id="login" class="fadeIn first" name="login" placeholder="login">
        <input type="password" id="password" class="fadeIn second" name="senha" placeholder="password">
        <input type="submit" class="fadeIn third" value="OK!">
      </form>

    </div>
  </div>

</BODY>

</HTML>