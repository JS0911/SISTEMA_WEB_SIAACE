<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/Exception.php';
require '../../PHPMailer/PHPMailer.php';
require '../../PHPMailer/SMTP.php';
    class Recuperar extends Conectar
    {
		public $PToken;

		public function generar_Token($leng=10){
			$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$token = "";
			for($i=0;$i<$leng;$i++)
			{
				$token .= $cadena[rand(0,35)];
			}
		return $token;
		}
		
		public function setTokenUser(string $usuario, string $token,string $idusuario){
			$sql = "INSERT INTO tbl_ms_token
			(id_usuario, token, fecha_date, creado_por, fecha_creacion)
			VALUES
			('$idusuario','$token',now(),'$usuario',now());";
			return $sql;
		}
		
		public function	setNuevaContrasena(string $hash_contrasena, string $idusuario){
			$sql = "UPDATE tbl_ms_usuario SET CONTRASENA = '$hash_contrasena', MODIFICADO_POR = 'Lester' WHERE USUARIO= '$idusuario'";
			return $sql;
		}
    
		public function enviarCorreo($email,$asunto,$mensaje){
			//Create an instance; passing `true` enables exceptions
			$mail = new PHPMailer(true);
					try {
						//Server settings                    //Enable verbose debug output
						$mail->isSMTP();                                            //Send using SMTP
						$mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
						$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
						$mail->Username   = 'SIAACEpruebaIDH@outlook.com';                     //SMTP username
						$mail->Password   = 'SistemaIDH2023';           //Enable implicit TLS encryption
						$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
					
						//Recipients
						$mail->setFrom('SIAACEpruebaIDH@outlook.com', 'IDH');
						$mail->addAddress($email,'Usuario');
						//Content
						$mail->isHTML(true);                                  //Set email format to HTML
						$mail->Subject = $asunto;
						$mail->Body    = $mensaje;
						$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
					
						$mail->send();
						return 'Por favor revise su correo electronico';
					} catch (Exception $e) {
						return "Ha ocurrido un error. Intentelo mas tarde.";
					}
		}

		Public function VerificarToken($token,$idusuario){
			$conexion = new Conectar();
       		$conn = $conexion->Conexion();
			$idusuario_entero = (int)$idusuario;
			$sql = "SELECT token FROM tbl_ms_token WHERE id_usuario = '$idusuario_entero' ORDER BY fecha_creacion DESC LIMIT 1;";
        	$smt = $conn->query($sql);
			$row = $smt->fetch(PDO::FETCH_ASSOC);
            $tok = $row['token'];
			$num = $smt->rowCount();
			if($num > 0 and $token=$smt){
				return 'ok';
			}else{
				return 0;
			}
		}
	}
?>