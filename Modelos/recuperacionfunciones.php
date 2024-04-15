<?php
require ("../Config/conexion.php");
$conexion = new Conectar();
$conn = $conexion->Conexion();

if ($conn) {
	//$usuario = $_GET['Usuario'];
	$usuario = "PANQUEQUE";
	$sql = "SELECT ID_USUARIO FROM tbl_ms_usuario WHERE USUARIO = '$usuario'";
	$stmt = $conn->query($sql);

	// Verificar si se encontraron resultados	
		if ($stmt->rowCount() > 0) {
			$idusuario = $stmt->fetch(PDO::FETCH_ASSOC);
			$id = $idusuario['ID_USUARIO'];
			$_SESSION['id_usuario'] = $id;
	
			$sql = "SELECT p.PREGUNTA 
			FROM tbl_ms_preguntas_usuario pu 
			INNER JOIN tbl_ms_preguntas p ON pu.ID_PREGUNTA = p.ID_PREGUNTA 
			WHERE pu.ID_USUARIO = '$id';";

			$stmt = $conn->query($sql);
	
			if($stmt->rowCount() > 0){
				$array_resultados = array();
	
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$array_resultados[] = $row['PREGUNTA']; // Aquí deberías acceder a 'ID_PREGUNTA' si lo necesitas
				}
	
				$datos = array("Opción 1", "Opción 2", "Opción 3", "Opción 4");
				echo json_encode($array_resultados);
			} else {
				echo json_encode(array('error' => 'No se encontraron preguntas para este usuario.'));
			}
	}else {
		// No se encontraron resultados
		echo json_encode(array('error' => 'No se encontró ningún usuario con el nombre proporcionado.'));
	}
}else{
	echo 'location.reload();';
	echo 'alert("Error con el servidor intentelo mas tarde.");';
}
?>