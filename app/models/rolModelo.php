<?php
	class rolModelo{
		private $db;

		public function __construct()
		{
			$this->db = new DataBase;
		}

		public function modulopadre(){
	      $this->db->query("SELECT * FROM modulo WHERE estado=1 AND modulo_padre=1 ORDER BY orden ASC");
	      return $this->db->registers();
		}

		public function modulos($idpadre){
			$this->db->query("SELECT * FROM modulo WHERE estado=1 AND modulo_padre=$idpadre ORDER BY orden ASC");
	      	return $this->db->registers();
		}

		public function seleccionar($idmodulo,$idrol){
	      $this->db->query("SELECT *
							FROM permisos
							WHERE idrol = $idrol AND idmodulo=$idmodulo");
	      return $this->db->register();
		}

		public function daracceso($idrol,$idmodulo){
			$this->db->query("INSERT INTO permisos(idmodulo,idrol) VALUES($idmodulo,$idrol)");
			$this->db->execute();
		}

		public function quitaracceso($idrol,$idmodulo){
			$this->db->query("DELETE FROM permisos WHERE idmodulo=$idmodulo AND idrol=$idrol");
			$this->db->execute();
		}

		public function nombrerol($idrol){
			$this->db->query("SELECT * FROM rol WHERE idrol=$idrol");
	      return $this->db->register();
		}
	}
?>
