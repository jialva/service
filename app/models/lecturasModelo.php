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

		public function ciclos(){
			$this->db->query("SELECT codsuc,codciclo,descripcion FROM facturacion.detciclosucursal WHERE codciclo in (1,4,6,7,8,9,11,12,13,14,16,17,18,20,21,35) AND descripcion <> '' ORDER BY codciclo ASC");
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

		public function resumenlecturas($codciclo,$anio,$mes){
			//$mes = 1;
			$this->db->query("SELECT fechareg,
								(SELECT count(l.codestlectura) 
									FROM medicion.lecturas l
									INNER JOIN estadolectura est ON est.codestlectura=l.codestlectura
									WHERE est.promediar = 0 AND l.codestlectura<>3  AND l.anio='$anio' AND l.mes='$mes' AND l.codciclo=$codciclo
								) as leidos,
								(SELECT count(l.codestlectura) 
									FROM medicion.lecturas l
									INNER JOIN estadolectura est ON est.codestlectura=l.codestlectura
									WHERE est.promediar = 1 AND l.codestlectura<>3  AND l.anio='$anio' AND l.mes='$mes' AND l.codciclo=$codciclo
								) as promedios,
								(SELECT count(codestlectura)
									FROM medicion.lecturas
									WHERE codestlectura<>3 AND anio='$anio' AND mes='$mes' AND codciclo=$codciclo
								) as digitados,
								(SELECT count(codestlectura)
									FROM medicion.lecturas
									WHERE anio='$anio' AND mes='$mes' AND codciclo=$codciclo
								) as total
								FROM medicion.lecturas 
								WHERE codciclo=$codciclo AND anio='$anio' AND mes='$mes' LIMIT 1");
			return $this->db->register();
		}

		public function lecturas($codciclo,$anio,$mes,$codestado){
			$this->db->query("SELECT l.*,cl.catetar,cl.lecturapromedio,cl.nroinscripcion
							FROM medicion.lecturas l
							INNER JOIN catastro.clientes cl ON cl.nroinscripcion=l.nroinscripcion AND cl.codsuc=l.codsuc AND cl.codciclo=l.codciclo
							WHERE l.codciclo=$codciclo AND l.anio='$anio' AND l.mes='$mes' AND l.codestlectura=$codestado");
			return $this->db->registers();
		}

		public function tarifario($codsuc){
			$this->db->query("SELECT catetar,volumenesp FROM facturacion.tarifas WHERE codsuc=$codsuc ORDER BY catetar ASC");
			return $this->db->registers();
		}
	}
?>
