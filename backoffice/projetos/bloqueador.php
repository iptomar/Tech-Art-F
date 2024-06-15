<?php
#inicialização da variavel que guarda o id 
$id = "";
#se o pedido vindo do servidor for do tipo post recebe o id pelo metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
}
#se o pedido não for um post recebe o id atraves do  metodo get
else{
    $id = $_GET["id"];
}
#cria a query que ira selecionar os gestoes pelo id 
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