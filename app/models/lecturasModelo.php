<?php
	class lecturasModelo{
		private $db;

		public function __construct()
		{
			$this->db = new DataBase;
		}

		public function sucursales(){
		    $this->db->query("SELECT codsuc,descripcion FROM admin.sucursales ORDER BY codsuc ASC");
		    return $this->db->registers();
		}

		public function actualizarlecturas($codsuc,$todos,$factual,$fanterior,$lactual,$lanterior,$nconsumo,$eslectura,$predios,$anio,$mes){
			$and = " AND codsuc = $codsuc";
			if($todos == 1){
				$and = '';
			}
			try {
				$this->db->query("UPDATE catastro.conexiones SET
									fechalecturaultima = CASE $factual END,
		      						fechalecturaanterior = CASE $fanterior END,
		      						consumo = CASE $nconsumo END,
		      						lecturaultima = CASE $lactual END,
		      						lecturaanterior = CASE $lanterior END
									WHERE nroinscripcion IN (".$predios.") $and");
		      	$this->db->execute();
		      	$con = $this->db->rowCount();

		      	$this->db->query("UPDATE catastro.clientes SET
		      						fechalecturaultima = CASE $factual END,
		      						fechalecturaanterior = CASE $fanterior END,
		      						consumo = CASE $nconsumo END,
		      						lecturaultima = CASE $lactual END,
		      						lecturaanterior = CASE $lanterior END,
		      						codestlectura = CASE $eslectura END
		      						WHERE nroinscripcion IN (".$predios.") $and");
		      	$this->db->execute();
		      	$cli = $this->db->rowCount();

		      	$this->db->query("UPDATE medicion.lecturas SET 
		      						fechalectultima = CASE $factual END,
		      						fechalectanterior = CASE $fanterior END,
		      						consumo = CASE $nconsumo END,
		      						lecturaultima = CASE $lactual END,
		      						lecturaanterior = CASE $lanterior END,
		      						codestlectura = CASE $eslectura END
		      						WHERE nroinscripcion IN (".$predios.") AND anio='$anio' AND mes='$mes' $and");
		      	$this->db->execute();
		      	$lec = $this->db->rowCount();

		      	return $con.','.$cli.','.$lec;
		    } catch (Exception $e) {
		    	//return $e->getMessage();
				return 0;
			}
		}
	}
?>
