<?php 

    //ficheiro php destinatário depois de clicar no link 'PT'

    session_start();
    if($_SESSION["lang"] == "en") {
        $_SESSION["lang"] = "pt";
    }
    header("Location: ".$_SESSION["basename"]);

?>