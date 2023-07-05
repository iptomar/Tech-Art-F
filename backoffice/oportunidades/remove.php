<?php
require "../verifica.php";
require "../config/basedados.php";

if ($_SESSION["autenticado"] != 'administrador') {
    // Usuário não tem permissão para eliminar oportunidades redireciona para o index das oportunidades
    header("Location: index.php");
    exit;
}
$mainDir = "../assets/oportunidades/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $sql = "DELETE FROM oportunidades WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (mysqli_stmt_execute($stmt)) {
        $uploadDir = $mainDir . "ficheiros_$id/";
        removeDirectory($uploadDir);
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    if (isset($_GET["id"])) {
        // Se o request não for um post, selecionar os dados da base de dados para mostrar 
        $sql = "SELECT titulo, conteudo, titulo_en, conteudo_en, imagem, visivel FROM oportunidades WHERE id = ?";
        $id = $_GET["id"];
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $titulo = $row["titulo"];
        $conteudo = $row["conteudo"];
        $titulo_en = $row["titulo_en"];
        $conteudo_en = $row["conteudo_en"];
        $imagem = $row["imagem"];
        $visivel = $row["visivel"] ? "checked" : "";
        $filesDir = $mainDir . "ficheiros_$id/pt/";
        $files = [];
        if (is_dir($filesDir)) {
            $files = scandir($filesDir);
            $files = array_diff($files, array('.', '..'));
        }
        $filesDirEn = $mainDir . ".ficheiros_$id/en/";
        $filesEn = [];
        if (is_dir($filesDirEn)) {
            $filesEn = scandir($filesDirEn);
            $filesEn = array_diff($filesEn, array('.', '..'));
        }
    }
}

function removeDirectory($dir)
{
    if (is_dir($dir)) {
        $files = glob($dir . '/*');
        foreach ($files as $file) {
            is_dir($file) ? removeDirectory($file) : unlink($file);
        }
        rmdir($dir);
    }
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

    .ck-content {
        overflow: auto;
        min-height: 100px;

    }

    .ck-content .image {
        clear: both;
        display: table;
        margin: 0.9em auto;
        min-width: 50px;
        text-align: center;
    }

    .ck-content .image-style-side {
        margin-top: 0;
        float: right;
        max-width: 50%;
    }

    .ck-content img {
        max-width: 100%;
        max-height: 100%;
    }


    .halfCol {
        max-width: 50%;
        display: inline-block;
        vertical-align: top;
        height: fit-content;
    }
</style>

<div class="container-xl mt-5">
    <div class="card">
        <h5 class="card-header text-center">Remover Oportunidade</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="remove.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="visivel" name="visivel" <?= $visivel ?> disabled>
                        <label class="form-check-label" for="visivel">
                            Visível
                        </label>
                    </div>
                </div>

                <input type="hidden" name="id" value=<?php echo $id; ?>>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Titulo</label>
                            <input readonly type="text" name="titulo" class="form-control" id="inputTitle" value="<?php echo $titulo; ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Titulo (Inglês)</label>
                            <input readonly type="text" name="titulo_en" class="form-control" id="inputTitleEn" value="<?php echo $titulo_en; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col halfCol">
                        <div class="form-group">

                            <label class="col-form-label">Conteúdo da oportunidade</label>
                            <div readonly class="form-control ck-content" style="width:100%; height:100%;"><?php echo $conteudo; ?></div>
                        </div>
                    </div>
                    <div class="col halfCol">
                        <div class="form-group">
                            <label class="col-form-label">Conteúdo (Inglês)</label>
                            <div readonly class="form-control ck-content" style="width:100%; height:100%;"><?php echo $conteudo_en; ?></div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col halfCol">
                        <div class="form-group">
                            <b>Ficheiros: </b>
                            <ul class="mb-3">
                                <?php
                                if (isset($files)) {
                                    foreach ($files as $file) {
                                        echo '<li>' . $file . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col halfCol">
                        <div class="form-group">
                            <b>Ficheiros (Inglês): </b>
                            <ul class="mb-3">
                                <?php
                                if (isset($filesEn)) {
                                    foreach ($filesEn as $file) {
                                        echo '<li>' . $file . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>



                <img id="preview" src="<?php echo $mainDir . $imagem; ?>" width='100px' height='100px' class="mb-2 mt-3" /><br>


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