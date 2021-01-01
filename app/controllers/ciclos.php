<?php
	class ciclos extends Controller{
		public function __construct(){
	      if(Session::get('autenticado')){
				$this->grupo = $this->model('grupoModelo');
				//$this->menu();

	      	}else{
	       		$this->redireccionar();
	      	}
		}

	    public function index(){
	    	$ciclos = $this->grupo->ciclos();
	    	$select = '';
	    	foreach ($ciclos as $row) {
	    		$select .= '<option value="'.$row['codciclo'].'">'.$row['descripcion'].'</option>';
	    	}
			$date=[
				'titulo'=>'Actualizar Atípico',
				'titulopagina'=>'Actualizar Atípico',
				'ciclos' => $select
			];
	      	$js = ['0'=>'ciclos.js'];
				$this->viewAdmin('ciclos/index',$js,$date);
		}

		public function actualizaratipico(){
			$opcion = $_POST['opcion'];
			$codciclo = $_POST['codciclo'];
			$nroinscripcion = $_POST['nroinscripcion'];
			if($opcion == 0){
				$resp = $this->grupo->actualizaratipico($codciclo,$nroinscripcion);
			}else{
				$tipo = $_FILES['archivo']['type'];
				$tamanio = $_FILES['archivo']['size'];
				$archivotmp = $_FILES['archivo']['tmp_name'];
				$lineas = file($archivotmp);
				$i=0;
				$sql = '';
				$predios = '';
				foreach ($lineas as $linea_num => $linea){
				   if($i != 0){
				       $datos = explode(";",$linea);			 
				       $nroinscripcion = $datos[0];
				       $predios .=$nroinscripcion.',';
				       $sql .="WHEN nroinscripcion = $nroinscripcion THEN $codciclo ";
				   }
				   $i++;
				}
				$predios = substr($predios,0,-1);
				$resp = $this->grupo->actualizaratipicomasivo($sql,$predios);
			}			
			
			if($resp!=0){
				$arr = [
					'ok'=>1,
					'mensaje'=>'Registros actualizados'
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
