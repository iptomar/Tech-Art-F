<?php
require "../verifica.php";
require "../config/basedados.php";

$mainDir = "../assets/projetos/"; // Ver isto no futuro, caminho para as imagens por default
$titulo = "Missão e Objetivos";
$dadosAreas;

// Criação do pedido a API
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $texto = $_POST["texto"];

    // Query de update
    $sql = "UPDATE projetos SET nome = ?, descricao = ?, sobreprojeto = ?, referencia = ?, areapreferencial = ?, financiamento = ?, ambito = ?, site = ?, facebook = ?, nome_en = ?, descricao_en = ?, sobreprojeto_en = ?, referencia_en = ?, areapreferencial_en = ?, financiamento_en = ?, ambito_en = ?, site_en = ?, facebook_en = ? ";
    $params = [$nome, $descricao, $sobreprojeto, $referencia, $areapreferencial, $financiamento, $ambito, $site, $facebook, $nome_en, $descricao_en, $sobreprojeto_en, $referencia_en, $areapreferencial_en, $financiamento_en, $ambito_en, $site_en, $facebook_en];

    // Preparação da execução da query
    $stmt = mysqli_prepare($conn, $sql);
   
    //Execução da query
    if (mysqli_stmt_execute($stmt)) {
        if (count($investigadores) == 0) { // Se estiver tudo bem, apresentar uma msg de sucesso
            echo "Atualizado com sucesso! " . $titulo;
        }
    } else {
        echo "Error: " . $sql . mysqli_error($conn);
    }
} else { // Caso contrario é para popular os campos

    $sql = "select * from technart.areas_website";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Fetch all rows as objects
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $dadosAreas = $rows;
    // Extract the 'titulo' from each object and store them in a new array
    $listaAreasTitulos = array_map(function($o) { return $o['titulo']; }, $rows);
}
?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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

    .halfCol {
        max-width: 50%;
        display: inline-block;
        vertical-align: top;
        height: fit-content;
    }

    /* Style The Dropdown Button */
    .dropbtn {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #f1f1f1
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }
</style>

<div class="container-xl mt-5">
    <div class="card">
        <br>
        <h5 class="card-header text-center">Editar Texto</h5>
        <h2>Escolha a area a editar:</h2>
        <br>
        <select name="areasSite" id="areasSite">
            <?php
            foreach ($dadosAreas as $area) {
                echo '<option value="' . $area['id'] . '">' . $area['titulo'] . '</option>';
            }
            ?>
        </select>
        <div class="card-body">
            <form role="form" data-toggle="validator" action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                <textarea id="texto" name="texto" class="form-control ck_replace" minlength="1" required data-error="Por favor introduza um 'sobre projeto'" cols="30" rows="5"></textarea>
                <!-- Error -->
                <div class="help-block with-errors"></div>
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

    document.addEventListener("DOMContentLoaded", function() {
        // Event listener for dropdown change
        document.getElementById('areasSite').addEventListener('change', function() {
        var selectedId = this.value;
        var selectedArea = <?php echo json_encode($dadosAreas); ?>.find(function(area) {
            return area.id == selectedId;
        });
        // document.getElementById('texto').value = selectedArea.texto;
        editor.setData(selectedArea.texto);
        });
    });
</script>

<?php
mysqli_close($conn);
?>
