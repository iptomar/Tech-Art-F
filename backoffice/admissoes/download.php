<?php

if (isset($_POST['ficheiro'])) {
    $file_name =  $_POST['ficheiro']; // Replace with the desired filename and extension

    $file_path = $_POST['path'] . $file_name;

    if (file_exists($file_path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        ob_clean();
        flush();
        readfile($file_path);
        exit;
    } else {
        echo "ERRO Ficheiro não existe";
    }
}
