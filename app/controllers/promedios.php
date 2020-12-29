<?php
	class promedios extends Controller{
		public function __construct(){
	      if(Session::get('autenticado')){
				$this->promedios = $this->model('promediosModelo');
				//$this->menu();

	      	}else{
	       		$this->redireccionar();
	      	}
		}

	    public function index(){
	    	$ciclos = $this->promedios->sucursales();
	    	$select = '<option value="0">--Seleccione--</option>';
	    	foreach ($ciclos as $row) {
	    		$select .= '<option value="'.$row['codsuc'].'">'.$row['descripcion'].'</option>';
	    	}
			$date=[
				'titulo'=>'Promedios',
				'titulopagina'=>'Actualizar Promedios',
				'sucursales' => $select
			];
	      	$js = ['0'=>'promedios.js'];
				$this->viewAdmin('promedios/index',$js,$date);
		}

		public function actualizarpromedios(){
			$tipo = $_FILES['archivo']['type'];
			$tamanio = $_FILES['archivo']['size'];
			$archivotmp = $_FILES['archivo']['tmp_name'];
			$lineas = file($archivotmp);
			$codsuc = $_POST['codsuc'];
			$anio = $_POST['anio'];
			$mes = $_POST['mes'];
			$todos = $_POST['todos'];
			$i=0;
			$sql = '';
			$predios = '';
			foreach ($lineas as $linea_num => $linea){
			   if($i != 0){
			       $datos = explode(";",$linea);			 
			       $nroinscripcion = $datos[0];
			       $promedio = $datos[1];
			       $predios .=$nroinscripcion.',';
			       $sql .="WHEN nroinscripcion = $nroinscripcion THEN $promedio ";
			   }
			   $i++;
			}
			$i = $i-1;
			$predios = substr($predios,0,-1);
			$resp = $this->promedios->actualizarpromedios($codsuc,$todos,$sql,$predios,$anio,$mes);
			$cli = 0;
			$con = 0;
			$lec = 0;
			if($resp != 0){
				$totales = explode(",", $resp);
				$cli = $totales[0];
				$con = $totales[1];
				$lec = $totales[2];
			}
			$arr = [
					'resp'=>$resp,
					'cli'=> $cli,
					'con'=> $con,
					'lec'=> $lec,
					'total'=> $i
				];
			echo json_encode($arr);
		}
	}
?>
