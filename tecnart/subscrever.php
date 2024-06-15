<?php
    include 'config/dbconnection.php';
    $pdo = pdo_connect_mysql();

    // verifica se o email é válido
    if (isset($_POST['email'])) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            exit('Insira um email válido.');
        }

        // verifica se o email já existe na tabela subscritores
        $stmt = $pdo->prepare('SELECT * FROM subscritores WHERE email = ?');
        $stmt->execute([$_POST['email']]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            exit('Já subscreveu a nossa newsletter.');
        }

        // insere o registo na base de dados
        $stmt = $pdo->prepare('INSERT INTO subscritores (email,data_subscricao,lang,token_unsubscribe) VALUES (?,?,?,?)');
        $stmt->execute([$_POST['email'], date('Y-m-d\TH:i:s'), $_POST['idioma'], random_str(32)]);
        exit('Obrigado pela sua subscrição!');
    } else {
        exit('Insira um email válido.');
    }

     // função para gerar uma string aleatória que vai servir de token para cancelar a newsletter
    function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
?>