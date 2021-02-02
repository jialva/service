<?php
	class fechasModelo{
		private $db;

		public function __construct()
		{
			$this->db = new DataBase;
		}

		public function ciclos(){
	      $this->db->query("SELECT codsuc,codciclo,descripcion FROM facturacion.detciclosucursal WHERE codciclo in (1,4,6,7,8,9,11,12,13,14,16,17,18,20,21,35) AND descripcion <> '' ORDER BY codciclo ASC");
	      return $this->db->registers();
		}

		public function periodo($codciclo){
			$this->db->query("select * from facturacion.periodofacturacion where codciclo=$codciclo and facturacion=1 order by nrofacturacion desc limit 1");
	      	return $this->db->register();
		}

		public function datosfecha($codciclo,$anio,$mes,$tipofacturacion){
			$this->db->query("select * from facturacion.impresion_recibos where codciclo=$codciclo and anio='$anio' and mes='$mes' and tipofacturacion=$tipofacturacion limit 1");
	      	return $this->db->register();
		}

		public function actualizarfechas($codciclo,$anio,$mes,$tipofacturacion,$fechaanterior,$fechaultima,$fechaemision,$fechavencimiento,$fechacorte){
			try {
				$this->db->transaccion();

				$this->db->query("UPDATE facturacion.impresion_recibos SET fechalecturaanterior='$fechaanterior', fechalecturaultima='$fechaultima', fechaemision='$fechaemision', fechavencimientonormal='$fechavencimiento', fechacorte='$fechacorte' WHERE tipofacturacion=$tipofacturacion AND anio='$anio' AND mes='$mes' AND codciclo=$codciclo"
				);
		      	$this->db->execute();

		      	$this->db->query("UPDATE facturacion.cabfacturacion SET fechalectanterior='$fechaanterior', fechalectultima='$fechaultima', fechavencimiento='$fechavencimiento' WHERE tipofacturacion=$tipofacturacion AND anio='$anio' AND mes='$mes' AND codciclo=$codciclo"
				);
		      	$this->db->execute();

		      	$this->db->query("UPDATE facturacion.periodofacturacion SET fechacorte='$fechacorte' WHERE anio='$anio' AND mes='$mes' AND codciclo=$codciclo"
				);
		      	$this->db->execute();

		      	$this->db->commit();
			return 1;
		} catch (Exception $e) {
		    $this->db->rollBack();
			return $e->getMessage();
		}
		}
	}
?>
