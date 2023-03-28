<?php
if (isset($_GET['Email'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "javierparraguirrel@gmail.com";
    $email_subject = "Nuevo Mensaje de contacto";

    function problem($error)
    {
        echo "Lo sentimos mucho pero hay un error(s) encontrados en su solicitud. ";
        echo "estos errores aparecen aca.<br><br>";
        echo $error . "<br><br>";
        echo "porfavor regrese.<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_GET['Name']) ||
        !isset($_GET['Email']) ||
        !isset($_GET['Message'])
    ) {
        problem('Lo sentimos mucho pero hay un error(s) encontrados en su solicitud.');
    }

    $name = $_GET['Name']; // required
    $email = $_GET['Email']; // required
    $message = $_GET['Message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'El correo electronico que ingreso no es valido.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'El nombre que ingreso no es valido.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'El mensaje que ingreso no es valido.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Detalles de la solicitud a continuacion.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Nombre: " . clean_string($name) . "\n";
    $email_message .= "Correo: " . clean_string($email) . "\n";
    $email_message .= "Mensaje: " . clean_string($message) . "\n";

    // create email headers
    $headers = 'De: ' . $email . "\r\n" .
        'Responder-a: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- include your success message below -->

    Gracias por contactarnos, pronto nos comunicaremos con usted.

<?php
}
?>
