<?php
require_once '../../vendor/autoload.php';
require "../config/basedados.php";
require "./templatePT.php";
require "./templateEn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

mb_internal_encoding('UTF-8');

$titulo = isset($_GET['titulo']) ? $_GET['titulo'] : '';
$assunto = isset($_GET['assunto']) ? $_GET['assunto'] : '';
$tituloEn = isset($_GET['tituloEn']) ? $_GET['tituloEn'] : '';
$assuntoEn = isset($_GET['assuntoEn']) ? $_GET['assuntoEn'] : '';
$noticias = isset($_GET['noticias']) ? $_GET['noticias'] : '';
//Selecionar os dados das noticias da base de dados
$subsPT = "SELECT id, email, lang, token_unsubscribe FROM subscritores WHERE lang = 'pt'";
$subsEN = "SELECT id, email, lang, token_unsubscribe FROM subscritores WHERE lang = 'eng'";

$resultsPT = mysqli_query($conn, $subsPT);
$resultsEN = mysqli_query($conn, $subsEN);

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
//Configure an SMTP
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'teamfgestaodeprojetos@gmail.com';
$mail->Password = 'rjdd hfty xmon pgzu';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

// Sender information
$mail->setFrom('teamfgestaodeprojetos@gmail.com', 'Team F');
$mail->isHTML(true);

// Send emails to Portuguese subscribers
if (mysqli_num_rows($resultsPT) > 0) {
  while ($rowPT = mysqli_fetch_assoc($resultsPT)) {
    try {
      $mail->addBCC($rowPT['email'], $rowPT['id']);
      $mail->Subject = $assunto; // Usar o assunto em português
      $tokenUnsubscribe = "http://localhost/Tech-Art-F/tecnart/cancelar_subscricao.php?email=" . $rowPT['email'] . "&token=" . $rowPT['token_unsubscribe'];
      ob_start(); // Inicia o buffer de saída
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
      </div>
              "; ?>
      </div>
      <?php
      $bodyContent = ob_get_clean();
      $mail->Body = $bodyContent;
      // Attempt to send the email
      if (!$mail->send()) {
        echo 'Email not sent to ' . $rowPT['email'] . '. An error was encountered: ' . $mail->ErrorInfo . "\n";
      } else {
        echo 'Message has been sent to ' . $rowPT['email'] . ".\n";
      }
    } catch (Exception $e) {
      echo "Message could not be sent to " . $rowPT['email'] . ". Mailer Error: {$mail->ErrorInfo}\n";
    }
  }
}

$mail->clearAllRecipients(); // Clear addresses for the next iteration
$mail->clearBCCs();

// Send emails to English subscribers
if (mysqli_num_rows($resultsEN) > 0) {
  while ($rowEN = mysqli_fetch_assoc($resultsEN)) {
    try {
      $mail->addBCC($rowEN['email'], $rowEN['id']);
      $mail->Subject = $assuntoEn; // Usar o assunto em inglês
      $tokenUnsubscribe = "http://localhost/Tech-Art-F/tecnart/cancelar_subscricao.php?email=" . $rowPT['email'] . "&token=" . $rowPT['token_unsubscribe'];
      ob_start(); // Inicia o buffer de saída
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
</div>"; ?>
      </div>
<?php
      $bodyContent = ob_get_clean();
      $mail->Body = $bodyContent;
      // Attempt to send the email
      if (!$mail->send()) {
        echo 'Email not sent to ' . $rowEN['email'] . '. An error was encountered: ' . $mail->ErrorInfo . "\n";
      } else {
        echo 'Message has been sent to ' . $rowEN['email'] . ".\n";
      }
    } catch (Exception $e) {
      echo "Message could not be sent to " . $rowEN['email'] . ". Mailer Error: {$mail->ErrorInfo}\n";
    }
  }
}
$mail->clearAddresses(); // clear addresses for the next iteration
$mail->smtpClose();

?>