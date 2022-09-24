<?php
    require "verifica.php"; 
    require "basedados.php";
    require "bloqueador.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $sql= "DELETE FROM investigadores_projetos WHERE projetos_id = ".$id;
        mysqli_query($conn,$sql);
        $sql = "delete from projetos where id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        $sql = "select nome, descricao, sobreprojeto, referencia, areapreferencial, financiamento, ambito, fotografia from projetos ". 
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
            <h5 class="card-header text-center">Remover Projeto</h5>
            <div class="card-body">
                <form role="form" data-toggle="validator" action="remove.php?id=<?php echo $id; ?>" method="post">

                    <input type="hidden" name="id" value=<?php echo $id; ?>>
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" data-error="Tu deves ter um nome." id="inputName"  readonly value="<?php echo $nome; ?>">
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" class="form-control" id="inputDescricao" name="descricao" readonly value="<?php echo $descricao; ?>">
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Sobre Projeto</label>
                        <input type="text" class="form-control" id="inputSobreProjeto" name="sobreprojeto" readonly value="<?php echo $sobreprojeto; ?>">
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Referência</label>
                        <input type="text" class="form-control" id="inputReferencia" name="referencia" readonly value="<?php echo $referencia; ?>">
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Techn&Art área preferencial</label>
                        <input type="text" class="form-control" id="inputAreaPreferencial" name="areapreferencial" readonly value="<?php echo $areapreferencial; ?>">
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Financiamento</label>
                        <input type="text" class="form-control" id="inputFinanciamento" name="financiamento" readonly value="<?php echo $financiamento; ?>">
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Âmbito</label>
                        <input type="text" class="form-control" id="inputAmbito" name="ambito" readonly value="<?php echo $ambito; ?>">
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group">
                        <label>Fotografia</label>
                        <input type="text" class="form-control" id="inputFotografia" name="fotografia" readonly value="<?php echo $fotografia; ?>">
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>

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
<?php
    mysqli_close($conn);
?>