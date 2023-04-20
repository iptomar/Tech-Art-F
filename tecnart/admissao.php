<?php
require "./config/dbconnection.php";

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
        print_r($_POST);
        $sql = "INSERT INTO admissao (
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
                $stmt->bindParam($key, $value, $valuetype);
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
</style>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5 class="mt-2 text-center">Formulário de integração | TECHN&ART</h5>
            <div class="message">
                <span class="text-format-content ">
                    Caro/a investigador/a.
                    <br>Muito obrigado pelo seu interesse em integrar a nossa unidade I&D - TECHN&ART.
                    Para que a sua candidatura seja submetida a conselho científico, é necessário que seja preenchido este formulário.
                    <br>Caso seja necessário algum esclarecimento, não hesite em contactar o nosso secretariado, através do endereço
                    <span><a href="mailto:sec.techneart@ipt.pt" class="linkified">sec.techneart@ipt.pt</a></span><br>--<br>
                    Dear researcher,<br>Thank you very much for your interest in our R&D unit - TECHN&ART.
                    So that your proposal may proceed to the consideration of the scientific board, it is necessary
                    that you fill in this form.&nbsp;<br>If any questions arise, do not hesitate to contact our secretariat,
                    at&nbsp;<span><a href="mailto:sec.techneart@ipt.pt" class="linkified">sec.techneart@ipt.pt</a></span></span>
            </div>
        </div>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="admissao.php" method="post" enctype="multipart/form-data">
                <?php
                $dados = array(
                    "dados_nome" => "Nome completo | Full name",
                    "dados_nome_prof" => "Nome Profissional | Professional Name",
                    "dados_ciencia_id" => "Ciência ID",
                    "dados_orcid" => "ORCID",
                    "dados_email" => "Endereço de email | Email address",
                    "dados_telefone" => "Contacto telefónico | Cellphone number",
                    "dados_grau_academico" => "Grau Académico | Academic Qualifications",
                    "dados_ano_conclusao_academico" => "Ano de conclusão do grau académico | Year of conclusion of the academic qualifications",
                    "dados_area_academico" => "Área de especialização do Grau Académico | Field of expertise of the academic qualifications",
                    "dados_area_investigacao" => "Principais áreas de Investigação | Main research areas",
                    "dados_instituicao_vinculo" => "Instituição de vínculo (data de início e fim, se aplicável [dd/mm/aaaa]) | Institucional affiliation (start date and end date, if applicable [dd/mm/yyyy)]",
                    "dados_percentagem_dedicacao" => "Percentagem de dedicação ao TECHN&ART | Percentage of dedication to TECHN&ART",
                );
                foreach ($dados as $id => $nome) {
                    $placeholder = "Introduza a sua resposta";
                    $type = "text";
                    if ($id == "dados_email") $type = "email";
                    echo "<div class='form-group'>
                    <label>$nome</label>
                    <input type='$type' id='$id' placeholder='$placeholder' name='$id' minlength='1' required maxlength='255' required class='form-control' data-error='Por favor introduza um valor válido'>
                    <!-- Error -->
                    <div class='help-block with-errors'></div>
                    </div>";
                }

                /*                    "dados_pertencer_outro"=>"Pertence a outro centro de investigação e desenvolvimento? | Are you a member of another research and development centre?",
                    "dados_outro_texto"=>"outro_texto",
                    "dados_biografia"=>"biografia",*/
                ?>
                <div class='form-group'>
                    <label>Pertence a outro centro de investigação e desenvolvimento? | Are you a member of another research and development centre?</label>
                    <div class="form-check">
                        <input required value="true" class="form-check-input" type="radio" name="dados_pertencer_outro" id="dados_pertencer_outro1">
                        <label class="form-check-label" for="dados_pertencer_outro1">
                            Sim | Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input required value="false" class="form-check-input" type="radio" name="dados_pertencer_outro" id="dados_pertencer_outro2">
                        <label class="form-check-label" for="dados_pertencer_outro2">
                            Não | No
                        </label>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class='form-group'>
                    <label>Se SIM, qual, em que categoria e qual a percentagem de dedicação? | If YES, which centre, in which category and with what percentage of dedication?</label>
                    <input type='text' id='dados_outro_texto' placeholder="Introduza a sua resposta" name='dados_outro_texto' minlength='1' class='form-control' data-error='Por favor introduza um valor válido'>
                    <!-- Error -->
                    <div class='help-block with-errors'></div>
                </div>

                <div class='form-group'>
                    <label>Curta biografia de investigador/a (1-2 parágrafos) em português e inglês | Short researcher biography (1-2 paragraphs) in English</label>
                    <textarea id='dados_biografia' placeholder='Introduza a sua resposta' name='dados_biografia' required class='form-control' data-error='Por favor introduza um valor válido'></textarea>
                    <!-- Error -->
                    <div class='help-block with-errors'></div>
                </div>

                <div class="form-group">
                    <label>Carta de Motivação || Motivation Letter</label>
                    <input type="file" id="motivacao" name="motivacao" required data-error="Por favor adicione uma Carta de Motivação" class="form-control">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label>Carta de Recomendação do/a investigador/a do TECHN&ART proponente || Recommendation Letter of the proponent TECHN&ART researcher</label>
                    <input type="file" id="recomendacao" name="recomendacao" required data-error="Por favor adicione uma Carta de Recomendação" class="form-control">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label>Curriculum Vitae</label>
                    <input type="file" id="cv" name="cv" required data-error="Por favor adicione um Curriculum Vitae" class="form-control">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label>Fotografia do/a investigador/a || Researcher Photo</label>
                    <input type="file" id="fotografia" name="fotografia" required data-error="Por favor adicione uma fotografia" class="form-control">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block mb-3">Submeter</button>
                    <button type="button" onclick="window.location.href = 'index.php'" class="btn btn-danger btn-block">Cancelar</button>
                </div>

            </form>
        </div>
    </div>
</div>