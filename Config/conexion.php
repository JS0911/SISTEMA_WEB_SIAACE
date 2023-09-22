<!DOCTYPE html>
<html>
<head>
    <title>Estado de la Conexión</title>
</head>
<body>
    <?php
    class Conectar {
        protected $dbh;

        public function Conexion() {
            $Conectado = ""; // Inicializamos la variable

            try {
                $conectar = $this->dbh = new PDO("mysql:host=127.0.0.1;dbname=siaace", "root", 'lunamar123');
                $Conectado = "Si Conecto"; // Asignamos un valor si la conexión es exitosa
                return $conectar;
            } catch (Exception $e) {
                print "Error BD!: " . $e->getMessage() . "<br/>";
                $Conectado = "No Conecto"; // Asignamos un valor si hay un error
                die();
            }
        }

        public function set_names() {
            return $this->dbh->query("SET NAMES 'utf8'");
        }
    }

    // Crear una instancia de la clase Conectar
    $conexion = new Conectar();

    // Inicializar la variable Conectado
    $Conectado = "";

    // Intentar establecer la conexión
    try {
        $dbh = $conexion->Conexion();
        $conexion->set_names();
        $Conectado = "Si Conecto"; // Asignamos un valor si la conexión es exitosa
    } catch (Exception $e) {
        $Conectado = "No Conecto"; // Asignamos un valor si hay un error
    }
    ?>

    <h1>Estado de la Conexión</h1>
    <p>La conexión a la base de datos fue: <?php echo $Conectado; ?></p>
    <!-- Aquí puedes mostrar más información o realizar otras acciones en HTML -->
</body>
</html>
