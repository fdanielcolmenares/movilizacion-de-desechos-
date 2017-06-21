<?php
require '../php/PHPMailerAutoload.php';
include("../php/class.phpmailer.php"); 
include("../php/class.smtp.php"); //../


	$mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = "ssl"; 
    $mail->Host = "smtp.gmail.com"; //smtp.live.com.
    $mail->Port = 465; 
    $mail->Username = "fdaniel.colmenares@gmail.com"; 
    $mail->Password = "123456789";
    $mail->From = "souldarck@gmail.com"; 
	$mail->FromName = "Nombre"; 
	$mail->Subject = "Asunto del Email"; 
	$mail->AltBody = "Este es un mensaje de prueba."; 
	$mail->MsgHTML("<b>Este es un mensaje de prueba</b>."); 
    //$mail->AddAttachment("files/files.zip";  
	$mail->AddAddress("fdaniel.colmenares@gmail.com", "daniel"); 
	$mail->IsHTML(true); 
	if(!$mail->Send()) { 
		echo "Error: " . $mail->ErrorInfo; 
	} else { 
		echo "Mensaje enviado correctamente"; 
	}
?>