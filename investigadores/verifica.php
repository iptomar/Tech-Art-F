<?php
// Inicia sessões 
session_start(); 
// Verifica se existe os dados da sessão de login 
if(!isset($_SESSION["autenticado"])) { 
// Usuário não logado! Redireciona para a página de login 
header("Location: login.php"); 
exit; 
} 
?>
<input type="button" class="btn btn-danger" value="Sair" onclick="window.location.href = 'sair.php'">
