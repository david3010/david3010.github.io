<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "administracion@lotusadministracion.com";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content = "Subject: $subject\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";

        $titulo    = '! Lotus Website - Informacion de Contacto !';
        $email_headers = 'MIME-Version: 1.0' . "\r\n";
        $email_headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $email_headers .= 'From: LotusWebsite <administracion@haztechconsulting.com>';
        // weayfxtuxswoyvil

        // Build the email headers.
        // $email_headers = "From: $name <$email>";
        $enviar = mail($recipient,$title, $email_content, $email_headers);
        // Send the email.
        if ($enviar) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo $enviar;
            echo "Gracias! Tu mensaje ha sido enviado.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Algo salió mal y no pudimos enviar tu mensaje.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>

