<?php
// require './config.php';
require './libs/phpmail/Exception.php';
require './libs/phpmail/PHPMailer.php';
require './libs/phpmail/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$mailbody = "
as-set:         AS204844:AS-AUTO-FREE-TRANSIT
tech-c:         NA8104-RIPE
admin-c:        NA8104-RIPE
mnt-by:         NCSE-MAIL-MNT
mnt-by:         NCSE-TW-MNT
source:         RIPE
password:       $RIPE_PWD
";

$mongoClient = new MongoDB\Driver\Manager($mongo_link);
$collection = $databases_name . ".networks";
$filter = [];
$query = new MongoDB\Driver\Query($filter);
$ripe_asset_info = $mongoClient->executeQuery($collection, $query);
$ripe_asset_info = json_decode(json_encode($ripe_asset_info->toArray()), true);
foreach ($ripe_asset_info as $ripe) {
    if ($ripe['active'] != 'no') {
        $as_set = "members: " . splitSentence($ripe['as_set']) . "\n";
        $mailbody = $mailbody . $as_set;
    }
}

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->isSMTP();
$mail->Host       = $mail_smtp_server;
$mail->SMTPAuth   = true;
$mail->Username   = $mail_smtp_username;
$mail->Password   = $mail_smtp_password;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
$mail->setFrom($mail_from, $mail_display_name);
$mail->addAddress('auto-dbm@ripe.net');
$mail->addCC($mail_cc_address);
$mail->isHTML(false);
$mail->Subject = 'as-set update';
$mail->Body    = $mailbody;
$mail->send();


function splitSentence($input)
{
    $input = strtoupper($input);
    if (strpos($input, '::') !== false) {
        $parts = explode('::', $input);
        $parts = $parts[1];
        return $parts;
    } else {
        return $input;
    }
}
