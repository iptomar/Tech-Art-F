<?php
require "../verifica.php";
require "../config/basedados.php";

$mainDir = "../assets/projetos/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_file = uniqid() . '_' . $_FILES["fotografia"]["name"];
    $target_file_logo = uniqid() . '_' . $_FILES["logo"]["name"];
    //transferir a imagem para a pasta de assets
    move_uploaded_file($_FILES["fotografia"]["tmp_name"], $mainDir . $target_file);
    //transferir o logo para a pasta de assets
    move_uploaded_file($_FILES["logo"]["tmp_name"], $mainDir . $target_file_logo);

    //adicionar novo projeto na base de dados
    $sql = "INSERT INTO projetos (nome, nome_en, descricao, descricao_en, sobreprojeto, sobreprojeto_en, referencia, referencia_en, areapreferencial, areapreferencial_en, financiamento, financiamento_en, ambito, ambito_en, fotografia, concluido, site, site_en, facebook, facebook_en,logo) " .
        "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssssssssssssisssss', $nome, $nome_en, $descricao, $descricao_en, $sobreprojeto, $sobreprojeto_en, $referencia, $referencia_en, $areapreferencial, $areapreferencial_en, $financiamento, $financiamento_en, $ambito, $ambito_en, $fotografia, $concluido, $site, $site_en, $facebook, $facebook_en,$logo);

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $sobreprojeto = $_POST["sobreprojeto"];
    $referencia = $_POST["referencia"];
    $fotografia = $target_file;
    $areapreferencial = $_POST["areapreferencial"];
    $financiamento = $_POST["financiamento"];
    $ambito = $_POST["ambito"];
    $gestores = $_POST["gestores"];
    $investigadores = [];
    $concluido = isset($_POST['concluido']) ? 1 : 0;
    $site = $_POST["site"];
    $facebook = $_POST["facebook"];
    $nome_en = $_POST["nome_en"];
    $descricao_en = $_POST["descricao_en"];
    $sobreprojeto_en = $_POST["sobreprojeto_en"];
    $referencia_en = $_POST["referencia_en"];
    $areapreferencial_en = $_POST["areapreferencial_en"];
    $financiamento_en = $_POST["financiamento_en"];
    $ambito_en = $_POST["ambito_en"];
    $site_en = $_POST["site_en"];
    $facebook_en = $_POST["facebook_en"];
    $logo = $target_file_logo;

    if (isset($_POST["investigadores"])) {
        $investigadores = $_POST["investigadores"];
    }
    if (mysqli_stmt_execute($stmt)) {
        if (count($investigadores) > 0) {
            $sqlinsert = "";
            foreach ($investigadores as $id) {
                $sqlinsert = $sqlinsert . "($id,last_insert_id()),";
            }
            $sqlinsert = rtrim($sqlinsert, ",");
            $sql = "INSERT INTO investigadores_projetos (investigadores_id,projetos_id) values" . $sqlinsert;

            if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        $sql = "INSERT INTO gestores_projetos (gestores_id, projetos_id) VALUES ";
        $idsGestores = [];
        foreach ($gestores as $id) {
            $idsGestores[] = "($id, last_insert_id())";
        }
        $sql .= implode(", ", $idsGestores);
        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        echo "<script> window.location.href = './index.php'; </script>";
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}



?>


<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</link>
<link rel="stylesheet" type="text/css" href="../assets/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script type="text/javascript">
    function previewImg(input,foto_or_logo) {
        if(foto_or_logo=="fotografia"){
            preview = "#preview"
        }
        if(foto_or_logo=="logo"){
            preview = "#preview_logo"
        }

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(preview).attr('src', e.target.result);
                $(preview).show();
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $(preview).attr('src', '');
            $(preview).hide();
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

    .choices__item.choices__item--selectable {
        background-color: #59A9FF;
        text: white
    }

    .choices__item.choices__item--choice {
        background-color: #E0E0E0;
    }
</style>

<div class="container-xl mt-5 mb-5">
    <div class="card">
        <h5 class="card-header text-center">Criar Projeto</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="create.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="concluido" name="concluido">
                        <label class="form-check-label" for="concluido">
                            Concluído
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" placeholder="Nome" minlength="1" required maxlength="100" data-error="Por favor introduza um nome válido" name="nome" class="form-control" id="inputName">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Nome (Inglês)</label>
                            <input type="text" placeholder="Nome (Inglês)" maxlength="100" data-error="Please enter a valid English name" name="nome_en" class="form-control" id="inputNameEn">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Descrição</label>
                            <textarea class="form-control" placeholder="Descrição" minlength="1" required maxlength="200" data-error="Por favor introduza uma descrição" id="inputDescricao" name="descricao"></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Descrição (Inglês)</label>
                            <textarea class="form-control" placeholder="Descrição (Inglês)" maxlength="200" id="inputDescricaoEn" name="descricao_en"></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col halfCol">
                        <div class="form-group">
                            <label>Sobre Projeto</label>
                            <textarea class="form-control ck_replace" placeholder="Sobre Projeto" cols="30" rows="5" data-error="Por favor introduza um 'sobre projeto'" id="inputSobreProjeto" name="sobreprojeto"></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col halfCol">
                        <div class="form-group">
                            <label>Sobre Projeto (Inglês)</label>
                            <textarea class="form-control ck_replace" placeholder="Sobre Projeto (Inglês)" cols="30" rows="5" id="inputSobreProjetoEn" name="sobreprojeto_en"></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Referência</label>
                            <input type="text" required minlength="1" placeholder="Referência" maxlength="100" data-error="Por favor introduza uma referência válida" class="form-control" id="inputReferencia" name="referencia">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Referência (Inglês)</label>
                            <input type="text" placeholder="Referência (Inglês)" maxlength="100" class="form-control" id="inputReferenciaEn" name="referencia_en">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>TECHN&ART área preferencial</label>
                            <input type="text" placeholder="TECHN&ART área preferencial" minlength="1" required maxlength="255" data-error="Por favor introduza uma área preferencial" class="form-control" id="inputAreaPreferencial" name="areapreferencial">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>TECHN&ART área preferencial (Inglês)</label>
                            <input type="text" placeholder="TECHN&ART área preferencial (Inglês)" maxlength="255" class="form-control" id="inputAreaPreferencialEn" name="areapreferencial_en">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Financiamento</label>
                            <input type="text" placeholder="Financiamento" minlength="1" required maxlength="20" data-error="Por favor introduza um financiamento válido" válido class="form-control" id="inputFinanciamento" name="financiamento">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Financiamento (Inglês)</label>
                            <input type="text" placeholder="Financiamento (Inglês)" maxlength="20" class="form-control" id="inputFinanciamentoEn" name="financiamento_en">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Âmbito</label>
                            <input type="text" placeholder="Âmbito" minlength="1" required maxlength="100" data-error="Por favor introduza um âmbito válido" class="form-control" id="inputAmbito" name="ambito">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Âmbito (Inglês)</label>
                            <input type="text" placeholder="Âmbito (Inglês)" maxlength="100" class="form-control" id="inputAmbitoEn" name="ambito_en">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Site</label>
                            <input type="text" placeholder="Site" minlength="1" maxlength="100" data-error="Por favor introduza um site válido" class="form-control" id="inputSite" name="site">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Site (Inglês)</label>
                            <input type="text" placeholder="Site (Inglês)" maxlength="100" class="form-control" id="inputSiteEn" name="site_en">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Facebook</label>
                            <input type="text" placeholder="Facebook" minlength="1" maxlength="100" data-error="Por favor introduza um link válido para o Facebook" class="form-control" id="inputFacebook" name="facebook">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Facebook (Inglês)</label>
                            <input type="text" placeholder="Facebook (Inglês)" maxlength="100" class="form-control" id="inputFacebookEn" name="facebook_en">
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Gestores/as</label><br>

                    <?php
                    $sql = "SELECT id, nome, email, tipo FROM investigadores;";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                    ?>
                        <select name="gestores[]" multiple required class="select form-control" id="gestores">
                            <?php
                            foreach ($result as $investigador) {
                                echo '<option value="' . $investigador['id'] . '">' . $investigador['nome'], " (", $investigador['email'], ")" . '</option>';
                            }
                            ?>
                        </select>
                    <?php
                    } ?>

                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Investigadores/as</label><br>

                    <?php
                    $sql = "SELECT id, nome, email, tipo FROM investigadores;";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                    ?>
                        <select name="investigadores[]" multiple class="select form-control" id="investigadores">
                            <?php
                            foreach ($result as $investigador) {
                                echo '<option value="' . $investigador['id'] . '">' . $investigador['nome'], " (", $investigador['email'], ")" . '</option>';
                            }
                            ?>
                        </select>
                    <?php
                    } ?>

                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <!-- User o Choices para permitir a multipla seleção de gestores e investigadores -->
                <script>
                    const choicesElementGestores = document.getElementById('gestores');
                    const choicesElementInvestigadores = document.getElementById('investigadores');
                    const choicesGestores = new Choices(choicesElementGestores, {
                        searchEnabled: false,
                        itemSelectText: '',
                        allowHTML: true,
                        removeItemButton: true
                    });
                    const choicesInvestigadores = new Choices(choicesElementInvestigadores, {
                        searchEnabled: false,
                        itemSelectText: '',
                        allowHTML: true,
                        removeItemButton: true
                    });
                </script>


                <div class="form-group">
                    <label>Fotografia</label>
                    <input accept="image/*" type="file" onchange="previewImg(this,'fotografia');" required accept="image/*" class="form-control-file" id="inputFotografia" name="fotografia">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                    <img id="preview" style="display: none;" class="mt-2" width='100px' height='100px' class="mb-3" />

                </div>

                <div class="form-group">
                    <label>Logotipo</label>
                    <input accept="image/*" type="file" onchange="previewImg(this,'logo');" required accept="image/*" class="form-control-file" id="inputLogo" name="logo">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                    <img id="preview_logo" style="display: none;" class="mt-2" width='100px' height='100px' class="mb-3" />
                </div>



                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary btn-block">Criar</button>
                </div>
                <div class="form-group">
                    <button type="button" onclick="window.location.href = 'index.php'" class="btn btn-danger btn-block">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../assets/js/jquery-3.7.1.min.js"></script>
<script src="../assets/js/select2.min.js"></script>
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
</script>

<?php
mysqli_close($conn);
?>