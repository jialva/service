<?php
	class fechas extends Controller{
		public function __construct(){
	      if(Session::get('autenticado')){
				$this->fechas = $this->model('fechasModelo');
				//$this->menu();

	      	}else{
	       		$this->redireccionar();
	      	}
		}

	    public function index(){
	    	$ciclos = $this->fechas->ciclos();
	    	$select = '<option value="0">--Seleccione--</option>';
	    	foreach ($ciclos as $row) {
	    		$select .= '<option value="'.$row['codciclo'].'">'.$row['descripcion'].'</option>';
	    	}
			$date=[
				'titulo'=>'Fechas',
				'titulopagina'=>'Actualizar Fechas',
				'ciclos' => $select
			];
	      	$js = ['0'=>'fechas.js'];
				$this->viewAdmin('fechas/index',$js,$date);
		}

		public function periodo(){
			$codciclo = $_POST['codciclo'];
			$items = $this->fechas->periodo($codciclo);
			$arr = [
				'periodo'=>$this->mestexto($items['mes']).'-'.$items['anio'],
				'anio'=>$items['anio']??'',
				'mes'=>$items['mes']??'',
				'nrofacturacion'=>$items['nrofacturacion']??''
			];
			echo json_encode($arr);
		}

		public function datosfecha(){
			$codciclo = $_POST['codciclo'];
			$anio = $_POST['anio'];
			$mes = $_POST['mes'];
			$tipofacturacion = $_POST['tipofacturacion'];
			$items = $this->fechas->datosfecha($codciclo,$anio,$mes,$tipofacturacion);
			if(!empty($items)){
				$arr = [
					'resp'=>1,
					'fechaanterior'=>$items['fechalecturaanterior'],
					'fechaactual'=>$items['fechalecturaultima'],
					'fechaemision'=>$items['fechaemision'],
					'fechavencimiento'=>$items['fechavencimientonormal'],
					'fechacorte'=>$items['fechacorte']
				];
			}else{
				$arr = ['resp'=>0];
			}
			echo json_encode($arr);
		}

		public function actualizarfechas(){
			$codciclo = $_POST['codciclo'];
			$anio = $_POST['anio'];
			$mes = $_POST['mes'];
			$tipofacturacion = $_POST['tipofacturacion'];
			$fechaanterior = $_POST['fechaanterior'];
			$fechaultima = $_POST['fechaultima'];
			$fechaemision = $_POST['fechaemision'];
			$fechavencimiento = $_POST['fechavencimiento'];
			$fechacorte = $_POST['fechacorte'];
			$resp = $this->fechas->actualizarfechas($codciclo,$anio,$mes,$tipofacturacion,$fechaanterior,$fechaultima,$fechaemision,$fechavencimiento,$fechacorte);
			if($resp==1){
				$arr = [
					'ok'=>1,
					'mensaje'=>'Las fechas fueron actualizadas'
				];
			}else{
				$arr = [
					'ok'=>0,
					'mensaje'=>'Error al actualizar fechas'
				];
			}
			echo json_encode($arr);
		}
	}
?>
