<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "technart";

$con = mysqli_connect($servername, $username, $password, $dbname);
$sql="SELECT * FROM investigadores";
$result = mysqli_query($con,$sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $variable = $row["ciencia_id"];

        echo(" Value: " . $variable . "<br>");
    }
}

 

?>