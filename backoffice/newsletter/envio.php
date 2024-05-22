<?php
require_once '../../vendor/autoload.php';
require "../config/basedados.php";
require "./templatePT.php";
require "./templateEn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

mb_internal_encoding('UTF-8');

// Obtém os parâmetros da URL
$titulo = isset($_GET['titulo']) ? $_GET['titulo'] : '';
$assunto = isset($_GET['assunto']) ? $_GET['assunto'] : '';
$tituloEn = isset($_GET['tituloEn']) ? $_GET['tituloEn'] : '';
$assuntoEn = isset($_GET['assuntoEn']) ? $_GET['assuntoEn'] : '';
$noticias = isset($_GET['noticias']) ? $_GET['noticias'] : '';

// Seleciona os subscritores de cada idioma
$subsPT = "SELECT id, email, lang, token_unsubscribe FROM subscritores WHERE lang = 'pt'";
$subsEN = "SELECT id, email, lang, token_unsubscribe FROM subscritores WHERE lang = 'eng'";

$resultsPT = mysqli_query($conn, $subsPT);
$resultsEN = mysqli_query($conn, $subsEN);

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
// Configura o SMTP
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'teamfgestaodeprojetos@gmail.com';
$mail->Password = 'rjdd hfty xmon pgzu';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

// Informação do remetente
$mail->setFrom('teamfgestaodeprojetos@gmail.com', 'Team F');
$mail->isHTML(true);

// Envia emails para subscritores em português
if (mysqli_num_rows($resultsPT) > 0) {
  while ($rowPT = mysqli_fetch_assoc($resultsPT)) {
    try {
      $mail->addBCC($rowPT['email'], $rowPT['id']);
      $mail->Subject = $assunto; // Usa o assunto em português
      $tokenUnsubscribe = "http://localhost/Tech-Art-F/tecnart/cancelar_subscricao.php?email=" . $rowPT['email'] . "&token=" . $rowPT['token_unsubscribe'];

      // Inicia o buffer de saída
      ob_start();
?>
      <div>
        <?php echo template_header_pt(); ?>
        <?php echo template_noticias_pt($titulo, $noticias); ?>
        <?php echo "
            <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #333f50; margin-top: 20px;'>
                <tr>
                    <td align='center' style='padding: 10px;'>
                        <a href='$tokenUnsubscribe' style='color: white; text-decoration: none; margin-right: 20px; font-weight: bold;'>Cancelar Subscrição</a>
                    </td>
                </tr>
            </table>
        "; ?>
      </div>
      <?php
      $bodyContent = ob_get_clean();
      $mail->Body = $bodyContent;

      // Tenta enviar o email
      if (!$mail->send()) {
        echo 'Email não enviado para ' . $rowPT['email'] . '. Erro encontrado: ' . $mail->ErrorInfo . "\n";
      } else {
        echo 'Mensagem enviada para ' . $rowPT['email'] . ".\n";
      }
    } catch (Exception $e) {
      echo "Mensagem não pode ser enviada para " . $rowPT['email'] . ". Erro do Mailer: {$mail->ErrorInfo}\n";
    }

    // Limpa destinatários e BCCs para a próxima iteração
    $mail->clearAddresses();
    $mail->clearBCCs();
  }
}

// Envia emails para subscritores em inglês
if (mysqli_num_rows($resultsEN) > 0) {
  while ($rowEN = mysqli_fetch_assoc($resultsEN)) {
    try {
      $mail->addBCC($rowEN['email'], $rowEN['id']);
      $mail->Subject = $assuntoEn; // Usa o assunto em inglês
      $tokenUnsubscribe = "http://localhost/Tech-Art-F/tecnart/cancelar_subscricao.php?email=" . $rowEN['email'] . "&token=" . $rowEN['token_unsubscribe'];

      // Inicia o buffer de saída
      ob_start();
      ?>
      <div>
        <?php echo template_header_en(); ?>
        <?php echo template_noticias_en($tituloEn, $noticias); ?>
        <?php echo "
            <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #333f50; margin-top: 20px;'>
                <tr>
                    <td align='center' style='padding: 10px;'>
                        <a href='$tokenUnsubscribe' style='color: white; text-decoration: none; margin-right: 20px; font-weight: bold;'>Unsubscribe</a>
                    </td>
                </tr>
            </table>
        "; ?>
      </div>
<?php
      $bodyContent = ob_get_clean();
      $mail->Body = $bodyContent;

      // Tenta enviar o email
      if (!$mail->send()) {
        echo 'Email não enviado para ' . $rowEN['email'] . '. Erro encontrado: ' . $mail->ErrorInfo . "\n";
      } else {
        echo 'Mensagem enviada para ' . $rowEN['email'] . ".\n";
      }
    } catch (Exception $e) {
      echo "Mensagem não pode ser enviada para " . $rowEN['email'] . ". Erro do Mailer: {$mail->ErrorInfo}\n";
    }

    // Limpa destinatários e BCCs para a próxima iteração
    $mail->clearAddresses();
    $mail->clearBCCs();
  }
}

$mail->smtpClose();
?>