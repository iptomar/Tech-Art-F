<?php
    require "verifica.php"; 
    require "basedados.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
     
       
        if ($_FILES["fotografia"]["size"]!=0) {
            $target_file=$_FILES["fotografia"]["name"];
            move_uploaded_file($_FILES["fotografia"]["tmp_name"], $target_file);
            $sql = "update investigadores set ".
                "nome = ?, email = ?, ciencia_id = ?, ". 
                "sobre = ?, tipo = ?, fotografia = ?, areasdeinteresse = ?, orcid = ?, scholar = ? ". 
                "where  id  = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'sssssssssi', $nome, $email, $ciencia_id, $sobre, $tipo, $fotografia, $areasdeinteresse, $orcid, $scholar, $id);
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $ciencia_id = $_POST["ciencia_id"];
            $sobre = $_POST["sobre"];
            $tipo = $_POST["tipo"];
            $fotografia = $target_file;
            $id = $_POST["id"];
            $areasdeinteresse = $_POST["areasdeinteresse"];
            $orcid = $_POST["orcid"];
            $scholar = $_POST["scholar"];
        } else {
            $sql = "update investigadores set ".
            "nome = ?, email = ?, ciencia_id = ?, ". 
            "sobre = ?, tipo = ?, areasdeinteresse = ?, orcid = ?, scholar = ? " . 
            "where  id  = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'ssssssssi', $nome, $email, $ciencia_id, $sobre, $tipo, $areasdeinteresse, $orcid, $scholar, $id);
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $ciencia_id = $_POST["ciencia_id"];
            $sobre = $_POST["sobre"];
            $tipo = $_POST["tipo"];
            $id = $_POST["id"];
            $areasdeinteresse = $_POST["areasdeinteresse"];
            $orcid = $_POST["orcid"];
            $scholar = $_POST["scholar"];
        }
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php');
            exit;
        } else {
            echo "Error: " . $sql . mysqli_error($conn);
        }
    }   else {
        
            $sql = "select nome, email, ciencia_id, sobre, tipo, fotografia, areasdeinteresse, orcid, scholar from investigadores ". 
                "where id = ?";
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
    } 



?>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"></link>
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
            <h5 class="card-header text-center">Editar Investigador</h5>
            <div class="card-body">
                <form role="form" data-toggle="validator" action="edit.php" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="id" value=<?php echo $id; ?>>
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" data-error="You must have a name." id="inputName"  value=<?php echo $nome; ?>>
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" value=<?php echo $email; ?>>
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>CiênciaVitae ID</label>
                        <input type="text" class="form-control" id="inputCienciaid" name="ciencia_id" value=<?php echo $ciencia_id; ?>>
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Sobre</label>
                        <input type="text" class="form-control" id="inputSobre" name="sobre" value="<?php echo $sobre; ?>">
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Tipo</label><br>
                        <select name="tipo">
                            <option value="">--Select--</option>
                            <option value="Colaborador" <?php echo  $tipo=="Colaborador"?"selected":"" ?>>Colaborador</option>
                            <option value="Integrado" <?php echo  $tipo=="Integrado"?"selected":"" ?>>Integrado</option>
                            <option value="Aluno" <?php echo  $tipo=="Aluno"?"selected":"" ?>>Aluno</option>
                        </select>
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Áreas de interesse</label>
                        <input type="text" class="form-control" id="inputAreasdeInteresse" name="areasdeinteresse" value="<?php echo $areasdeinteresse; ?>">
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Orcid</label>
                        <input type="text" class="form-control" id="inputOrcid" name="orcid" value=<?php echo $orcid; ?>>
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Scholar</label>
                        <input type="text" class="form-control" id="inputScholar" name="scholar" value=<?php echo $scholar; ?>>
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Fotografia</label>
                        <input type="file" class="form-control" id="inputFotografia" name="fotografia" value=<?php echo $fotografia; ?>>
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <img src="<?php echo $fotografia; ?>" width='100px' height='100px' /><br><br>


                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Gravar</button>
                    </div>

                    <div class="form-group">
                        <button type="submit" onclick="window.location.href = 'index.php'" class="btn btn-danger btn-block">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    mysqli_close($conn);
?>