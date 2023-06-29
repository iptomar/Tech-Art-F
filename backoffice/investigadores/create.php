<?php
require "../verifica.php";
require "../config/basedados.php";
//Se o utilizador não é um administrado
if ($_SESSION["autenticado"] != "administrador") {
    //não tem permissão para criar um novo investigador
    header("Location: index.php");
    exit;
}
$filesDir = "../assets/investigadores/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_file = uniqid() . '_' . $_FILES["fotografia"]["name"];
    //transferir a imagem para a pasta de assets
    move_uploaded_file($_FILES["fotografia"]["tmp_name"], $filesDir . $target_file);

    $sql = "INSERT INTO investigadores (nome, email, ciencia_id, sobre, sobre_en, tipo, fotografia, areasdeinteresse,areasdeinteresse_en, orcid, scholar, research_gate, scopus_id, password) " .
        "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssssssss', $nome, $email, $ciencia_id, $sobre, $sobre_en, $tipo, $fotografia, $areasdeinteresse, $areasdeinteresse_en, $orcid, $scholar, $research_gate, $scopus_id, $password);
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $ciencia_id = $_POST["ciencia_id"];
    $sobre = $_POST["sobre"];
    $sobre_en = $_POST["sobre_en"];
    $tipo = $_POST["tipo"];
    $fotografia = $target_file;
    $areasdeinteresse = $_POST["areasdeinteresse"];
    $areasdeinteresse_en = $_POST["areasdeinteresse_en"];
    $orcid = $_POST["orcid"];
    $scholar = $_POST["scholar"];
    $research_gate = $_POST["research_gate"];
    $scopus_id = $_POST["scopus_id"];
    $password = md5($_POST["password"]);
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

    textarea {
        min-height: 100px;
    }
</style>

<div class="container-xl mt-5">
    <div class="card">
        <h5 class="card-header text-center">Adicionar Investigador</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="create.php" method="post" enctype="multipart/form-data">


                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" minlength="1" required maxlength="100" required name="nome" class="form-control" data-error="Por favor introduza um nome válido" id="inputName" placeholder="Nome">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" minlength="1" required maxlength="100" required class="form-control" id="inputEmail" placeholder="Email" name="email">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" minlength="1" required maxlength="255" required class="form-control" id="inputPassword" placeholder="Password" name="password">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="row">
                    <div class="col halfCol">
                        <div class="form-group">
                            <label>Sobre</label>
                            <textarea type="text" minlength="1" required data-error="Por favor introduza uma descrição sobre si" class="form-control" id="inputSobre" placeholder="Sobre" name="sobre"></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col halfCol">
                        <div class="form-group">
                            <label>Sobre (Inglês)</label>
                            <textarea type="text" class="form-control" id="inputSobre" placeholder="Sobre (Inglês)" name="sobre_en"></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Áreas de interesse</label>
                            <textarea type="text" minlength="1" required data-error="Por favor introduza as suas áreas de interesse" class="form-control" id="inputAreasdeInteresse" placeholder="Áreas de interesse" name="areasdeinteresse"></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Áreas de interesse (Inglês)</label>
                            <textarea type="text" class="form-control" id="inputAreasdeInteresseEn" placeholder="Áreas de interesse (Inglês)" name="areasdeinteresse_en"></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>Tipo</label><br>
                    <select name="tipo" required>
                        <option value="">--Select--</option>
                        <option value="Colaborador">Colaborador</option>
                        <option value="Integrado">Integrado</option>
                        <option value="Aluno">Aluno</option>
                    </select>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>CiênciaVitae ID</label>
                    <input type="text" minlength="1" required maxlength="100" required data-error="Por favor introduza un ID válido" class="form-control" id="inputCienciaid" placeholder="CiênciaVitae ID" name="ciencia_id">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Orcid</label>
                    <input type="text" minlength="1" required maxlength="255" required data-error="Por favor introduza um orcID válido" class="form-control" id="inputOrcid" placeholder="Orcid" name="orcid">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Scholar</label>
                    <input type="text" minlength="1" maxlength="255" data-error="Por favor introduza um ID válido" class="form-control" id="inputScholar" placeholder="Scholar" name="scholar">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="research_gate">ResearchGate: </label>
                    <input placeholder="ResearchGate" name="research_gate" type="text" class="form-control" id="research_gate">
                </div>
                <div class="form-group">
                    <label for="scopus_id">ScopusID: </label>
                    <input placeholder="ScopusID" name="scopus_id" type="text" class="form-control" id="scopus_id">
                </div>
                <div class="form-group">
                    <label>Fotografia</label>
                    <input type="file" accept="image/*" onchange="previewImg(this);" minlength="1" maxlength="100" required data-error="Por favor adicione uma fotografia válida" class="form-control" id="inputFotografia" placeholder="Fotografia" name="fotografia">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <img id="preview" style="display: none;" width='100px' height='100px' class="mb-3" />

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