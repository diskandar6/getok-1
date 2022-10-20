<?php
define('RUN_PHPMAILER',1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "src/PHPMailer.php";
include "src/SMTP.php";
include "src/Exception.php";

function send_mail($from,$replay,$recipient,$cc,$subject,$content,$mailer='smtp',$debug=0,$auth=TRUE,$secure="tls",$port=587,$host="smtp.gmail.com",$username="univ.aisyiyahbandung@gmail.com",$password="pdywephqjvpghgmz"){//,$port=465,$host="mail.unisa-bandung.ac.id",$username="support@unisa-bandung.ac.id",$password="Aisyiy@h2020"){//,$port=587,$host="stikes-aisyiyahbandung.ac.id",$username="support@stikes-aisyiyahbandung.ac.id",$password="Aisyiyah123"){

	$mail = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->Mailer = $mailer;
	$mail->SMTPDebug  = $debug;
	$mail->SMTPAuth   = $auth;
	$mail->SMTPSecure = $secure;
	$mail->Port       = $port;
	$mail->Host       = $host;
	$mail->Username   = $username;
	$mail->Password   = $password;
	$mail->IsHTML(true);
	foreach ($recipient as $key => $value)
		$mail->AddAddress($value['address'],$value['name']);
	$mail->SetFrom($from['address'],$from['name']);
	$mail->AddReplyTo($replay['address'],$replay['name']);
	foreach ($cc as $key => $value)
		$mail->AddCC($value['address'],$value['name']);
	$mail->Subject = $subject;
	$mail->MsgHTML($content);
	return $mail->Send();
}
?>