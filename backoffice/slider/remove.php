<?php
require "../verifica.php";
require "../config/basedados.php";

$mainDir = "../assets/slider/";
if ($_SESSION["autenticado"] != 'administrador') {
    // Usuário não tem permissão para eliminar noticias redireciona para o index das noticias
    header("Location: index.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $sql = "DELETE FROM slider WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    //Se o request não for um post, selecionar os dados da base de dados para mostrar 
    $sql = "SELECT titulo, titulo_en, conteudo, conteudo_en, imagem FROM slider WHERE id = ?";
    $id = $_GET["id"];
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $titulo = $row["titulo"];
    $conteudo = $row["conteudo"];
    $imagem = $row["imagem"];
    $titulo_en = $row["titulo_en"];
    $conteudo_en = $row["conteudo_en"];
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
        <h5 class="card-header text-center">Remover Item Slider</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="remove.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value=<?php echo $id; ?>>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Titulo</label>
                            <input type="text" readonly name="titulo" class="form-control" data-error="Por favor adicione um titulo válido" id="inputTitle" placeholder="Titulo" value="<?php echo $titulo; ?>">
                            <!-- Error -->
                            <div class=" help-block with-errors">
                            </div>
                        </div>
                    </div>


                    <div class="col">
                        <div class="form-group">
                            <label>Titulo (Inglês)</label>
                            <input type="text" readonly name="titulo_en" class="form-control" placeholder="Titulo (Inglês)" value="<?php echo $titulo_en; ?>">
                            <!-- Error -->
                            <div class=" help-block with-errors">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col halfCol">
                        <div class="form-group" style="height: fit-content;">
                            <label>Conteúdo do Slider</label>
                            <div readonly class="form-control ck-content" style="width:100%; height:100%;"><?php echo $conteudo; ?></div>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                    <div class="col halfCol" style="height: fit-content;">
                        <div class="form-group">
                            <label>Conteúdo do Slider (Inglês)</label>
                            <div readonly class="form-control ck-content" style="width:100%; height:100%;"><?php echo $conteudo_en; ?></div>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                </div>
                <div class="mt-2">
                    <img id="preview" src="<?php echo $mainDir . $imagem; ?>" width='100px' height='100px' /><br><br>
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