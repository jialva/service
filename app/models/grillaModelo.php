<?php
	class grillaModelo{
		private $db;

		public function __construct()
		{
			$this->db = new DataBase;
		}

		public function ui($idedificio){
			$this->db->query("SELECT tu.descripcion_tipo_ui,uu.m2_ui,uu.nombre_ui, uu.sefactura,
                                CASE WHEN uu.ocupado=0 THEN 'Sin asignar' ELSE 'Asignado' END as condicion ,uu.estareg,uu.id_ui 	
							FROM ui uu 
							INNER JOIN tipo_ui tu on tu.id_tipo_ui=uu.id_tipo_ui
							WHERE uu.idinmueble=$idedificio ORDER BY uu.id_ui DESC");
			return $this->db->registers();
		}

		public function proveedor(){
			$this->db->query("SELECT p.razonsocial,p.nrodocumento,p.telefono,p.idproveedor,p.tipodocumento,p.representante,p.concepto
							FROM proveedor p 
							WHERE p.estado = 1 ORDER BY p.idproveedor DESC");
			return $this->db->registers();
		}

		public function gastos($idedificio){
			$this->db->query("SELECT p.razonsocial,nrorecibo,date_format(fechaemision,'%d-%m-%Y') as emision,importe,idgasto,saldo,date_format(fechavencimiento,'%d-%m-%Y') as vencimiento,e.concepto
							FROM egresos e 
							INNER JOIN proveedor p on e.idproveedor=p.idproveedor
							WHERE e.estado = 1 AND e.idedificio=".$idedificio." ORDER BY e.fechaemision DESC");
			return $this->db->registers();
		}

		public function gastosfiltrado($idedificio,$inicio,$totalpaginacion,$proveedorlistaid,$condicionlista,$fechainicio,$fechaifin){
			$and = '';
			if($proveedorlistaid!=0){
				$and .= " AND e.idproveedor=$proveedorlistaid";
			}
			switch ($condicionlista) {
				case 0:break;
				case 1:$and .=" AND e.saldo=0";break;
				case 2:$and .=" AND e.saldo=e.importe";break;
				case 3:$and .=" AND e.saldo<>e.importe AND e.saldo<>0";break;
			}
			if($fechainicio!=''){
				if($fechaifin!=''){
					$and .=" AND e.fechavencimiento BETWEEN '$fechainicio' AND '$fechaifin'";
				}else{
					$and .=" AND e.fechavencimiento='$fechainicio'";
				}				
			}else{
				if($fechaifin!=''){
					$and .=" AND e.fechavencimiento='$fechaifin'";
				}
			}
			if($totalpaginacion=='todo'){
				$limit="";
			}else{
				$limit="LIMIT $inicio,$totalpaginacion";
			}
			$this->db->query("SELECT p.razonsocial,nrorecibo,date_format(fechaemision,'%d-%m-%Y') as emision,importe,idgasto,saldo,date_format(fechavencimiento,'%d-%m-%Y') as vencimiento,e.concepto
							FROM egresos e 
							INNER JOIN proveedor p on e.idproveedor=p.idproveedor
							WHERE e.estado = 1 AND e.idedificio=".$idedificio." $and ORDER BY e.fechaemision DESC
							$limit");
			return $this->db->registers();
		}

		public function conceptos($idedificio){
			$this->db->query("SELECT destino,codigo,concepto,importe,idconcepto,estareg FROM concepto
							ORDER BY idconcepto DESC");
			return $this->db->registers();
		}

		public function subconceptos($idconcepto){
			$this->db->query("SELECT idsubconcepto,subconcepto,estareg FROM subconcepto
							WHERE idconcepto=$idconcepto
							ORDER BY idsubconcepto DESC");
			return $this->db->registers();
		}

		public function tipoconcepto($idedificio){
			$this->db->query("SELECT descripcion,idtipoconcepto,estareg FROM tipoconcepto
							WHERE idedificio=$idedificio
							ORDER BY idtipoconcepto DESC");
			return $this->db->registers();
		}

		public function tipocomprobante(){
			$this->db->query("SELECT abreviatura,nombre,idtipocomprobante,estado FROM tipocomprobante
							ORDER BY idtipocomprobante DESC");
			return $this->db->registers();
		}

		public function movimientos($idedificio){
			$this->db->query("SELECT m.idmovimiento,DATE_FORMAT(m.fechaoperacion,'%d-%m-%Y') as fecha,c.concepto,m.tipomovimiento,m.importe,m.itf,m.nrooperacion,CASE m.tipomovimiento WHEN 2 THEN u.nombre_ui ELSE (
					SELECT p.razonsocial
					FROM proveedor p
					WHERE p.idproveedor = m.id
				) END as nombre_ui,
				sc.subconcepto,
				(
					SELECT SUM(importe) + SUM(itf) 
				    FROM movimiento 
				    WHERE idmovimiento <=m.idmovimiento AND idedificio=$idedificio AND estado=1
				    ORDER BY idmovimiento desc
				) as saldo
				FROM movimiento m
				INNER JOIN concepto c ON m.concepto=c.idconcepto
				LEFT JOIN ui u ON u.id_ui=m.id
				INNER JOIN subconcepto sc ON sc.idsubconcepto=m.detalle
				WHERE m.idedificio=$idedificio AND m.estado=1
				ORDER BY m.idmovimiento desc");
			return $this->db->registers();
		}

		public function menu($idrol){
			$this->db->query("SELECT m.idmodulo,mp.modulo as padre,m.modulo,m.modulo_padre,mp.orden,m.orden ordenmenu,m.url,mp.icono
											FROM modulo m
											INNER JOIN permisos p ON m.idmodulo=p.idmodulo
											INNER JOIN rol r ON r.idrol=p.idrol
											INNER JOIN modulo mp ON m.modulo_padre=mp.idmodulo
											where r.idrol=$idrol
											order by mp.orden,m.orden ASC");
			return $this->db->registers();
		}

		public function totalpropietariosasignados($idedificio,$idpropietario,$id_ui){
			if($idpropietario==0){
				$propietario = "";
			}else{
				$propietario = " AND a.idpropietario=$idpropietario";
			}

			if($id_ui==0){
				$ui = "";
			}else{
				$ui = " AND a.id_ui=$id_ui";
			}
			$this->db->query("SELECT a.idasignacion,u.nombre,u.apellido,u.documento,u.telefono,u.email,a.idpropietario,a.residente,a.nroasignacion
								FROM asignacion a
								LEFT JOIN usuario u ON a.idpropietario=u.idusuario
								WHERE a.idedificio=$idedificio AND a.estareg=1 $propietario $ui
								GROUP BY a.nroasignacion");
			return $this->db->registers();
		}

		public function totalcuotaagua($idedificio,$anio,$mes){
			$this->db->query("SELECT c.idcontometro,u.id_ui,u.nombre_ui,c.lectura,c.consumo,c.comun,c.tiporeparticion,c.total_comun
					FROM contometro c
					INNER JOIN ui u ON (u.id_ui=c.id_ui) AND (u.idinmueble=c.idedificio)
					WHERE c.idedificio=$idedificio AND c.anio=$anio AND mes='".intval($mes)."'
					ORDER BY LPAD(u.nombre_ui, 50, '0') ASC");
			return $this->db->registers();
		}
	}
?>