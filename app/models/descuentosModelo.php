<?php
	class descuentosModelo{
		private $db;

		public function __construct()
		{
			$this->db = new DataBase;
		}

		public function sucursales(){
		    $this->db->query("SELECT codsuc,descripcion FROM admin.sucursales ORDER BY codsuc ASC");
		    return $this->db->registers();
		}

		public function eliminar($sql,$tipo){
			$and = " AND tipo = ".$tipo;
			if($tipo == 0){
				$and = "";
			}
			try {
				$this->db->query("DELETE FROM facturacion.descuento_desabastecimiento WHERE nroinscripcion IN (".$sql.") AND facturado=0 $and");
		      	$this->db->execute();
		      	return $this->db->rowCount();
		    } catch (Exception $e) {
				//return $e->getMessage();
				return 0;
			}
	      	//return $b;
		}
	}
?>
