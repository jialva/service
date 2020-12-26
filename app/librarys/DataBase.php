<?php
	class DataBase{

		private $dbh;
		private $stmt;
		private $error;

		public function __construct(){
			$dsn = 'pgsql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME;
			$opciones = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);

			try {
				$this->dbh = new PDO($dsn,DB_USUARIO,DB_PASSWORD,$opciones);
			} catch (PDOException $e) {
				$this->error = $e->getMessage();
				echo $this->error;
			}
		}

		public function transaccion(){
			$this->stmt = $this->dbh->beginTransaction();
		}

		public function commit(){
			$this->stmt = $this->dbh->commit();
		}

		public function rollBack(){
			$this->stmt = $this->dbh->rollBack();
		}

		public function query($sql){
			$this->stmt = $this->dbh->prepare($sql);
		}

		public  function bind($params, $value, $tipo = null){
			if (is_null($tipo)) {
				switch (true) {
					case is_int($value):$tipo=PDO::PARAM_INT;break;
					case is_bool($value):$tipo=PDO::PARAM_BOOL;break;
					case is_null($value):$tipo=PDO::PARAM_NULL;break;
					default:$tipo=PDO::PARAM_STR;break;
				}
			}
			$this->stmt->bindValue($params,$value,$tipo);
		}

		public function execute(){
			return $this->stmt->execute();
		}

		public function registers(){
			$this->execute();
			return $this->stmt->fetchAll();
		}

		public function register(){
			$this->execute();
			return $this->stmt->fetch();
		}

		public function rowCount(){
			return $this->stmt->rowCount();
		}
	}
?>
