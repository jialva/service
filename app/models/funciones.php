<?php
	class funciones{
		private $db;

		public function __construct()
		{
			$this->db = new DataBase;
		}

		public function edificio($idedificio){
			$this->db->query("SELECT * FROM edificio WHERE idedificio=$idedificio");
			return $this->db->register();
		}

		public function validar($usuario){
			$this->db->query("SELECT * FROM usuario WHERE usuario='$usuario' AND estado=1");
			return $this->db->register();
		}

		public function verregistro($tabla,$idtabla,$id,$sql){
			$this->db->query("SELECT * FROM $tabla WHERE $idtabla=$id $sql");
			return $this->db->register();
		}

		public function verregistros($tabla,$idtabla,$id,$sql){
			$this->db->query("SELECT * FROM $tabla WHERE $idtabla=$id $sql");
			return $this->db->registers();
		}

		public function agregar(){
			$this->db->query("");
			$this->b->execute();
		}

		public function menu($idrol){
			$this->db->query("SELECT m.idmodulo,mp.modulo as padre,m.modulo,m.modulo_padre,mp.orden,m.orden ordenmenu,m.url,mp.icono,p.ver,p.editar,p.crear,p.eliminar
											FROM modulo m
											INNER JOIN permisos p ON m.idmodulo=p.idmodulo
											INNER JOIN rol r ON r.idrol=p.idrol
											INNER JOIN modulo mp ON m.modulo_padre=mp.idmodulo
											where r.idrol=$idrol
											order by mp.orden,m.orden ASC");
			return $this->db->registers();
		}

		public function save($campos,$value,$tabla){
			$this->db->query("INSERT INTO $tabla ($campos) VALUES ($value)");
			if($this->db->execute()){
				$b=1;
			}else{
				$b=0;
			}
			return $b;
		}

		public function update($campos,$where,$tabla){
			$this->db->query("UPDATE $tabla SET $campos WHERE $where");
			if($this->db->execute()){
				$b=2;
			}else{
				$b=0;
			}
			return $b;
		}

		public function desabled($where,$tabla){
			$this->db->query("UPDATE $tabla SET estareg=0 WHERE $where");
			if($this->db->execute()){
				$b=3;
			}else{
				$b=0;
			}
			return $b;
		}

		public function restore($where,$tabla){
			$this->db->query("UPDATE $tabla SET estareg=1 WHERE $where");
			if($this->db->execute()){
				$b=4;
			}else{
				$b=0;
			}
			return $b;
		}

		public function delete($where,$tabla){
			$this->db->query("DELETE FROM $tabla WHERE $where");
			if($this->db->execute()){
				$b=4;
			}else{
				$b=0;
			}
			return $b;
		}

		public function select($tabla,$estado,$sql=''){
			$this->db->query("SELECT * FROM $tabla WHERE estareg in ($estado) $sql");
			return $this->db->registers();
		}

		public function select1($tabla,$estado,$sql=''){
			$this->db->query("SELECT * FROM $tabla WHERE estado in ($estado) $sql");
			return $this->db->registers();
		}

		public function selectinner($tabla,$inner='',$campos,$sql=''){
			if($inner!=''){
				$inner = str_replace('//', ' INNER JOIN ', $inner);
				$inner = "INNER JOIN $inner";
			}
			if($sql!=''){
				$sql = 'WHERE '.$sql;
			}
			$this->db->query("SELECT $campos FROM $tabla $inner $sql");
			return $this->db->registers();
		}

		public function existe($dato,$tabla,$campo,$sql=''){
			$this->db->query("SELECT $campo FROM $tabla WHERE $campo='$dato' $sql");
			return $this->db->register();
		}

		public function id($idtabla,$tabla){
			$this->db->query("SELECT MAX($idtabla) FROM $tabla");
			$id = $this->db->register();
			return $id[0];
		}

		public function eliminarasignaciones($id_ui){
			$this->db->query("UPDATE asignacion SET id_ui=0, porcentaje=0, area=0 WHERE id_ui=$id_ui");
			if($this->db->execute()){
				$b=1;
			}else{
				$b=0;
			}
			return $b;
		}
	}
?>
