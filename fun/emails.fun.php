<?php
require_once __PATH_MAILER__."class.phpmailer.php";
require_once __PATH_MAILER__."class.smtp.php";

define("MAIL_CODIFICAR", true);

define("PHPMAILER", true);

define("MAILER_HOST", "mail.lacanciondelpais.com.ar");
define("MAILER_USER", SITIO_EMAIL_NR);
define("MAILER_PASS", "p-M4z&QsdZP2");
define("MAILER_PORT", 25);
define("MAILER_AUTH", true);

define("MAILER_FROM_NAME", SITIO_NOMBRE." | Web");
define("MAILER_FROM_EMAIL", SITIO_EMAIL_NR);

define("MAILER_CLEAN", false);
define("MAILER_CLEAN_HOST", "{localhost:143/novalidate-cert}INBOX");

function mailPlano($dNombre, $dEmail, $asunto, $mensaje, $rNombre=NULL, $rEmail=NULL) {
	
	if (PHPMAILER)
		return mailMailer($dNombre, $dEmail, $asunto, $mensaje, $rNombre, $rEmail, false);
	else {	
		$to=($dNombre ? codificar($dNombre)." <$dEmail>" : $dEmail);
		$header="From: ".($rNombre ? codificar($rNombre)." <$rEmail>" : $rEmail)."\r\nContet-type: text/plain; charset=iso-8859-1\r\n";
		return @mail($to, codificar($asunto), $mensaje, $header);
	}
}
function mailHTML($dNombre, $dEmail, $asunto, $mensaje, $rNombre=NULL, $rEmail=NULL) {
	if (PHPMAILER)
		return mailMailer($dNombre, $dEmail, $asunto, $mensaje, $rNombre, $rEmail, true);
	else {
		$to=($dNombre ? codificar($dNombre)." <$dEmail>" : $dEmail);
		$header="From: ".($rNombre ? codificar($rNombre)." <$rEmail>" : $rEmail)."\r\nContent-type: text/html; charset=iso-8859-1\r\n";
		$mensaje="<!DOCTYPE html>\n<html>\n<head>\n<title></title>\n</head>\n<body>\n".$mensaje."\n</body>\n</html>\n";
		return @mail($to, codificar($asunto), $mensaje, $header);
	}
}
function mailHTML2($dNombre, $dEmail, $asunto, $mensaje, $rNombre=NULL, $rEmail=NULL) {
	if (PHPMAILER)
		return mailMailer($dNombre, $dEmail, $asunto, $mensaje, $rNombre, $rEmail, true);
	else {
		$to=($dNombre ? codificar($dNombre)." <$dEmail>" : $dEmail);
		$header="From: ".($rNombre ? codificar($rNombre)." <$rEmail>" : $rEmail)."\r\nContent-type: text/html; charset=iso-8859-1\r\n";
		$mensaje=$mensaje;
		return @mail($to, codificar($asunto), $mensaje, $header);
	}
}
function mailMailer($dNombre, $dEmail, $asunto, $mensaje, $rNombre=NULL, $rEmail=NULL, $html=true) {
	$mail=new PHPMailer();
	
	$mail->IsSMTP();
	
	$mail->Host=MAILER_HOST;
	$mail->SMTPAuth=MAILER_AUTH;
	$mail->Port=MAILER_PORT; 
	$mail->Username=MAILER_USER;
	$mail->Password=MAILER_PASS;
	
	$mail->SMTPDebug=1;
	
	if ($rEmail!=NULL && $rEmail!=MAILER_FROM_EMAIL)
		$mail->AddReplyTo($rEmail, $rNombre);
	
	$mail->SetFrom(MAILER_FROM_EMAIL, ($rNombre ? $rNombre : MAILER_FROM_NAME));
		
	$mail->AddAddress($dEmail, $dNombre);
	
	$mail->Subject=$asunto;
	
	if ($html) {
		$mail->MsgHTML($mensaje);
	}
	else {
		$mail->Body=$mensaje;
	}
	if (!$mail->send()) {
		echo "Mailer Error: ".$mail->ErrorInfo;
		$r=false;
	}
	else
		$r=true;
	
	if (MAILER_CLEAN)
		mailClean();	
	
	return $r;
}
function codificar($txt) {
	return (MAIL_CODIFICAR ? "=?iso-8859-1?B?".base64_encode(html_entity_decode($txt))."?=" : $txt);
}
function mailClean() {
	$inbox=imap_open(MAILER_CLEAN_HOST, MAILER_USER, MAILER_PASS, CL_EXPUNGE) or die("No se puede conectar al mailer: ".imap_last_error());
	if ($inbox) {
		if ($emails=imap_search($inbox, "ALL")) {
			foreach ($emails as $email) {
				imap_delete($inbox, $email);
			}
		}
		imap_close($inbox);
	}
}
?>
