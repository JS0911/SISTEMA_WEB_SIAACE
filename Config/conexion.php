<?php
  
  class Conectar {
      protected $dbh;
  
      public function Conexion() {
          try {
             //$conectar = $this->dbh = new PDO("mysql:host=localhost; dbname=siaace", "root", "lunamar123");
             $conectar = $this->dbh = new PDO("mysql:host=db-instance-idh.chycs44sg2bk.us-east-1.rds.amazonaws.com; dbname=siaace_db", "admin", "idh123DB");
              $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configuración para lanzar excepciones en caso de error
              $this->set_names(); // Llamada al método para establecer el juego de caracteres
              return $conectar;
          } catch (PDOException $e) {
              print "Error Fail Conexion BD!: " . $e->getMessage() . "<br/>";
              die();
          }
      }
      
      public function set_names() {
          return $this->dbh->query("SET NAMES 'utf8'");
      }
  }
  

//   <!-- <?php
//    // class Conectar {
//         protected $dbh;

//         public function Conexion() {

//             try {
//                 //$conectar = $this->dbh = new PDO("mysql:host=127.0.0.1;dbname=siaace", "root", 'lunamar123');
//                 $conectar = $this->dbh = new PDO("mysql:host=db-instance-idh.chycs44sg2bk.us-east-1.rds.amazonaws.com; dbname=siaace_db", "admin", "idh123DB");
//                 return $conectar;
//             } catch (Exception $e) {
//                 print "Error BD!: " . $e->getMessage() . "<br/>";
//                 die();
//             }
//         }

//         public function set_names() {
//             return $this->dbh->query("SET NAMES 'utf8'");
//         }
//     } -->