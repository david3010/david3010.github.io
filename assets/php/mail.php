<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once "vendor/autoload.php";
        
        $mail = new PHPMailer(true);
    
        try {

            // Get the form fields and remove whitespace.
            $name = strip_tags(trim($_POST["name"]));
            $name = str_replace(array("\r","\n"),array(" "," "),$name);
            $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
            $subject = trim($_POST["subject"]);
            $message = trim($_POST["message"]);

            // Check that data was sent to the mailer.
            if ( empty($name) OR empty($subject) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
                http_response_code(400);
                echo "Por favor complete el formulario e intente de nuevo.";
                exit;
            }

            // Build the email content.
            $email_content = "Name: $name\n";
            $email_content = "Subject: $subject\n";
            $email_content .= "Email: $email\n\n";
            $email_content .= "Message:\n$message\n";


            // Set the recipient email address.
            // FIXME: Update this to your desired email address.
            $recipient = "administracion@lotusadministracion.com";

            $mail->isSMTP();
            $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = "lotuswebsite.adm@gmail.com";   //username
            $mail->Password = "weayfxtuxswoyvil";   //password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;                    //smtp port
        
            $mail->setFrom('lotuswebsite.adm@gmail.com', 'LotusWebsite');
            $mail->addAddress($recipient, 'Lotus Administration Website');
        
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body    = $email_content;
        
            $enviar = $mail->send();

            // Send the email.
            if ($enviar) {
                // Set a 200 (okay) response code.
                http_response_code(200);
                echo "Gracias! Tu mensaje ha sido enviado.";
            } else {
                // Set a 500 (internal server error) response code.
                http_response_code(500);
                echo "Oops! Algo salió mal y no pudimos enviar tu mensaje.";
            }
        
        } catch (Exception $e) {
            http_response_code(403);
            echo 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
        }
    }
?>

