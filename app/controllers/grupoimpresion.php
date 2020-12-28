<?php
	class grupoimpresion extends Controller{
		public function __construct(){
	      if(Session::get('autenticado')){
				$this->grupo = $this->model('grupoModelo');
				//$this->menu();

	      	}else{
	       		$this->redireccionar();
	      	}
		}

	    public function index(){
	    	$ciclos = $this->grupo->tipoentidades();
	    	$tabla = '';
	    	foreach ($ciclos as $row) {
	    		$tabla .= '<tr>
                            <td>'.$row['codtipoentidades'].'</td>
                            <td>'.$row['descripcion'].'</td>
                           </tr>';
	    	}
			$date=[
				'titulo'=>'Grupo de impresión',
				'titulopagina'=>'Grupo de impresión',
				'tipoentidades' => $tabla
			];
	      	$js = ['0'=>'grupo.js'];
				$this->viewAdmin('grupoimpresion/index',$js,$date);
		}

		public function actualizarentidades(){
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
			       $entidad = $datos[1];
			       $predios .=$nroinscripcion.',';
			       $sql .="WHEN nroinscripcion = $nroinscripcion THEN $entidad ";
			   }
			   $i++;
			}
			$i = $i-2;
			$predios = substr($predios,0,-1);
			$resp = $this->grupo->actualizarentidades($sql,$predios);
			$arr = [
					'resp'=>$resp,
					'total'=> $i
				];
			echo json_encode($arr);
		}
	}
?>
