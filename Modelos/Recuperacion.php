<?php
    //require ("../Config/conexion.php");

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
		/*
        public function getUserEmail(string $strEmail, string $strusuario){
			//$this->strEmail = $strEmail;
			//$this->strUsuario = $usuario;
			$sql = "SELECT * FROM tbl_ms_usuario WHERE CORREO_ELECTRONICO = '$strEmail' and USUARIO = '$strusuario'";
			//$stmt = $conn->query($sql);
			return $sql;
		}
		*/
		
		public function setTokenUser(string $usuario, string $token){
			$sql = "INSERT INTO tbl_ms_token
			(token, fecha_date, creado_por, fecha_creacion)
			VALUES
			('$token',now(),'$usuario',now());";
			return $sql;
		}
		public function sendMail(string $email,string $token)
		{
			
		}
		public function	setNuevaContrasena(string $hash_contrasena, string $idusuario){
			$sql = "UPDATE tbl_ms_usuario SET CONTRASENA = '$hash_contrasena', MODIFICADO_POR = 'Lester' WHERE USUARIO= '$idusuario'";
			return $sql;
		}
    }

?>