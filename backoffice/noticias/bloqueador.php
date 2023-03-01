<?php
// Verifica se o utilizador tem permissão para aceder aos administradores
if ($_SESSION["autenticado"] != "administrador") {
    header("Location: index.php");
    exit;
}
?>