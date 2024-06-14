<?php
require "../verifica.php";
require "../config/basedados.php";
require "bloqueador.php";

// define a diretoria dos conteúdos do slider
$mainDir = "../assets/slider/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // move a imagem carregada para a diretoria de armazenamento
    $target_file =  uniqid() . '_' . $_FILES["imagem"]["name"];
    move_uploaded_file($_FILES["imagem"]["tmp_name"], $mainDir . $target_file);

    // define os parâmetros de SQL para efetuar a inserção na tabela 
    $sql = "INSERT INTO slider (titulo, titulo_en, conteudo, conteudo_en, imagem, link) " .
        "VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    $titulo = $_POST["titulo"];
    $titulo_en = $_POST["titulo_en"];
    $conteudo = $_POST["conteudo"];
    $conteudo_en = $_POST["conteudo_en"];
    $link = $_POST["link"];
    $imagem = $target_file;
    // tenta inserir os dados na tabela
    mysqli_stmt_bind_param($stmt, 'ssssss', $titulo, $titulo_en, $conteudo, $conteudo_en, $imagem, $link);
    if (mysqli_stmt_execute($stmt)) {
        echo 'alert(Criado com sucesso.)';
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!-- incluir os estilos de css -->
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
                $('#preview').show();
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#preview').attr('src', '');
            $('#preview').hide();
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
        min-height: 200px;
    }

    .halfCol {
        max-width: 50%;
        display: inline-block;
        vertical-align: top;
        height: fit-content;
    }
</style>

<div class="container-xl mt-5">
<!--  div com os campos de inserção dos dados necessários  -->
    <div class="card">
        <h5 class="card-header text-center">Adicionar Item ao Slider</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="create.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Titulo</label>
                            <input type="text" minlength="1" required maxlength="100" name="titulo" class="form-control" data-error="Por favor adicione um titulo válido" id="inputTitle" placeholder="Titulo">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Titulo (Inglês)</label>
                            <input type="text" maxlength="100" name="titulo_en" class="form-control" placeholder="Titulo (Inglês)">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col halfCol">
                        <div class="form-group">
                            <label>Descrição do Slider</label>
                            <textarea class="form-control ck_replace" cols="30" rows="5" data-error="Por favor adicione a descrição do Slider" id="inputContent" name="conteudo"></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                    <div class="col halfCol">
                        <div class="form-group">
                            <label>Descrição do Slider (Inglês)</label>
                            <textarea class="form-control ck_replace" cols="30" rows="5" id="inputContentEn" name="conteudo_en"></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label>Link</label>
                    <input type="text" class="form-control" id="inputLink" name="link">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>


                <div class="form-group">
                    <label>Imagem</label>
                    <input type="file" accept="image/*" onchange="previewImg(this);" data-error="Por favor adicione uma imagem" required class="form-control" id="inputImage" name="imagem">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <img id="preview" style="display: none;" width='100px' height='100px' class="mb-3" />



                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Criar</button>
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
    $(document).ready(function() {
        $('.ck_replace').each(function() {
            ClassicEditor.create(this, {
                licenseKey: '',
                simpleUpload: {
                    uploadUrl: '../ckeditor5/upload_image.php'
                }
            }).then(editor => {
                window.editor = editor;
            });
        });
    });

    function isValidDate(dateString) {
        var dateRegex = /^\d{4}-\d{2}-\d{2}$/;
        if (!dateRegex.test(dateString)) {
            return false;
        }
        var date = new Date(dateString);
        if (isNaN(date.getTime())) {
            return false;
        }
        return true;
    }
</script>

<?php
mysqli_close($conn);
?>