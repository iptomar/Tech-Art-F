<?php 
require "basedados.php";
// Inicia sessões 
session_start(); 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"]) && isset($_POST["senha"])) {
$sql = "SELECT id FROM administradores WHERE email=? AND password=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ss', $login, $senha);
$login=addslashes(trim($_POST["login"]));
$senha=md5(trim($_POST["senha"]));
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


// Usuário não forneceu a senha ou o login 

if(mysqli_num_rows($result)==1) { 
    $_SESSION["autenticado"]= "administrador"; 
    header("Location: index.php");  
} else {  
    echo "Login ou senha errados! <br><br>";
    $_SESSION["autenticado"]= false; 
}
} ?>

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