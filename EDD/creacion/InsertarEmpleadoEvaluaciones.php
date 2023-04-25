<?php

include("../../model/conexion.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '../../PHPMailer/PHPMailer.php';
require '../../PHPMailer/SMTP.php';

require '../../PHPMailer/Exception.php';

if (isset($_GET['insertarEmpleado'])) {

    $data = json_decode(file_get_contents("php://input"));
    $nombreEquipo = $data->nombreEquipo;
    $codigoEvaluacion = $data->codigoEvaluacion;
    $correo = $data->correo;
    $ultimoUsuario = $data->ultimoUsuario;




    if (!empty($codigoEvaluacion) && !empty($correo)) {

        $query = "INSERT INTO `edd-analistas` (codigoEvaluacion, idEmpleado, enviado, fechaActualizacion, ultimoUsuario) VALUES ('$codigoEvaluacion', (SELECT ID from empleados WHERE correo = '$correo'), true, current_timestamp(), '$ultimoUsuario')";


        $result = mysqli_query($conection, $query);

        if (!$result) {
            die(json_encode('Query Failed.'));
        } else {


            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Timeout = 20;
                $mail->Host       = 'smtp-mail.outlook.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'testCorreosCoe@outlook.com';
                $mail->Password   = 'examplepassword12345';
                $mail->Port       = 587;
                // $mail->SMTPDebug = 4;

                //Recipients
                $mail->setFrom('testCorreosCoe@outlook.com', 'COE - ACADEMIA');
                $mail->addAddress('Emiliano.Sotomayor@tsoftglobal.com', 'Usuario Final');     //Add a recipient

                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';                         //Set email format to HTML
                $mail->Subject = 'Encuesta';



                $mail->Body    = "Hola, Has sido invitado a responder una encuestra sobre tu referente actual.
        <br />
        <a href='http://localhost:3000//FormularioRefEDD/$codigoEvaluacion'>Formulario.</a>
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
} else {
    echo json_encode('Error');
}
