<?php
require "../verifica.php";
require "../config/basedados.php";
require "bloqueador.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $titulo = $_POST["titulo"];
    $conteudo = $_POST["conteudo"];
    $data = $_POST["data"];
    //Se foi selecionada uma nova imagem, guardar na pasta dos assets
    if ($_FILES["imagem"]["size"] != 0) {
        $target_file = $_FILES["imagem"]["name"];
        move_uploaded_file($_FILES["imagem"]["tmp_name"], "../assets/noticias/" . $target_file);
        $sql = "UPDATE noticias SET titulo = ?, conteudo = ?, imagem = ?, data = ? WHERE id  = ?";
        $stmt = mysqli_prepare($conn, $sql);
        $imagem = $target_file;
        mysqli_stmt_bind_param($stmt, 'ssssi', $titulo, $conteudo, $imagem, $data, $id);
    } else {
        $sql = "UPDATE noticias SET titulo = ?, conteudo = ?, data = ? WHERE id  = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssi', $titulo, $conteudo, $data, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql . mysqli_error($conn);
    }
} else {

    //Se o request não for um post, selecionar os dados da base de dados para mostrar 
    $sql = "SELECT titulo, conteudo, imagem, data FROM noticias WHERE id = ?";
    $id = $_GET["id"];
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $titulo = $row["titulo"];
    $conteudo = $row["conteudo"];
    $data = $row["data"];
    $imagem = $row["imagem"];
}


?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</link>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<script type="text/javascript">
    function previewImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
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

    .ck-editor__editable {
        resize: vertical;
        min-height: 200px;
    }
</style>

<div class="container-xl mt-5">
    <div class="card">
        <h5 class="card-header text-center">Editar Notícia</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="edit.php" method="post" enctype="multipart/form-data">

                <input type="hidden" name="id" value=<?php echo $id; ?>>
                <div class="form-group">
                    <label>Título</label>
                    <input type="text" name="titulo" class="form-control" data-error="Por favor adicione o titulo" id="inputTitle" placeholder="Título" value="<?php echo $titulo; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Conteúdo da notícia</label>
                    <textarea class="form-control" cols="30" rows="5" data-error="Por favor adicione o conteudo da noticia" id="inputContent" name="conteudo"><?php echo $conteudo; ?></textarea>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Data da notícia</label>
                    <input type="date" class="form-control" id="inputDate" name="data" value="<?php echo $data ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Imagem</label>
                    <input type="file" class="form-control" id="inputImage" name="imagem" onchange="previewImg(this);" value="<?php echo $imagem; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <img id="preview" src="<?php echo "../assets/noticias/" . $imagem; ?>" width='100px' height='100px' /><br><br>

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

<!--Criar o CKEditor 5-->
<script src="../ckeditor5/build/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#inputContent'), {
            licenseKey: '',
        })
        .then(editor => {
            window.editor = editor;
        })
</script>

<?php
mysqli_close($conn);
?>