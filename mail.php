<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form fields and remove whitespace.
  $name = strip_tags(trim($_POST["name"]));
  $name = str_replace(array("\r","\n"),array(" "," "),$name);
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  // $cont_subject = trim($_POST["subject"]);
  $message = trim($_POST["message"]);
  if(is_null($_POST["message"]) ){
    $message = "Inscription Beta de ".$email;
  }
  if(is_null($_POST["name"]) ){
    $name = $email;
  }
}

try {
    // Server settings
    $mail->SMTPDebug = 0; // for detailed debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = 'vracapps.ch@gmail.com'; // YOUR gmail email
    $mail->Password = 'R4FA5bMecdhVHML6cZDiZZBuNarceunnjkTuhBRT4dYWwtWQ9Xz8jwL86Npt6635Y3'; // YOUR gmail password

    // Sender and recipient settings
    $mail->setFrom('vracapps.ch@gmail.com', $name);
    $mail->addAddress('dylan13f@gmail.com', 'Dylan');

    // Setting the email content
    $mail->IsHTML(true);
    $mail->Subject = "Vracapps.ch de ".$email;
    $mail->Body = $message;
    $mail->AltBody = 'Reçu de vracapps.ch';

    $mail->send();
    echo "E-mail envoyé avec succès !";
} catch (Exception $e) {
    echo "Erreur de l'e-mail. Mailer Error: {$mail->ErrorInfo}";
}
?>