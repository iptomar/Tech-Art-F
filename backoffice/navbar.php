<?php
//chama as funções para tradução
require_once 'assets/models/functions.php';
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<title>TECHN&ART Backoffice</title>
<style>
    .navUl {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #435d7d;
        font-size: 20px;
        font-family: 'Varela Round';
    }

    .navLi {
        float: left;
    }

    .navLi a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    .navLi a:hover {
        background-color: #324c6c;
        text-decoration: none;
        color: white;
    }

    .leftnav {
        display: block;
        position: absolute;
        right: 0%;
        color: white;
        background-color: #ff0000;
        text-align: center;
        padding: 14px 16px;
        text-decoration: dashed;
    }

    .leftnav:hover {
        background-color: #dd0000;
    }

    #button_pt_en{
        background-color: #007bff;
        padding: 8px 12px;
        margin-top: 3px;
        color:white;
        font-family:'Varela Round'
    }

    #button_pt_en:hover{
        background-color: #324c6c;
        color:white;
    }
</style>

<ul class="navUl">
    <li class="navLi">
        <button type="button" id="button_pt_en" onclick="submitLanguageForm('pt');">PT</button>
    </li>
    <li class="navLi">
        <button type="button" id="button_pt_en" onclick="submitLanguageForm('en');">EN</button>
    </li>
    <li class="navLi"><a href="../investigadores" data-translation='researcher-title'>Investigadores</a></li>
    <li class="navLi"><a href="../projetos">Projetos</a></li>
    <li class="navLi"><a href="../noticias">Notícias</a></li>
    <li class="navLi"><a href="../oportunidades">Oportunidades</a></li>
    <?php
    // Utilizador tem permissão para aceder ao administradores
    if ($_SESSION["autenticado"] == "administrador") {
        echo "<li class=\"navLi\"><a href=\"../administradores\" data-translation='admin-title'>Administradores</a></li>"; 
        echo "<li class='navLi'><a href='../admissoes' data-translation='admissions-title'>Admissões</a></li>";
        echo "<li class='navLi'><a href='../areas' data-translation='areas-title'>Editar Áreas</a></li>";
        echo "<li class='navLi'><a href='../duplicados' data-translation='duplicated-title'>Duplicados</a></li>";
        echo "<li class='navLi'><a href='../publicacoes' data-translation='publications-title'>Publicações</a></li>";
        echo "<li class='navLi'><a href='../slider' data-translation='slider'>Slider</a></li>";
        echo "<li class='navLi'><a href='../newsletter' data-translation='newsletter'>Newsletter</a></li>";

    }
    ?>
    <li class="navLi"><a class="leftnav" href="../sair.php" data-translation='exit'>Sair</a></li>
</ul>