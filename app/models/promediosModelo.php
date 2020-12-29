<?php
	class promediosModelo{
		private $db;

		public function __construct()
		{
			$this->db = new DataBase;
		}

		public function sucursales(){
		    $this->db->query("SELECT codsuc,descripcion FROM admin.sucursales ORDER BY codsuc ASC");
		    return $this->db->registers();
		}

		public function actualizarpromedios($codsuc,$todos,$sql,$predios,$anio,$mes){
			$and = " AND codsuc = $codsuc";
			if($todos == 1){
				$and = '';
			}
			try {
				$this->db->query("UPDATE catastro.conexiones SET lecturapromedio = CASE $sql END WHERE nroinscripcion IN (".$predios.") $and");
		      	$this->db->execute();
		      	$con = $this->db->rowCount();

		      	$this->db->query("UPDATE catastro.clientes SET lecturapromedio = CASE $sql END WHERE nroinscripcion IN (".$predios.") $and");
		      	$this->db->execute();
		      	$cli = $this->db->rowCount();

		      	$this->db->query("UPDATE medicion.lecturas SET lecturapromedio = CASE $sql END WHERE nroinscripcion IN (".$predios.") AND anio='$anio' AND mes='$mes' $and");
		      	$this->db->execute();
		      	$lec = $this->db->rowCount();

		      	return $con.','.$cli.','.$lec;
		    } catch (Exception $e) {
				return 0;
			}
		}
	}
?>
