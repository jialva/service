<?php
	class lecturas extends Controller{
		public function __construct(){
	      if(Session::get('autenticado')){
				$this->lecturas = $this->model('lecturasModelo');
				//$this->menu();

	      	}else{
	       		$this->redireccionar();
	      	}
		}

	    public function index(){
	    	$ciclos = $this->lecturas->sucursales();
	    	$select = '<option value="0">--Seleccione--</option>';
	    	foreach ($ciclos as $row) {
	    		$select .= '<option value="'.$row['codsuc'].'">'.$row['descripcion'].'</option>';
	    	}
			$date=[
				'titulo'=>'Lecturas',
				'titulopagina'=>'Actualizar Lecturas',
				'sucursales' => $select
			];
	      	$js = ['0'=>'lecturas.js'];
				$this->viewAdmin('lecturas/index',$js,$date);
		}

		public function actualizarlecturas(){
			$tipo = $_FILES['archivo']['type'];
			$tamanio = $_FILES['archivo']['size'];
			$archivotmp = $_FILES['archivo']['tmp_name'];
			$lineas = file($archivotmp);
			$codsuc = $_POST['codsuc'];
			$anio = $_POST['anio'];
			$mes = $_POST['mes'];
			$todos = $_POST['todos'];
			$i=0;
			$factual = '';
			$fanterior = '';
			$lactual = '';
			$lanterior = '';
			$nconsumo = '';
			$eslectura = '';
			$predios = '';
			foreach ($lineas as $linea_num => $linea){
			   if($i != 0){
			       $datos = explode(";",$linea);			 
			       $nroinscripcion = $datos[0];
			       $fechaactual = $this->fechaIn($datos[1]);
			       $fechaanterior = $this->fechaIn($datos[2]);
			       $lectactual = $datos[3];
			       $lectanterior = $datos[4];
			       $consumo = $datos[5];
			       $estlectura = $datos[6];
			       $predios .=$nroinscripcion.',';
			       $factual .="WHEN nroinscripcion = $nroinscripcion THEN '$fechaactual'::date ";
			       $fanterior .="WHEN nroinscripcion = $nroinscripcion THEN '$fechaanterior'::date ";
			       $lactual .="WHEN nroinscripcion = $nroinscripcion THEN $lectactual ";
			       $lanterior .="WHEN nroinscripcion = $nroinscripcion THEN $lectanterior ";
			       $nconsumo .="WHEN nroinscripcion = $nroinscripcion THEN $consumo ";
			       $eslectura .="WHEN nroinscripcion = $nroinscripcion THEN $estlectura ";
			   }
			   $i++;
			}
			$i = $i-1;
			$predios = substr($predios,0,-1);
			$resp = $this->lecturas->actualizarlecturas($codsuc,$todos,$factual,$fanterior,$lactual,$lanterior,$nconsumo,$eslectura,$predios,$anio,$mes);
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
