<?php
$user_name = trim($_POST["user_name"]);
$user_email = trim($_POST["user_email"]);


$attch = $_SERVER["DOCUMENT_ROOT"] . '/shop/upload/price.pdf';

$text2=('Предложение для юридический лиц от vitaminbox.by');
$text3=('Это наше предложение для юридический лиц');
$body=file_get_contents('mail.html');
$body = str_replace("varname", $user_name, $body);
$convertedText = mb_convert_encoding($text, 'utf-8', mb_detect_encoding($text)); 
$convertedText2 = mb_convert_encoding($text2, 'utf-8', mb_detect_encoding($text2));
$convertedText3 = mb_convert_encoding($body, 'utf-8', mb_detect_encoding($body));
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
$mail->CharSet = "utf-8";

try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'zakaz.vitaminbox@gmail.com';                 // SMTP username
    $mail->Password = 'HZxl6go5';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to


    //Recipients
    $mail->setFrom('zakaz.vitaminbox@gmail.com', 'vitaminbox');
    $mail->addAddress($user_email);     // Add a recipient


    //Attachments
    $mail->addAttachment($attch);         // Add attachments


    //Content

    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject= $convertedText2;
    $mail->Body= $convertedText3;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}