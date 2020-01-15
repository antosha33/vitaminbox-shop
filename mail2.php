<?php
$user_name = trim($_POST["user_name"]);
$user_email = trim($_POST["user_email"]);
$user_phone = trim($_POST["user_phone"]);

$text2=('Заявка на прайс для Юрлиц');
$convertedText2 = mb_convert_encoding($text2, 'utf-8', mb_detect_encoding($text2));


$message = " <tr style='background-color: #f8f8f8;'>  
				<td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$user_name</b></td>
				<td style='padding: 10px; border: #e9e9e9 1px solid;'>$user_email</td>
				<td style='padding: 10px; border: #e9e9e9 1px solid;'>$user_phone</td>
			</tr>
			";

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
    $mail->addAddress('zakaz.vitaminbox@gmail.com');     // Add a recipient

    //Content

    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject= $convertedText2;
    $mail->Body= $message ;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}