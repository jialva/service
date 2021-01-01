<?php
	class eliminardescuentos extends Controller{
		public function __construct(){
	      if(Session::get('autenticado')){
				$this->descuentos = $this->model('descuentosModelo');
				//$this->menu();

	      	}else{
	       		$this->redireccionar();
	      	}
		}

	    public function index(){
	    	$ciclos = $this->descuentos->sucursales();
	    	$select = '<option value="0">--Seleccione--</option>';
	    	foreach ($ciclos as $row) {
	    		$select .= '<option value="'.$row['codsuc'].'">'.$row['descripcion'].'</option>';
	    	}
			$date=[
				'titulo'=>'Descuentos',
				'titulopagina'=>'Eliminar Descuentos',
				'sucursales' => $select
			];
	      	$js = ['0'=>'descuentos.js'];
				$this->viewAdmin('descuentos/index',$js,$date);
		}

		public function eliminar(){
			$tipo = $_FILES['archivo']['type'];
			$tamanio = $_FILES['archivo']['size'];
			$archivotmp = $_FILES['archivo']['tmp_name'];
			$lineas = file($archivotmp);
			$codsuc = $_POST['codsuc'];
			$todos = $_POST['todos'];
			$tipo = $_POST['tipo'];
			$i=0;
			$sql = '';
			foreach ($lineas as $linea_num => $linea){
			   if($i != 0){
			       $datos = explode(";",$linea);			 
			       $nroinscripcion = $datos[0];
			       $sql .=$nroinscripcion.",";
			   }
			   $i++;
			}
			$i = $i-2;
			$sql = substr($sql,0,-1);
			$resp = $this->descuentos->eliminar($sql,$tipo);
			$arr = [
					'resp'=>$resp,
					'total'=> $i
				];
			echo json_encode($arr);
		}
	}
?>
