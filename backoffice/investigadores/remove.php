<?php
require "../verifica.php";
require "../config/basedados.php";

if ($_SESSION["autenticado"] != 'administrador') {
    // Utilizador não tem permissão para eliminar investigadores Redireciona para a página de login 
    echo "<script> window.location.href = './index.php'; </script>";
    exit;
}
$filesDir = "../assets/investigadores/";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    $sql = "DELETE FROM investigadores_projetos WHERE investigadores_id = " . $id;
    mysqli_query($conn, $sql);
    $sql = "delete from investigadores where id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (mysqli_stmt_execute($stmt)) {
        // Criar um comnado para eliminar registos da tabela publicacoes que não têm entrada correspondente em publicacoes_investigadores
        $deleteQuery = "DELETE FROM publicacoes WHERE idPublicacao NOT IN (SELECT publicacao FROM publicacoes_investigadores)";
        $deleteResult = mysqli_query($conn, $deleteQuery);
        if (!$deleteResult) {
            echo "Erro ao eliminar registos da tabela publicacoes: " . mysqli_error($conn) . "<br>";
        } else {
            echo "<script> window.location.href = './index.php'; </script>";
        }
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    $sql = "SELECT nome, email, ciencia_id, sobre, tipo, fotografia, areasdeinteresse, orcid, scholar, research_gate, scopus_id, sobre_en, areasdeinteresse_en from investigadores WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $id = $_GET["id"];
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $nome = $row["nome"];
    $email = $row["email"];
    $ciencia_id = $row["ciencia_id"];
    $sobre = $row["sobre"];
    $tipo = $row["tipo"];
    $fotografia = $row["fotografia"];
    $areasdeinteresse = $row["areasdeinteresse"];
    $orcid = $row["orcid"];
    $scholar = $row["scholar"];
    $research_gate = $row["research_gate"];
    $scopus_id = $row["scopus_id"];
    $sobre_en = $row["sobre_en"];
    $areasdeinteresse_en = $row["areasdeinteresse_en"];
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

    .halfCol {
        max-width: 50%;
        display: inline-block;
        vertical-align: top;
        height: fit-content;
    }
</style>

<div class="container-xl mt-5">
    <div class="card">
        <h5 class="card-header text-center">Remover Investigador</h5>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="remove.php" method="post" enctype="multipart/form-data">

                <input type="hidden" name="id" value=<?php echo $id; ?>>
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" readonly name="nome" class="form-control" id="inputName" value="<?php echo $nome; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group removeExterno">
                    <label>Email</label>
                    <input type="email" readonly class="form-control" id="inputEmail" name="email" value="<?php echo $email; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="row">
                    <div class="col halfCol removeExterno">
                        <div class="form-group">
                            <label>Sobre</label>
                            <textarea type="text" readonly class="form-control" id="inputSobre" name="sobre"><?php echo $sobre; ?></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col halfCol removeExterno">
                        <div class="form-group">
                            <label>Sobre (Inglês)</label>
                            <textarea type="text" readonly class="form-control" id="inputSobreEn" name="sobre_en"><?php echo $sobre_en; ?></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col removeExterno">
                        <div class="form-group">
                            <label>Áreas de interesse</label>
                            <textarea type="text" readonly class="form-control" id="inputAreasdeInteresse" name="areasdeinteresse"><?php echo $areasdeinteresse; ?></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col removeExterno">
                        <div class="form-group">
                            <label>Áreas de interesse (Inglês)</label>
                            <textarea type="text" readonly class="form-control" id="inputAreasdeInteresseEn" name="areasdeinteresse_en"><?php echo $areasdeinteresse_en; ?></textarea>
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tipo</label><br>
                    <input type="text" class="form-control" id="inputTipo" name="tipo" readonly value="<?php echo $tipo; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group removeExterno">
                    <label>CiênciaVitae ID</label>
                    <input type="text" readonly class="form-control" id="inputCienciaid" name="ciencia_id" value="<?php echo $ciencia_id; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group removeExterno">
                    <label>Orcid</label>
                    <input type="text" readonly class="form-control" id="inputOrcid" name="orcid" value="<?php echo $orcid; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group removeExterno">
                    <label>Scholar</label>
                    <input type="text" readonly class="form-control" id="inputScholar" name="scholar" value="<?php echo $scholar; ?>">
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group removeExterno">
                    <label for="research_gate">ResearchGate: </label>
                    <input type="text" readonly class="form-control" name="research_gate" id="research_gate" value="<?= $research_gate ?>">
                </div>
                <div class="form-group removeExterno">
                    <label for="research_gate">ScopusID: </label>
                    <input type="text" readonly class="form-control" name="scopus_id" id="scopus_id" value="<?= $scopus_id ?>">
                </div>

                <input type="hidden" name="fotografia" value=<?php echo $fotografia; ?>>
                <img id="preview" src="<?php echo "../assets/investigadores/" . $fotografia; ?>" width='100px' height='100px' class="mb-2 mt-3" /><br>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Confirmar</button>
                </div>

                <div class="form-group">
                    <button type="button" onclick="window.location.href = 'index.php'" class="btn btn-danger btn-block">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Função para verificar e ocultar elementos com base na opção selecionada
    function checkType() {
        var selectedOption = document.getElementById("inputTipo").value; // Obter a opção selecionada
        var elementsToHide = document.querySelectorAll('.removeExterno');

        if (selectedOption === 'Externo') {
            // Se a opção for 'Externo', ocultar os elementos
            elementsToHide.forEach(function(element) {
                element.style.display = 'none'; 
            });
        }
    }

    // Adicionar um Event Listener para o carregamento do documento
    document.addEventListener("DOMContentLoaded", function() {
        checkType(); 
    });
</script>

<?php
mysqli_close($conn);
?>