<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/PHPMailer/PHPMailer.php';
require 'mailer/PHPMailer/SMTP.php';
require 'mailer/PHPMailer/Exception.php';

function sendAcknowledgementMail($to, $name) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'apexmlrit@gmail.com';       // Replace
        $mail->Password   = 'uzwp qajt tfah ftvo';        // Replace
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('apexmlrit@gmail.com', 'APEX MLRIT - Recruitment Team');
        $mail->addAddress($to, $name);
        $mail->isHTML(true);
        $mail->Subject = "Application Received!";
        $mail->Body    = "Hello $name,<br><br>Thank you for applying. We have received your application and will get back to you shortly.<br><br>Regards,<br>Team";

        $mail->send();
    } catch (Exception $e) {
        error_log("Mail error: " . $mail->ErrorInfo);
    }
}
?>
