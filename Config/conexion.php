    <?php
    class Conectar {
        protected $dbh;

        public function Conexion() {
            $Conectado = ""; // Inicializamos la variable

            try {
                $conectar = $this->dbh = new PDO("mysql:host=127.0.0.1;dbname=siaace", "root", 'lunamar123');
                return $conectar;
            } catch (Exception $e) {
                print "Error BD!: " . $e->getMessage() . "<br/>";
                die();
            }
        }

        public function set_names() {
            return $this->dbh->query("SET NAMES 'utf8'");
        }
    }