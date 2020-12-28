<?php
	class grupoModelo{
		private $db;

		public function __construct()
		{
			$this->db = new DataBase;
		}

		public function tipoentidades(){
		    $this->db->query("SELECT codtipoentidades,descripcion FROM tipoentidades WHERE estareg=1 ORDER BY codtipoentidades ASC");
		    return $this->db->registers();
		}

		public function actualizarentidades($sql,$predios){
			try {
				$this->db->query("UPDATE catastro.conexiones SET codtipoentidades = CASE $sql END WHERE nroinscripcion IN (".$predios.")");
		      	$this->db->execute();

		      	$this->db->query("UPDATE catastro.clientes SET codtipoentidades = CASE $sql END WHERE nroinscripcion IN (".$predios.")");
		      	$this->db->execute();

		      	return $this->db->rowCount();
		    } catch (Exception $e) {
				return 0;
			}
	      	//return $b;
		}
	}
?>
