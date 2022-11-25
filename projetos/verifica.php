<?php
// Inicia sessões 
session_start(); 
// Verifica se existe os dados da sessão de login 
if(!isset($_SESSION["autenticado"])) { 
// Usuário não logado! Redireciona para a página de login 
header("Location: login.php"); 
exit; 
} 
if(isset($_SESSION["resetpassword"])){
    header("Location: resetpassword.php"); 
    exit;  
}
// Verifica se os dados da sessão de login inseridos foram os corretos 
if(!$_SESSION["autenticado"]){
    header("Location: login.php"); 
    exit;
}

?>
<input type="button" class="btn btn-danger" value="Sair" onclick="window.location.href = 'sair.php'">
