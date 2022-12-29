<?php
include('../model/conexion.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';


if (isset($_GET['recuperarPassword'])) {
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;

    $queryVerify = "SELECT * from cuentas_login WHERE correo = '$email'";
    $resultVerify = mysqli_query($conection, $queryVerify);

    if (mysqli_num_rows($resultVerify) === 0) {
        echo json_encode('errorNotFound');
    } else {

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp-mail.outlook.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'testCorreosCoe@outlook.com';
            $mail->Password   = 'examplepassword12345';
            $mail->Port       = 587;


            //Recipients
            $mail->setFrom('testCorreosCoe@outlook.com', 'COE - ACADEMIA');
            $mail->addAddress('testRespuestasCorreosCoe@outlook.com', 'Usuario Final');     //Add a recipient

            // //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Restablecer contraseña';

            while ($row = mysqli_fetch_array($resultVerify)) {
                $ID = $row['ID'];
                $correo = $row['correo'];
            }
            $mail->Body    = "Hola, has generado este correo para restablecer la contraseña de tu cuenta, por favor ingresa al siguiente link para poder continuar con el proceso
            <br />

            <a href='https://academiaformacion.netlify.app/RestablecerPassword/$ID/$correo'>Recuperar contraseña.</a>
        
            <br />
            <br />
            <br />
            <br />
            
            Saludos, 
            <br />

            - Equipo COE - Academia.
            ";
            $mail->AltBody = 'Correo generado para restablecer contraseña.';

            $mail->send();
            echo json_encode(
                [
                    "success" => true,
                    'message' => 'SuccessfulDelivery'
                ]

            );
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
