<?php 

// Inicia sessões 
session_start(); 
// Verifica se existe os dados da sessão de login 
if(!isset($_SESSION["autenticado"])) { 
// Usuário não logado! Redireciona para a página de login 
header("Location: login.php"); 
exit; 
} 

require "basedados.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "update investigadores set password=?, ultimologin=now() where id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'si', $password, $id);
        $id = $_POST["id"];
        $password = md5($_POST["password"]);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: sair.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
}
?>


<HTML>

<BODY>
    <form action="resetpassword.php" method="post">
    <input type="hidden" name="id" value="<?php echo $_SESSION["autenticado"]; ?>"><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Alterar">
        <input type="button" value="Sair" onclick="window.location.href = 'sair.php'">
    </form>
</BODY>

</HTML>