<?php

//ficheiro para alterar a línguagem
session_start();
if (isset($_POST['newLanguage'])) {
    $_SESSION["lang"] = $_POST['newLanguage'];
} else {
    $_SESSION["lang"] = "pt";
}
