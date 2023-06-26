<?php 

    //ficheiro php destinatário depois de clicar no link 'EN'

    session_start();
    if($_SESSION["lang"] == "pt"){
        $_SESSION["lang"] = "en";
    }
    header("Location: ".$_SESSION["basename"]);

?>