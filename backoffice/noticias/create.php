<?php
require "../verifica.php";
require "../config/basedados.php";
require "bloqueador.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_file = $_FILES["imagem"]["name"];
    move_uploaded_file($_FILES["imagem"]["tmp_name"], "../assets/noticias/" . $target_file);

    $sql = "INSERT INTO noticias (titulo, conteudo, imagem, data) " .
        "VALUES (?,?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    $titulo = $_POST["titulo"];
    $conteudo = $_POST["conteudo"];
    $imagem = $target_file;
    $data =$_POST["data"];
    mysqli_stmt_bind_param($stmt, 'ssss', $titulo, $conteudo, $imagem, $data);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
</style>

<div class="container mt-5">
    <div class="card">
        <h5 class="card-header text-center">Adicionar Administrador</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="create.php" method="post" enctype="multipart/form-data">


                <div class="form-group">
                    <label>Titulo</label>
                    <input type="text" name="titulo" class="form-control" data-error="Por favor adicione o titulo" id="inputTitle" placeholder="Nome">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Conteúdo da notícia</label>
                    <textarea class="form-control" cols="30" rows="5" data-error="Por favor adicione o conteudo da noticia" id="inputContent" name="conteudo"></textarea>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Data da notícia</label>
                    <input type="date" class="form-control" id="inputDate" name="data" value="<?php echo date('Y-m-d'); ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Imagem</label>
                    <input type="file" class="form-control" id="inputImage" name="imagem">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Gravar</button>
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