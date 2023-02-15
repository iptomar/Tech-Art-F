<?php

$sql = "SELECT investigadores_id FROM investigadores_projetos WHERE projetos_id = " . $_GET["id"];
$result = mysqli_query($conn, $sql);
$selected = array();
if (mysqli_num_rows($result) > 0) {
    while (($row = mysqli_fetch_assoc($result))) {
        $selected[] = $row['investigadores_id'];
    }
}

if ($_SESSION["autenticado"] != "administrador" && !in_array($_SESSION["autenticado"], $selected)) {
    header("Location: index.php");
    exit;
}

?>