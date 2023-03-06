<?php
require "../verifica.php";
require "../config/basedados.php";
require "bloqueador.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_FILES["fotografia"]["size"] != 0) {
        $target_file = $_FILES["fotografia"]["name"];
        move_uploaded_file($_FILES["fotografia"]["tmp_name"], "../assets/projetos/" . $target_file);
        $sql = "update projetos set " .
            "nome = ?, descricao = ?, " .
            "sobreprojeto = ?, referencia = ?, areapreferencial = ?, financiamento = ?, ambito = ?, fotografia = ? " .
            "where  id  = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssssssi', $nome, $descricao, $sobreprojeto, $referencia, $areapreferencial, $financiamento, $ambito, $fotografia, $id);
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $sobreprojeto = $_POST["sobreprojeto"];
        $referencia = $_POST["referencia"];
        $fotografia = $target_file;
        $id = $_POST["id"];
        $areapreferencial = $_POST["areapreferencial"];
        $financiamento = $_POST["financiamento"];
        $ambito = $_POST["ambito"];
        $investigadores = [];
        if (isset($_POST["investigadores"])) {
            $investigadores = $_POST["investigadores"];
        }
    } else {
        $sql = "update projetos set " .
            "nome = ?, descricao = ?, " .
            "sobreprojeto = ?, referencia = ?, areapreferencial = ?, financiamento = ?, ambito = ? " .
            "where  id  = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssssi', $nome, $descricao, $sobreprojeto, $referencia, $areapreferencial, $financiamento, $ambito, $id);
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $sobreprojeto = $_POST["sobreprojeto"];
        $referencia = $_POST["referencia"];
        $id = $_POST["id"];
        $areapreferencial = $_POST["areapreferencial"];
        $financiamento = $_POST["financiamento"];
        $ambito = $_POST["ambito"];
        $investigadores = [];
        if (isset($_POST["investigadores"])) {
            $investigadores = $_POST["investigadores"];
        }
    }

    if (mysqli_stmt_execute($stmt)) {
        if (count($investigadores) == 0) {
            header('Location: index.php');
            return;
        }
        $sqlinsert = "";
        foreach ($investigadores as $investigadorid) {
            $sqlinsert = $sqlinsert . "($investigadorid,$id),";
        }
        $sqlinsert = rtrim($sqlinsert, ",");
        $sql = "DELETE FROM investigadores_projetos WHERE projetos_id = " . $id;
        mysqli_query($conn, $sql);
        $sql = "INSERT INTO investigadores_projetos (investigadores_id,projetos_id) values" . $sqlinsert;
        print_r($sql);
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        exit;
    } else {
        echo "Error: " . $sql . mysqli_error($conn);
    }
} else {

    $sql = "select nome, descricao, sobreprojeto, referencia, areapreferencial, financiamento, ambito, fotografia from projetos " .
        "where id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $id = $_GET["id"];

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $nome = $row["nome"];
    $descricao = $row["descricao"];
    $sobreprojeto = $row["sobreprojeto"];
    $referencia = $row["referencia"];
    $fotografia = $row["fotografia"];
    $areapreferencial = $row["areapreferencial"];
    $financiamento = $row["financiamento"];
    $ambito = $row["ambito"];
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

<div class="container-xl mt-5">
    <div class="card">
        <h5 class="card-header text-center">Editar Projeto</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

                <input type="hidden" name="id" value=<?php echo $id; ?>>
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" minlength="1" required maxlength="100" required data-error="Por favor introduza um nome válido" name="nome" class="form-control" id="inputName" value="<?php echo $nome; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Descrição</label>
                    <textarea class="form-control" minlength="1" required data-error="Por favor introduza uma descrição" id="inputDescricao" name="descricao"><?php echo $descricao; ?></textarea>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Sobre Projeto</label>
                    <textarea class="form-control" minlength="1" required data-error="Por favor introduza um 'sobre projeto'" cols="30" rows="5" id="inputSobreProjeto" name="sobreprojeto"><?php echo $sobreprojeto; ?></textarea>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Referência</label>
                    <input type="text" minlength="1" required maxlength="100" required data-error="Por favor introduza uma referÊncia válida" class="form-control" id="inputReferencia" name="referencia" value="<?php echo $referencia; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Techn&Art área preferencial</label>
                    <input type="text" minlength="1" required maxlength="255" required data-error="Por favor introduza uma área preferencial" class="form-control" id="inputAreaPreferencial" name="areapreferencial" value="<?php echo $areapreferencial; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Financiamento</label>
                    <input type="text" minlength="1" required maxlength="20" required data-error="Por favor introduza um financiamento válido" class="form-control" id="inputFinanciamento" name="financiamento" value="<?php echo $financiamento; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Âmbito</label>
                    <input type="text" minlength="1" required maxlength="100" required data-error="Por favor introduza um âmbito válido" class="form-control" id="inputAmbito" name="ambito" value="<?php echo $ambito; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Investigadores</label><br>

                    <?php
                    $sql = "SELECT investigadores_id FROM investigadores_projetos WHERE projetos_id = " . $id;
                    $result = mysqli_query($conn, $sql);
                    $selected = array();
                    if (mysqli_num_rows($result) > 0) {
                        while (($row =  mysqli_fetch_assoc($result))) {
                            $selected[] = $row['investigadores_id'];
                        }
                    }
                    $sql = "SELECT id, nome, email, sobre, tipo, fotografia, areasdeinteresse, orcid, scholar FROM investigadores";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row["id"] == $_SESSION["autenticado"]) {
                                echo "<input type='hidden' name='investigadores[]' value='" . $row["id"] . "'/>";
                            } ?>
                            <input type="checkbox" <?= in_array($row["id"], $selected) || $row["id"] == $_SESSION["autenticado"] ? "checked" : "" ?> <?= $row["id"] == $_SESSION["autenticado"] ? "disabled" : "" ?> name="investigadores[]" value="<?= $row["id"] ?>">
                            <label><?= $row["nome"] ?></label><br>
                    <?php }
                    } ?>

                    <!-- Error -->

                </div>

                <div class="form-group">
                    <label>Fotografia</label>
                    <input type="file" minlength="1" required maxlength="100" required data-error="Por favor introduza uma fotografia válida" class="form-control" id="inputFotografia" name="fotografia" value=<?php echo $fotografia; ?>>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <img src="<?php echo "../assets/projetos/" . $fotografia; ?>" width='100px' height='100px' /><br><br>

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
        .create(document.querySelector('#inputSobreProjeto'), {
            licenseKey: '',
        })
        .then(editor => {
            window.editor = editor;
        })
</script>


<?php
mysqli_close($conn);
?>