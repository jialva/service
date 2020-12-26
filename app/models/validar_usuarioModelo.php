<?php
	class validar_usuarioModelo{
		private $db;

		public function __construct()
		{
			$this->db = new DataBase;
		}

		public function validardatos($usuario){
	      $this->db->query("SELECT * FROM seguridad.usuarios WHERE login='$usuario'");
	      return $this->db->register();
		}

		public function grilla($idedificio,$idrol){
	      $this->db->query("SELECT * FROM usuario WHERE idrol=$idrol AND idedificio=$idedificio");
	      return $this->db->registers();
		}

		public function desasignar($idpropietario){
			try {
				$this->db->transaccion();
				$this->db->query("SELECT nroasignacion,idedificio FROM asignacion WHERE idpropietario=$idpropietario AND estareg=1 GROUP BY nroasignacion");
				$data = $this->db->registers();
				if(!empty($data)){
					for ($i=0; $i < count($data); $i++) {
						$this->db->query("SELECT id_ui FROM asignacion WHERE nroasignacion=".$data[$i]['nroasignacion']." AND idpropietario=$idpropietario");
						$ui = $this->db->registers();
						foreach ($ui as $row) {
							$this->db->query("UPDATE ui SET ocupado=0 WHERE id_ui=".$row['id_ui']);
							$this->db->execute();
						}

						$this->db->query("SELECT * FROM propietario_secundario WHERE nroasignacion=".$data[$i]['nroasignacion']." LIMIT 1");
							$prop = $this->db->register();
						if(!empty($prop)){
							$this->db->query("UPDATE asignacion SET idpropietario=".$prop['idpropietario'].", residente='".$prop['residente']."' WHERE nroasignacion=".$prop['nroasignacion']." AND estareg=1");
							$this->db->execute();							
							$this->db->query("DELETE FROM propietario_secundario WHERE idprop_sec=".$prop['idprop_sec']);
							$this->db->execute();
						}else{							
							$this->db->query("DELETE FROM asignacion WHERE idpropietario=$idpropietario AND estareg=1 AND nroasignacion=".$data[$i]['nroasignacion']);
							$this->db->execute();
						}
						/*$this->db->query("INSERT INTO log_asignacion(idusuario,fecha,idedificio, nroasignacion,estareg,concepto) VALUES(".Session::get('idusuario').",'".date('Y-m-d H:i:s')."',".Session::get('idedificio').",".$data['nroasignacion'].",1,'Eliminado desde mantenimiento')");
						$this->db->execute();*/
					}					
				}else{
					$this->db->query("SELECT id_ui FROM asignacion WHERE idpropietario=$idpropietario");
					$ui = $this->db->registers();
					foreach ($ui as $row) {
						$this->db->query("UPDATE ui SET ocupado=0 WHERE id_ui=".$row['id_ui']);
						$this->db->execute();
					}
					$this->db->query("DELETE FROM asignacion WHERE idpropietario=$idpropietario AND estareg=1");
					$this->db->execute();
				}
			$this->db->commit();
			return 1;		
			} catch (Exception $e) {
			    $this->db->rollBack();
				return $e->getMessage();
			}
		}
	}
?>
