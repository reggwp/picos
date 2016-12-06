<?php
require 'PHPMailer/PHPMailerAutoload.php';

$data = json_decode(file_get_contents("php://input"));

if ($data->type === 'order') {
	$type1 = 'order';
	$type2 = 'ordering';
}
else {
	$type1 = 'reservation';
	$type2 = 'reserving';
}

$mail = new PHPMailer;

// $mail->SMTPDebug = 2;                               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mail.yahoo.com;smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'picosresto@gmail.com';                 // SMTP username
$mail->Password = 'picosrestobar12345';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('picosresto@gmail.com', "Pico's Restobar");
$mail->addReplyTo('picosresto@gmail.com', "Pico's Restobar");
$mail->addAddress($data->email);     // Add a recipient

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Reservation confirm code';
$mail->Body    = "<div>
				  	Dear valued customer,
				  </div>
				  <br/>
				  <div>
					Hello, this is Pico's Restobar. To confirm your " . $type1 . ", please input this code in the box provided in the reservation form.
				  </div>
				  <br/>
				  <div>
				  	<b style='font-size: 30px;'>" . $data->code . "</b>
				  </div>
				  <br/>
				  <div>
				  	Thank you for " . $type2 . " at Pico's Restobar! See you there!<br/>
				  	<small>*This email is sent by an automatic mailer. Do not reply to this email</small>
				  </div>";

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
