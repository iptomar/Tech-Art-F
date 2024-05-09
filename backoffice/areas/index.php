<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

<?php
require "../verifica.php";
require "../config/basedados.php";
require "../assets/models/functions.php";

$mainDir = "../../tecnart/assets/images/"; // Ver isto no futuro, caminho para as imagens por default
$pdfDir = "../../tecnart/assets/regulamentos/"; // caminho para a localizacao do pdf 
$dadosAreas;
$texto;
$titulo;
$fotografia = "";
$pdfPath = "";


// Criação do pedido a API
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $texto = $_POST["texto"];
    $titulo = $_POST["titulo"];
    $field = ($_POST["lang"] === "en") ? "texto_en" : "texto";

    $sql = "";
    //verifica se o post foi feito para editar o link regulamento de forma a  preparar a query para um pdf 
    if ($titulo == "Link Regulamentos") {
        //Verifica se o pdf exite
        $pdf_exists = isset($_FILES["pdf"]) && $_FILES["pdf"]["size"] != 0;

        // se o pdf exite 
        if ($pdf_exists) {
            //le o nome do pdf 
            $pdfPath = $pdfDir . $_FILES["pdf"]["name"];
            //Se existir um pdf na pasta com o mesmo nome removeo 
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
            //grava o ficheiro na pasta 
            move_uploaded_file($_FILES["pdf"]["tmp_name"], $pdfPath);
            //prepara o caminho para ser lido na pagina inicial 
            $replace_this = "../../tecnart";
            $replace_for = ".";
            //faz a subestituicao no caminho atual do ficheiro
            $pdfPath = str_replace($replace_this, $replace_for, $pdfPath);
            //monta a string para a query que atualiza a base de dados com o caminho para o pdf  
            $sql = "UPDATE technart.areas_website SET texto = '" . $pdfPath . "'";
        }
        //se for os outros titulos prepara uma query para fotografia 
    } else {
        // Fetch as fotos localmente
        $fotografia_exists = isset($_FILES["fotografia"]) && $_FILES["fotografia"]["size"] != 0;


        // Query de update
        $sql = "UPDATE technart.areas_website SET " . $field ." = '" . $texto . "' ";

        // Check if the 'fotografia' file exists and update the SQL query and parameters accordingly
        if ($fotografia_exists) {
            $fotografia = uniqid() . '_' . $_FILES["fotografia"]["name"];
            ;
            $sql .= ",fotografia = '" . $fotografia . "'";
            $params[] = $fotografia;
            move_uploaded_file($_FILES["fotografia"]["tmp_name"], $mainDir . $fotografia);
        }

    }


    $sql .= " where titulo  = '" . $titulo . "';";

    // Preparação da execução da query
    $stmt = mysqli_prepare($conn, $sql);

    //Execução da query
    if (mysqli_stmt_execute($stmt)) {
        // Removido o comando header por estar a das comflito com o update . 
        //atualiza a pagina atual 
        echo "<script> window.location.href = './index.php'; </script>";
        exit();
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
}
?>

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

    @arrowColor: #ffcc00;
    @arrow: escape('@{arrowColor}');

    select {
        background-color: #58a8ff;
        background-image: url(~"data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20256%20448%22%20enable-background%3D%22new%200%200%20256%20448%22%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E.arrow%7Bfill%3A@{arrow}%3B%7D%3C%2Fstyle%3E%3Cpath%20class%3D%22arrow%22%20d%3D%22M255.9%20168c0-4.2-1.6-7.9-4.8-11.2-3.2-3.2-6.9-4.8-11.2-4.8H16c-4.2%200-7.9%201.6-11.2%204.8S0%20163.8%200%20168c0%204.4%201.6%208.2%204.8%2011.4l112%20112c3.1%203.1%206.8%204.6%2011.2%204.6%204.4%200%208.2-1.5%2011.4-4.6l112-112c3-3.2%204.5-7%204.5-11.4z%22%2F%3E%3C%2Fsvg%3E%0A");
        background-position: right 10px center;
        background-repeat: no-repeat;
        background-size: auto 50%;
        border-radius: 2px;
        border: none;
        color: #ffffff;
        padding: 10px 30px 10px 10px;

        // disable default appearance
        outline: none;
        -moz-appearance: none;
        -webkit-appearance: none;
        appearance: none;

        &::-ms-expand {
            display: none
        }

        ;
    }

    // remove dotted firefox border
    @-moz-document url-prefix() {
        select {
            color: rgba(0, 0, 0, 0);
            text-shadow: 0 0 0 #ffffff;
        }
    }

    // Codepen Layout
    @import url(https://fonts.googleapis.com/css?family=Lato:300,400);

    body {
        font-family: 'Lato', sans-serif;
        font-weight: 300;
        background: #34495E;

        select {
            margin: 50px auto 0;
            display: block;
        }
    }
</style>

<div class="container-xl mt-5">
    <div class="card">
        <br>
        <h5 class="card-header text-center" data-translation='areas-edit-text'>Editar Texto</h5>

        <div class="card-body">
            <h2 data-translation='areas-choose-to-edit'>Escolha a area a editar:</h2>
            <form role="form" data-toggle="validator" action="../areas/index.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="lang" id="lang" value="pt">
                <input type="hidden" name="titulo" id="titulo" value="">
                <br>
                <select name="areasSite" id="areasSite">
                    <option data-translation='areas-dropdown-select'>Selecionar</option>
                    <?php
                    foreach ($dadosAreas as $area) {
                        echo '<option value="' . $area['id'] . '">' . $area['titulo'] . '</option>';
                    }
                    ?>
                </select>
                <button id="button_en_pt" type="button" class="btn btn-primary">EN</button>
                <br>
                <br>
                <div id="divAreaTexto">
                    <textarea id="texto" name="texto" class="form-control ck_replace" minlength="1" required
                        data-error="Por favor introduza um texto" cols="30" rows="5"></textarea>
                </div>
                <br>
                <div id="guardaFicheiro" class="form-group">
                    <!--Caregado o tipo de input conforme for para uma fotografia ou pdf-->
                </div>
                <!-- Error -->
                <div class="help-block with-errors"></div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block"
                        data-translation='areas-button-save'>Gravar</button>
                </div>
                <div class="form-group">
                    <button type="button" onclick="window.location.href = 'index.php'" class="btn btn-danger btn-block"
                        data-translation='areas-button-cancel'>Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Criar o CKEditor 5-->
<script src="../ckeditor5/build/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        $('.ck_replace').each(function () {
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

    document.addEventListener("DOMContentLoaded", function () {

        var path;

        document.getElementById('areasSite').addEventListener('change', function () {
            var selectedId = this.value;
            var selectedArea = <?php echo json_encode($dadosAreas); ?>.find(function (area) {
                return area.id == selectedId;
            });

            if (selectedArea) {
                $titulo = selectedArea.titulo;
                document.getElementById('titulo').value = $titulo;
                editor.setData(selectedArea.texto);
                //se o titulo for o link regulamentos coloca no div guardaFicheiro o input para receber um pdf 
                if ($titulo == "Link Regulamentos") {
                    document.getElementById("guardaFicheiro").innerHTML = ' <label>PDF</label>  <input accept=".pdf" type="file" class="form-control" id="inputPDF" name="pdf"> <!-- Error --> <div class="help-block with-errors"></div>'
                    // para os outros titulos coloca no div guardaFicheiro  o input para receber uma imagem  e mostra uma previsualizacao desta 
                } else {
                    document.getElementById("guardaFicheiro").innerHTML = ' <label>Fotografia</label>  <input accept="image/*" type="file" onchange="previewImg(this)" class="form-control" id="inputFotografia" name="fotografia" value=<?php echo $fotografia; ?>> <!-- Error --> <div class="help-block with-errors"></div> <img id="preview" src="<?php echo $mainDir . $fotografia ?>" width="300px" height="300px"/>';
                }
            } else {
                console.log("Área selecionada não encontrada.");
            }
            var inputFotografia = document.getElementById('preview');
            var fotografiaSrc = "<?php echo $mainDir; ?>" + selectedArea.fotografia;
            inputFotografia.setAttribute('src', fotografiaSrc);
            function previewImg(input) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('preview').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }

            document.getElementById('inputFotografia').addEventListener('change', function () {
                previewImg(this);
            });

        });

        // Event listener for the "EN" button
        $('button[id="button_en_pt"]').click(function () {
            var selectedId = $('#areasSite').val();
            var selectedArea = <?php echo json_encode($dadosAreas); ?>.find(function (area) {
                return area.id == selectedId;
            });

            if (selectedArea) {
                var langInput = document.getElementById('lang');
                if (document.getElementById('button_en_pt').innerText == "EN") {
                    // Assuming "texto_en" is the column name for English text
                    var texto_en = selectedArea.texto_en;
                    // Set the fetched text to the CKEditor
                    editor.setData(texto_en);
                    document.getElementById('button_en_pt').innerText = "PT";
                    langInput.value = "en"; // Update language value
                } else {
                    // Assuming "texto_en" is the column name for English text
                    var texto_pt = selectedArea.texto;
                    // Set the fetched text to the CKEditor
                    editor.setData(texto_pt);
                    document.getElementById('button_en_pt').innerText = "EN";
                    langInput.value = "pt"; // Update language value
                }
                
            } else {
                console.log("Área selecionada não encontrada.");
            }
        });
    });

</script>

<?php
mysqli_close($conn);
?>