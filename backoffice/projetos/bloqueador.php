<?php
$id = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
}
else{
    $id = $_GET["id"];
}
$sql = "SELECT gestores_id FROM gestores_projetos WHERE projetos_id = " . $id;
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