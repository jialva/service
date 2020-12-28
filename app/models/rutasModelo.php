<?php
	class rutasModelo{
		private $db;

		public function __construct()
		{
			$this->db = new DataBase;
		}

		public function sucursales(){
		    $this->db->query("SELECT codsuc,descripcion FROM admin.sucursales ORDER BY codsuc ASC");
		    return $this->db->registers();
		}

		public function actualizarrutasecuencia($codsuc,$todos,$sql,$predios){
			$and = " AND codsuc = $codsuc";
			if($todos == 1){
				$and = '';
			}
			try {
				$this->db->query("UPDATE catastro.conexiones SET orden_dist = CASE $sql END WHERE nroinscripcion IN (".$predios.") $and");
		      	$this->db->execute();
		      	return $this->db->rowCount();
		    } catch (Exception $e) {
				return 0;
			}
	      	//return $b;
		}
	}
?>
