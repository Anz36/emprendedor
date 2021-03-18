<?php 
	if (isset($_POST["enviar"])) {	
		require "../libreria/Mailer/PHPMailer.php";
		require "../libreria/Mailer/Exception.php";
		require "../libreria/Mailer/SMTP.php";

	   	#$ruta = "upload/".$_FILES['archivo']['name'];
	    #move_uploaded_file($_FILES['archivo']['tmp_name'],$ruta);

		$mail = new PHPMailer\PHPMailer\PHPMailer;
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		$mail->Host='mail.elrinconemprendedor.com';
		$mail->Port= 465;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = 'hola@elrinconemprendedor.com';
		$mail->Password = '4C${k84rLH;Z';

		$mail->setFrom('hola@elrinconemprendedor.com');
		$mail->addReplyTo('hola@elrinconemprendedor.com');
		$mail->addAddress($_POST["paraEmail"]);

		$mail->isHTML(true);
		$mail->Subject = $_POST["paraAsunto"];
		$mail->Body="<p>".$_POST['paraMensaje']."</p>";
		#$mail->addAttachment($ruta);

		if (!$mail->send()) {
			header("Location: ../Email/mailProveedor.php?mensaje=Envio no realizado, intentelo denuevo");
			unlink($ruta);
		} else {
			header("Location: ../Email/mailProveedor.php?mensaje=Se envio el Email.");
		}
	}
 ?>