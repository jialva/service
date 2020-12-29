<?php
	class tipofacturacion extends Controller{
		public function __construct(){
	      if(Session::get('autenticado')){
				$this->tipofac = $this->model('tipofacturacionModelo');
				//$this->menu();

	      	}else{
	       		$this->redireccionar();
	      	}
		}

	    public function index(){
	    	$ciclos = $this->tipofac->sucursales();
	    	$select = '<option value="0">--Seleccione--</option>';
	    	foreach ($ciclos as $row) {
	    		$select .= '<option value="'.$row['codsuc'].'">'.$row['descripcion'].'</option>';
	    	}
			$date=[
				'titulo'=>'Tipo Facturación',
				'titulopagina'=>'Tipo Facturación',
				'sucursales' => $select
			];
	      	$js = ['0'=>'tipofacturacion.js'];
				$this->viewAdmin('tipofacturacion/index',$js,$date);
		}

		public function actualizartipofacturacion(){
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
			       $codigo = $datos[2];
			       $predios .=$nroinscripcion.',';
			       $sql .="WHEN nroinscripcion = $nroinscripcion THEN $codigo ";
			   }
			   $i++;
			}
			$i = $i-1;
			$predios = substr($predios,0,-1);
			$resp = $this->tipofac->actualizartipofacturacion($codsuc,$todos,$sql,$predios,$anio,$mes);
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
