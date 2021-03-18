<?php

    $email = "hola@elrinconemprendedor.com";
    $para = $_POST["paraEmail"];
    $asunto = $_POST["paraAsunto"];
    $mensaje = $_POST["paraMensaje"];

    $nombrePara = strstr($para,"@",true);
    $dominoPara = strstr($para,"@",false);

    $para = $nombrePara.$dominoPara;
    $cabecera = "From:".$email;

    $resultado = mail($para,$asunto,$mensaje,$cabecera);
    if ($resultado) {
    	header("Location: mailProveedor.php?mensaje=Email Enviado.");
    } else {
    	header("Location: mailProveedor.php?mensaje=Email Rechazado.");
    }

    if($_POST && isset($_FILES['archivo'])) {
    $recipient_email = $para; //Direccion de correo de quien recibe el mail
    $subject         = $asunto;
       
    //Capturo los datos enviados por POST 
    $from_email     = filter_var($_POST["paraEmail"], FILTER_SANITIZE_STRING); 
    $sender_name    = filter_var($_POST["paraAsunto"], FILTER_SANITIZE_STRING);
    $reply_to_email = filter_var($_POST["paraEmail"], FILTER_SANITIZE_STRING); 
   
    //Armo el cuerpo del mensaje    
    $message = "Asunto: " . $sender_name . "\n";
    $message = $message . "Email: " . $from_email . "\n";
    $message = $mensaje . "\n";
   
    //Obtener datos del archivo subido 
    $file_tmp_name    = $_FILES['archivo']['tmp_name'];
    $file_name        = $_FILES['archivo']['name'];
    $file_size        = $_FILES['archivo']['size'];
    $file_type        = $_FILES['archivo']['type'];
    $file_error       = $_FILES['archivo']['error'];
   
    if($file_error > 0)
    {
        header("Location: mailProveedor.php?mensaje=Adrchivo no adjuntado");
    }
       
    //Leer el archivo y codificar el contenido para armar el cuerpo del email
    $handle = fopen($file_tmp_name, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $encoded_content = chunk_split(base64_encode($content));
   
    $boundary = md5("pera");
  
    //Encabezados
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "From:".$email."\r\n"; 
    $headers .= "Reply-To: ".$from_email."" . "\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n"; 
           
    //Texto plano
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n"; 
    $body .= chunk_split(base64_encode($message)); 
           
    //Adjunto
    $body .= "--$boundary\r\n";
    $body .="Content-Type: $file_type; name=".$file_name."\r\n";
    $body .="Content-Disposition: attachment; filename=".$file_name."\r\n";
    $body .="Content-Transfer-Encoding: base64\r\n";
    $body .="X-Attachment-Id: ".rand(1000,99999)."\r\n\r\n"; 
    $body .= $encoded_content; 
       
    //Enviar el mail
    $sentMail = @mail($recipient_email, $subject, $body, $headers);
   
    if($sentMail) //Muestro mensajes segun se envio con exito o si fallo
    {       
        header("Location: mailProveedor.php?mensaje=Email Enviado.");
    }else{
        header("Location: mailProveedor.php?mensaje=Envio rechazado, revise el correo.");
    }
   
}
else{
    header("Location: mailProveedor.php?mensaje=Email Rechazado.");
}
?>