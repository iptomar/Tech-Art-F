<?php
    include 'config/dbconnection.php';
    $pdo = pdo_connect_mysql();
    $message = '';
    if (isset($_GET['email'], $_GET['token'])) {
        if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
            $message = 'Por favor insira um email válido!';
        } else {
            $stmt = $pdo->prepare('SELECT * FROM subscritores WHERE email = ?');
            $stmt->execute([$_GET['email']]);
            $subscriber = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($subscriber) {
                if ($subscriber['token_unsubscribe'] == $_GET['token']) {
                    $stmt = $pdo->prepare('DELETE FROM subscritores WHERE email = ?');
                    $stmt->execute([$_GET['email']]);
                    $message = 'A subscrição da nossa newsletter foi cancelada com sucesso.';
                } else {
                    $message = 'Código de cancelamento incorreto. Se tem dificuldades e pretende cancelar a sua subscrição, contacte-nos.';
                }
            } else {
                $message = 'Ou não é um subscritor, ou já cancelou a nossa newsletter.';
            }
        }
    } else {
        $message = 'Não foi especificado uma conta de email ou um código de cancelamento.';
    }
    session_start();
    $_SESSION['unsubscribe_message'] = $message;
    header('Location: index.php');
    exit();
?>
