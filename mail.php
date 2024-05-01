<?php
require './config.php';
require './libs/phpmail/Exception.php';
require './libs/phpmail/PHPMailer.php';
require './libs/phpmail/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$mailbody = "
as-set:         AS204844:AS-TEST
tech-c:         NA8104-RIPE
admin-c:        NA8104-RIPE
mnt-by:         NCSE-MAIL-MNT
mnt-by:         NCSE-TW-MNT
members:        AS204844:AS-ALL
members:        AS202260
source:         RIPE
password:       NCSE_RIPE_EMAIL_UPDATER
";

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $mail_smtp_server;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $mail_smtp_username;                     //SMTP username
    $mail->Password   = $mail_smtp_password;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($mail_from, $mail_display_name);
    $mail->addAddress('auto-dbm@ripe.net');               //Name is optional
    $mail->addCC($mail_cc_address);

    //Content
    $mail->isHTML(false);                                  //Set email format to HTML
    $mail->Subject = 'as-set update';
    $mail->Body    = $mailbody;

    #$mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    #echo "Message could not be sent. Mailer Error:". $mail->ErrorInfo;
}