<?php

$sql = "SELECT gestores_id FROM gestores_projetos WHERE projetos_id = " . $_GET["id"];
$result = mysqli_query($conn, $sql);
$selected = array();
if (mysqli_num_rows($result) > 0) {
    while (($row = mysqli_fetch_assoc($result))) {
        $selected[] = $row['gestores_id'];
    }
}

if ($_SESSION["autenticado"] != "administrador" && !in_array($_SESSION["autenticado"], $selected)) {
    echo "<script> window.location.href = './index.php'; </script>";
    exit;
}

?>