<?php
// Verifica se o utilizador tem permissão para aceder às notícias
if ($_SESSION["autenticado"] != "administrador") {
    echo "<script> window.location.href = './index.php'; </script>";
    exit;
}
?>