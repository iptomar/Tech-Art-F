<?php
require "../verifica.php";
require "../config/basedados.php";
require "bloqueador.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $uploadImg = "../assets/oportunidades/";
    if (!is_dir($uploadImg)) {
        mkdir($uploadImg, 0777, true);
    }
    $fileName =  uniqid() . '_' . $_FILES["imagem"]["name"];

    move_uploaded_file($_FILES["imagem"]["tmp_name"], $uploadImg . $fileName);

    $sql = "INSERT INTO oportunidades (titulo, conteudo, imagem,visivel) " .
        "VALUES (?,?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    $titulo = $_POST["titulo"];
    $conteudo = $_POST["conteudo"];
    $imagem = $fileName;
    $visivel = isset($_POST["visivel"]) ? 1 : 0;
    mysqli_stmt_bind_param($stmt, 'sssi', $titulo, $conteudo, $imagem, $visivel);
    if (mysqli_stmt_execute($stmt)) {
        if (isset($_FILES['ficheiros']) && !empty($_FILES['ficheiros']['name'][0])) {

            $id = mysqli_insert_id($conn);
            $uploadDir = "../assets/oportunidades/ficheiros_$id/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $files = $_FILES['ficheiros'];

            for ($i = 0; $i < count($files['name']); $i++) {
                $fileName = $files['name'][$i];
                $fileTmp = $files['tmp_name'][$i];
                $fileSize = $files['size'][$i];
                $uniqueFileName = $fileName;
                $destination = $uploadDir . $uniqueFileName;
                if (!move_uploaded_file($fileTmp, $destination)) {
                    echo "<script>
                    alert('Um erro ocurreu a inserir os ficheiros'" . $_FILES["file"]["error"][$i] . "');
                    window.location.href = 'edit.php?id=" . $id . "';
                    </script>";
                    exit;
                } else {
                    header('Location: index.php');
                }
            }
        } else {
            header('Location: index.php');
        }
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

    .ck-editor__editable {
        min-height: 200px;
    }
</style>
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

    function showFileName(input) {
        var fileListDiv = $('#fileList');
        fileListDiv.empty();

        var selectedFiles = input.files;
        if (selectedFiles.length > 0) {
            var fileNames = Array.from(selectedFiles).map(function(file) {
                return file.name;
            });


            fileNames.forEach(function(fileName) {
                var paragraph = '<li class="list-group-item">' + fileName + '<br>' + '</li>'
                fileListDiv.append(paragraph);
            });
        }
    }
</script>
<div class="container-xl mt-5">
    <div class="card">
        <h5 class="card-header text-center">Adicionar Oportunidade</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="create.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="visivel" name="visivel">
                        <label class="form-check-label" for="visivel">
                            Visível
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Titulo</label>
                    <input type="text" minlength="1" required maxlength="100" required name="titulo" class="form-control" data-error="Por favor adicione um titulo válido" id="inputTitle" placeholder="Nome">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label>Conteúdo da oportunidade</label>
                    <textarea class="form-control" cols="30" rows="5" id="inputContent" name="conteudo"></textarea>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label>Imagem</label>
                    <input accept="image/*" type="file"  onchange="previewImg(this);" required data-error="Por favor adicione uma imagem válida" class="form-control" id="inputImage" name="imagem">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <img id="preview" style="display: none;" width='100px' height='100px' class="mb-3" />

                <div class="form-group">
                    <label>Ficheiros</label>
                    <input type="file" onchange="showFileName(this)" multiple class="form-control" id="ficheiros" name="ficheiros[]">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                    <ul id="fileList" class="mb-3 list-group" style="font-size: 14px;"></ul>
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

<!--Criar o CKEditor 5-->
<script src="../ckeditor5/build/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#inputContent'), {
            licenseKey: '',

            simpleUpload: {
                uploadUrl: '../ckeditor5/upload_image.php'
            }
        })
        .then(editor => {
            window.editor = editor;
        })
    <?php require "../../tecnart/config/configurations.php"; ?>
    $("#ficheiros").on("change", function(e) {
        var totalSize = 0;
        var files = e.currentTarget.files;
        valid = true;
        var filesize = 0;
        for (let i = 0; i < files.length; i++) {
            filesize = ((files[i].size / 1024) / 1024);
            totalSize += filesize;

            if (filesize > <?= MAX_FILE_SIZE ?>) {
                valid = false;
                e.currentTarget.setCustomValidity('O tamanho do ficheiro "' + files[i].name + '" é maior que o máximo de <?= MAX_FILE_SIZE ?>MB');
            } else if (totalSize > <?= MAX_FILES_TOTAL ?>) {
                valid = false;
                e.currentTarget.setCustomValidity('Tamanho total de todos os ficheiros é maior  que o máximo de  <?= MAX_FILES_TOTAL ?>MB')
            }
        }
        if (valid) {
            e.currentTarget.setCustomValidity('');
        }
    });
</script>

<?php
mysqli_close($conn);
?>