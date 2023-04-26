<?php
require "./config/dbconnection.php";
require "models/functions.php";

//Guardar um ficheiro na pasta pedido_<id pedido> mudando o nome do ficheiro
function save_file($id, $new_name, $file)
{
    $directory = "../backoffice/assets/ficheiros_admissao/admissao_$id/";
    if (!is_dir($directory) && !mkdir($directory, 0777, true)) {
        die("Erro não existe a directoria $directory");
    }
    if (move_uploaded_file($_FILES[$file]["tmp_name"], $directory . $new_name)) {
        return true;
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = pdo_connect_mysql();
    } catch (Exception $e) {
        echo '<script>alert("Ocorreu um erro a conectar à base de dados, por favor tente novamente")</script>';
    }
    if (isset($pdo) && !is_null($pdo)) {
        $sql = "INSERT INTO admissoes (
            `nome_completo`, `nome_profissional`, `ciencia_id`, 
            `orcid` , `email`, `telefone` , 
            `grau_academico`, `ano_conclusao_academico`, `area_academico`, `area_investigacao` , 
            `instituicao_vinculo`, `percentagem_dedicacao`, `pertencer_outro` , 
            `outro_texto`, `biografia`, `ficheiro_motivacao`, 
            `ficheiro_recomendacao`, `ficheiro_cv`, `ficheiro_fotografia`) " .
            "VALUES ( 
            :dados_nome, :dados_nome_prof, :dados_ciencia_id,
            :dados_orcid, :dados_email, :dados_telefone, 
            :dados_grau_academico, :dados_ano_conclusao_academico, :dados_area_academico, 
            :dados_area_investigacao, :dados_instituicao_vinculo, :dados_percentagem_dedicacao,
            :dados_pertencer_outro, :dados_outro_texto, :dados_biografia, :f_motivacao,
            :f_recomendacao, :f_cv, :f_fotografia
        )";
        $stmt = $pdo->prepare($sql);
        foreach ($_POST as $key => $value) {
            $param_name = 'dados_';
            if (substr($key, 0, strlen($param_name)) == $param_name) {
                $valuetype = PDO::PARAM_STR;
                //Verificar se os dados é o dados_pertencer_outro que usa bool não string
                if ($key == "dados_pertencer_outro") {
                    $valuetype =  PDO::PARAM_BOOL;
                    $value = $_POST['dados_pertencer_outro'] == 'true' ? true : false;
                }
                //Se o valor está vazio enviar como null
                if ($value == '') $value = null;
                $stmt->bindValue($key, $value, $valuetype);
            }
        }
        //Gerar nome para os ficheiros com a extenção
        $nome_motivacao = "motivacao" . time() . "." . pathinfo($_FILES["motivacao"]["name"], PATHINFO_EXTENSION);
        $nome_recomendacao = "recomendacao" . time() . "." . pathinfo($_FILES["recomendacao"]["name"], PATHINFO_EXTENSION);
        $nome_cv = "cv" . time() . "." . pathinfo($_FILES["cv"]["name"], PATHINFO_EXTENSION);
        $nome_fotografia = "fotografia" . time() . "." . pathinfo($_FILES["fotografia"]["name"], PATHINFO_EXTENSION);

        //Colocar os novos nomes no comando insert
        $stmt->bindParam("f_motivacao", $nome_motivacao, PDO::PARAM_STR);
        $stmt->bindParam("f_recomendacao", $nome_recomendacao, PDO::PARAM_STR);
        $stmt->bindParam("f_cv", $nome_cv, PDO::PARAM_STR);
        $stmt->bindParam("f_fotografia", $nome_fotografia, PDO::PARAM_STR);

        $pdo->beginTransaction();
        try {
            //Correr comando insert
            $stmt->execute();
            $id = $pdo->lastInsertId();
            //Guardar os ficheiros
            if (
                save_file($id, $nome_motivacao, "motivacao") &&
                save_file($id, $nome_recomendacao, "recomendacao") &&
                save_file($id, $nome_cv, "cv") &&
                save_file($id, $nome_fotografia, "fotografia")
            ) {
                $pdo->commit();
                header('Location: index.php');
                exit;
            } else {
                echo '<script>alert("Ocorreu um erro a guardar os ficheiros, por favor tente novamente")</script>';
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            echo '<script>alert("Ocorreu um erro a enviar o pedido, por favor tente novamente")</script>';
        }
    }
}
?>

<head>
    <title>Formulário de integração | TECHN&ART</title>
</head>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</link>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<style>
    .container {
        max-width: 850px;
    }

    .has-error label,
    .has-error input,
    .has-error textarea {
        color: red;
        border-color: red;
    }

    .form-group {
        margin-bottom: 40px;
    }

    .list-unstyled li {
        font-size: 13px;
        padding: 4px 0 0;
        color: red;
    }

    .message {
        padding: 10px 20px;
    }

    a {
        color: #212529;
    }

    a:hover {
        color: #212529;
    }

    textarea{
        min-height: 100px;
    }
    .align-option {
        margin-top: 10px;
        display: flex;
        justify-content: end;
        height: 25px;
    }
</style>
<div class="container mt-3">
    <div class="align-option w-100 mb-3">
        <a class="text-decoration-none pr-2" style="font-weight:<?= $_SESSION["lang"] == "pt" ? "bold" : "normal" ?>;" href="session_var_pt.php">PT</a>
        <a class="text-decoration-none" href="session_var_en.php" style="font-weight:<?= $_SESSION["lang"] == "en" ? "bold" : "normal" ?>;">EN</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mt-2 text-center"><?= change_lang("admission-title") ?></h5>
            <div class="message">
                <span class="text-format-content ">
                    <?= change_lang("admission-msg-1") ?>
                    <br><?= change_lang("admission-msg-2") ?>
                    <br><?= change_lang("admission-msg-3") ?>
                    <span><a href="mailto:sec.techneart@ipt.pt" class="linkified">sec.techneart@ipt.pt</a></span>
            </div>
        </div>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="admissao.php" method="post" enctype="multipart/form-data">
                <?php
                $dados = array(
                    "dados_nome" => change_lang("admission-name"),
                    "dados_nome_prof" => change_lang("admission-name-prof"),
                    "dados_ciencia_id" => change_lang("admission-cienciaid"),
                    "dados_orcid" => change_lang("admission-orcid"),
                    "dados_email" => change_lang("admission-email"),
                    "dados_telefone" =>  change_lang("admission-cellphone"),
                    "dados_grau_academico" => change_lang("admission-academic-qualifications"),
                    "dados_ano_conclusao_academico" => change_lang("admission-year-conclusion"),
                    "dados_area_academico" => change_lang("admission-field-expertise"),
                    "dados_area_investigacao" => change_lang("admission-main-research-areas"),
                    "dados_instituicao_vinculo" => change_lang("admission-institucional-affliation"),
                    "dados_percentagem_dedicacao" => change_lang("admission-percentage-dedication-tech")
                );

                //Colocar os campos de input baseados no array dados
                foreach ($dados as $id => $nome) {
                    $placeholder = change_lang("admission-placeholder");
                    $type = "text";
                    if ($id == "dados_email") $type = "email";
                    echo "<div class='form-group'>
                    <label>$nome</label>
                    <input type='$type' id='$id' placeholder='$placeholder' name='$id' minlength='1' required maxlength='255' class='form-control'>
                    <!-- Error -->
                    <div class='help-block with-errors'></div>
                    </div>";
                }
                ?>
                <div class='form-group'>
                    <label><?= change_lang("admission-member-another") ?> </label>
                    <div class="form-check">
                        <input required value="true" class="form-check-input" type="radio" name="dados_pertencer_outro" id="dados_pertencer_outro1">
                        <label class="form-check-label" for="dados_pertencer_outro1">
                            <?= change_lang("admission-member-yes") ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input required value="false" class="form-check-input" type="radio" name="dados_pertencer_outro" id="dados_pertencer_outro2">
                        <label class="form-check-label" for="dados_pertencer_outro2">
                            <?= change_lang("admission-member-no") ?>
                        </label>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class='form-group'>
                    <label><?= change_lang("admission-another-centre-info") ?></label>
                    <input type='text' id='dados_outro_texto' placeholder="<?= change_lang("admission-placeholder") ?>" name='dados_outro_texto' minlength='1' class='form-control'>
                    <!-- Error -->
                    <div class='help-block with-errors'></div>
                </div>

                <div class='form-group'>
                    <label><?= change_lang("admission-biography") ?></label>
                    <textarea id='dados_biografia' placeholder="<?= change_lang("admission-placeholder") ?>" name='dados_biografia' required class='form-control'></textarea>
                    <!-- Error -->
                    <div class='help-block with-errors'></div>
                </div>

                <div class="form-group">
                    <label><?= change_lang("admission-motivation") ?></label>
                    <input type="file" id="motivacao" name="motivacao" required class="form-control">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label><?= change_lang("admission-recommendation") ?></label>
                    <input type="file" id="recomendacao" name="recomendacao" required class="form-control">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label><?= change_lang("admission-cv") ?></label>
                    <input type="file" id="cv" name="cv" required class="form-control">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label><?= change_lang("admission-photo") ?></label>
                    <input type="file" id="fotografia" name="fotografia" required class="form-control">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block mb-3"><?= change_lang("admission-submit") ?></button>
                    <button type="button" onclick="window.location.href = 'index.php'" class="btn btn-danger btn-block"><?= change_lang("admission-cancel") ?></button>
                </div>

            </form>
        </div>
    </div>
</div>