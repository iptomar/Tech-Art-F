<?php
    require "basedados.php";



    $sql = "SELECT nome, email, sobre, sobre, tipo, fotografia FROM investigadores";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $array = array();
        while($row = mysqli_fetch_assoc($result)) {
            array_push($array, $row);  
        }
    }
    mysqli_close($conn); 
        echo json_encode($array);

      
?>