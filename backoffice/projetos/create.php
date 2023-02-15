<?php
require "../verifica.php";
require "../config/basedados.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_file = $_FILES["fotografia"]["name"];
    //transferir a imagem para a pasta de assets
    move_uploaded_file($_FILES["fotografia"]["tmp_name"], "../assets/projetos/" . $target_file);

    //adicionar novo projeto na base de dados
    $sql = "INSERT INTO projetos (nome, descricao, sobreprojeto, referencia, areapreferencial, financiamento, ambito, fotografia) " .
        "VALUES (?,?,?,?,?,?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssss', $nome, $descricao, $sobreprojeto, $referencia, $areapreferencial, $financiamento, $ambito, $fotografia);
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $sobreprojeto = $_POST["sobreprojeto"];
    $referencia = $_POST["referencia"];
    $fotografia = $target_file;
    $areapreferencial = $_POST["areapreferencial"];
    $financiamento = $_POST["financiamento"];
    $ambito = $_POST["ambito"];
    $investigadores = [];
    if (isset($_POST["investigadores"])) {
        $investigadores = $_POST["investigadores"];
    }
    if (mysqli_stmt_execute($stmt)) {
        if (count($investigadores) == 0) {
            header('Location: index.php');
            return;
        }
        $sqlinsert = "";
        foreach ($investigadores as $id) {
            $sqlinsert = $sqlinsert . "($id,last_insert_id()),";
        }
        $sqlinsert = rtrim($sqlinsert, ",");
        $sql = "INSERT INTO investigadores_projetos (investigadores_id,projetos_id) values" . $sqlinsert;
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
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
        <h5 class="card-header text-center">Criar Projeto</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="create.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" data-error="Tu deves ter um nome." id="inputName">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Descrição</label>
                    <textarea class="form-control" data-error="Por favor adiciona uma descrição." id="inputDescricao" name="descricao"></textarea>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Sobre Projeto</label>
                    <textarea class="form-control" cols="30" rows="5" data-error="Por favor adiciona um sobre projeto." id="inputSobreProjeto" name="sobreprojeto"></textarea>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Referência</label>
                    <input type="text" class="form-control" id="inputReferencia" name="referencia">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Techn&Art área preferencial</label>
                    <input type="text" class="form-control" id="inputAreaPreferencial" name="areapreferencial">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Financiamento</label>
                    <input type="text" class="form-control" id="inputFinanciamento" name="financiamento">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Âmbito</label>
                    <input type="text" class="form-control" id="inputAmbito" name="ambito">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Investigadores</label><br>

                    <?php
                    $sql = "SELECT id, nome, email, sobre, tipo, fotografia, areasdeinteresse, orcid, scholar FROM investigadores";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <input type="checkbox" name="investigadores[]" value="<?= $row["id"] ?>">
                            <label>
                                <?= $row["nome"] ?>
                            </label><br>
                    <?php }
                    } ?>

                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Fotografia</label>
                    <input type="file" class="form-control" id="inputFotografia" name="fotografia">
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