<?php
	class rutasecuencia extends Controller{
		public function __construct(){
	      if(Session::get('autenticado')){
				$this->rutas = $this->model('rutasModelo');
				//$this->menu();

	      	}else{
	       		$this->redireccionar();
	      	}
		}

	    public function index(){
	    	$ciclos = $this->rutas->sucursales();
	    	$select = '<option value="0">--Seleccione--</option>';
	    	foreach ($ciclos as $row) {
	    		$select .= '<option value="'.$row['codsuc'].'">'.$row['descripcion'].'</option>';
	    	}
			$date=[
				'titulo'=>'Rutas y Secuencia',
				'titulopagina'=>'Rutas y Secuencia',
				'sucursales' => $select
			];
	      	$js = ['0'=>'rutas.js'];
				$this->viewAdmin('rutas/index',$js,$date);
		}

		public function actualizarrutasecuencia(){
			$tipo = $_FILES['archivo']['type'];
			$tamanio = $_FILES['archivo']['size'];
			$archivotmp = $_FILES['archivo']['tmp_name'];
			$lineas = file($archivotmp);
			$codsuc = $_POST['codsuc'];
			$todos = $_POST['todos'];
			$i=0;
			$sql = '';
			$predios = '';
			foreach ($lineas as $linea_num => $linea){
			   if($i != 0){
			       $datos = explode(";",$linea);			 
			       $nroinscripcion = $datos[0];
			       $secuencia = $datos[1];
			       $predios .=$nroinscripcion.',';
			       $sql .="WHEN nroinscripcion = $nroinscripcion THEN $secuencia ";
			   }
			   $i++;
			}
			$i = $i-2;
			$predios = substr($predios,0,-1);
			$resp = $this->rutas->actualizarrutasecuencia($codsuc,$todos,$sql,$predios);
			$arr = [
					'resp'=>$resp,
					'total'=> $i
				];
			echo json_encode($arr);
		}
	}
?>
