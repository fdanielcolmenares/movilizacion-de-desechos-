<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PHPMailer - POP-before-SMTP test</title>
</head>
<body>
<?php
require '../PHPMailerAutoload.php';

//Authenticate via POP3
//Now you should be clear to submit messages over SMTP for a while
//Only applies if your host supports POP-before-SMTP 110
$pop = POP3::popBeforeSmtp('pop.gmail.com', 995, 30, 'pruebaCaimta@gmail.com', 'caimta123456789', 1);

//Create a new PHPMailer instance
//Passing true to the constructor enables the use of exceptions for error handling
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 2;
    //Ask for HTML-friendly debug output
    //$mail->Debugoutput = 'html';
    $mail->SMTPSecure = "ssl"; 
    //Set the hostname of the mail server
    $mail->Host = "smtp.gmail.com";
    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 465;
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    $mail->Username = "pruebaCaimta@gmail.com"; 
    $mail->Password = "caimta123456789";
    //Set who the message is to be sent from
    $mail->setFrom('pruebaCaimta@gmail.com', 'Caimta prueba');
    //Set an alternative reply-to address
    $mail->addReplyTo('pruebaCaimta@gmail.com', 'Caimta prueba');
    //Set who the message is to be sent to
    $mail->addAddress('pruebaCaimta@gmail.com', 'Alguien prueba');
    //Set the subject line
    $mail->Subject = 'probando';
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //and convert the HTML into a basic plain-text alternative body
    $mail->msgHTML("probando");//file_get_contents('contents.html'), dirname(__FILE__)
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'This is a plain-text message body';
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.gif');
    //send the message
    //Note that we don't need check the response from this because it will throw an exception if it has trouble
    $mail->send();
    echo "Message sent!";
} catch (phpmailerException $e) {
    echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    echo $e->getMessage(); //Boring error messages from anything else!
}
?>
</body>
</html>
