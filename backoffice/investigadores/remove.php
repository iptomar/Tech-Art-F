<?php
require "../verifica.php";
require "../config/basedados.php";

if ($_SESSION["autenticado"] != 'administrador') {
    // Usuário não tem permissão para eliminar investigadores Redireciona para a página de login 
    header("Location: index.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $sql = "DELETE FROM investigadores_projetos WHERE investigadores_id = " . $id;
    mysqli_query($conn, $sql);
    $sql = "delete from investigadores where id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    $sql = "select nome, email, ciencia_id, sobre, tipo, areasdeinteresse, orcid, scholar, fotografia from investigadores " .
        "where id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $id = $_GET["id"];
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $nome = $row["nome"];
    $email = $row["email"];
    $ciencia_id = $row["ciencia_id"];
    $sobre = $row["sobre"];
    $tipo = $row["tipo"];
    $fotografia = $row["fotografia"];
    $areasdeinteresse = $row["areasdeinteresse"];
    $orcid = $row["orcid"];
    $scholar = $row["scholar"];
}


?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</link>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<style>
    .container {
        max-width: 550px;
    }

    .has-error label,
    .has-error input,
    .has-error textarea {
        color: red;
        border-color: red;
    }

    .list-unstyled li {
        font-size: 13px;
        padding: 4px 0 0;
        color: red;
    }
</style>

<div class="container-xl mt-5">
    <div class="card">
        <h5 class="card-header text-center">Remover Investigador</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="remove.php" method="post" enctype="multipart/form-data">

                <input type="hidden" name="id" value=<?php echo $id; ?>>
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" id="inputName" readonly value="<?php echo $nome; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="email" readonly value="<?php echo $email; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>CiênciaVitae ID</label>
                    <input type="text" class="form-control" id="inputCienciaid" name="ciencia_id" readonly value="<?php echo $ciencia_id; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Sobre</label>
                    <input type="sobre" class="form-control" id="inputSobre" name="sobre" readonly value="<?php echo $sobre; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Áreas de interesse</label>
                    <input type="text" class="form-control" id="inputAreasdeInteresse" name="areasdeinteresse" readonly value="<?php echo $areasdeinteresse; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Orcid</label>
                    <input type="text" maxlength="255" required class="form-control" id="inputOrcid" name="orcid" readonly value="<?php echo $orcid; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Scholar</label>
                    <input type="text" class="form-control" id="inputScholar" name="scholar" readonly value="<?php echo $scholar; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Tipo</label>
                    <input type="text" class="form-control" id="inputTipo" name="tipo" readonly value="<?php echo $tipo; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Fotografia</label>
                    <input type="text" class="form-control" id="inputFotografia" name="fotografia" readonly value="<?php echo "../assets/projetos/" . $fotografia; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Confirmar</button>
                </div>

                <div class="form-group">
                    <button type="button" onclick="window.location.href = 'index.php'" class="btn btn-danger btn-block">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
mysqli_close($conn);
?>