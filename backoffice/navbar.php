<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<style>
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #435d7d;
        font-size: 20px;
        font-family: 'Varela Round';
    }

    li {
        float: left;
    }

    li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    li a:hover {
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
</style>


<ul>
    <li><a href="../projetos">Projetos</a></li>
    <li><a href="../investigadores">Investigadores</a></li>
    <?php
    // Utilizador tem permissão para aceder ao administradores
    if ($_SESSION["autenticado"] == "administrador") {
        echo "  <li><a href=\"../administradores\">Administradores</a></li>";
    } ?>
    <li><a class="leftnav" href="../sair.php">Sair</a></li>
</ul>