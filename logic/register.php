<?php
require_once '../vendor/autoload.php';

use App\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "ONLY POST";
    exit;
}

if (
    empty($_POST['name']) or
    empty($_POST['email']) or
    empty($_POST['password'])
) {
    echo "all filed is required!";
    exit;
}
$user = (new User())->whereEmail($_POST['email']);
if (!is_null($user)) {
    echo "Email bar basqa email jaz";
    exit;
}

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'iuteniazov@gmail.com';                     //SMTP username
    $mail->Password   = 'qycelebajxkleiob';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('iuteniazov@gmail.com', 'todo-app');
    $mail->addAddress($_POST['email'], $_POST['name']);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Message from todo-app';
    $mail->Body    = $_POST['name'] . ' <b>Successful registered!</b>';
    $mail->AltBody = $_POST['name'] . ' Successful registered!';

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
try {
    (new User())->create([
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => md5($_POST['password']),
    ]);
    $user = (new User())->whereEmail($_POST['email']);
    setcookie('is_login', true, time() + 604800, "/");
    setcookie('user_id', $user['id'], time() + 604800, "/");
    header('location: ../index.php');
} catch (\Exception $e) {
    echo  $e->getMessage();
    exit;
}
