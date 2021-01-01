<?php
	class grupoModelo{
		private $db;

		public function __construct()
		{
			$this->db = new DataBase;
		}

		public function ciclos(){
	      $this->db->query("SELECT codsuc,codciclo,descripcion FROM facturacion.detciclosucursal WHERE codciclo in (35) AND descripcion <> '' ORDER BY codciclo ASC");
	      return $this->db->registers();
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
		}

		public function actualizaratipico($codciclo,$nroinscripcion){
		    $this->db->query("UPDATE catastro.clientes SET codciclo=$codciclo WHERE nroinscripcion in ($nroinscripcion)");
		    if($this->db->execute()){
		    	return 1;
		    }else{
		    	return 0;
		    }
		}

		public function actualizaratipicomasivo($sql,$predios){
			try {
		      	$this->db->query("UPDATE catastro.clientes SET codciclo = CASE $sql END WHERE nroinscripcion IN (".$predios.")");
		      	$this->db->execute();

		      	return $this->db->rowCount();
		    } catch (Exception $e) {
				//return $e->getMessage();
				return 0;
			}
		}
	}
?>
