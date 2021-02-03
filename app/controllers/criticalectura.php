<?php
	class criticalectura extends Controller{
		public function __construct(){
	      if(Session::get('autenticado')){
				$this->lecturas = $this->model('lecturasModelo');
				//$this->menu();

	      	}else{
	       		$this->redireccionar();
	      	}
		}

	    public function index(){
	    	$ciclos = $this->lecturas->ciclos();
            $tabla = '';
            $anio = date('Y');
            $mes = intval(date('m'));
	    	foreach ($ciclos as $row) {
                $items = $this->lecturas->resumenlecturas($row['codciclo'],$anio,$mes);
                $fecha = 'No generado';
                $leidos = 0;
                $promedios = 0;
                $digitados = 0;
                $total = 0;
                if(!empty($items['fechareg'])){
                    $fecha = $this->fechaIn($items['fechareg']);
                    $leidos = $items['leidos'];
                    $promedios = $items['promedios'];
                    $digitados = $items['digitados'];
                    $total = $items['total'];
                }
                $tabla .= '<tr class="fila" style="border-bottom: 1px solid #000000;">
                            <td>'.$row['descripcion'].'</td>
                            <td>'.$fecha.'</td>
                            <td>'.$leidos.'</td>
                            <td>'.$promedios.'</td>
                            <td>'.$digitados.'</td>
                            <td>'.$total.'</td>
                            <td><button class="btn btn-success btn-xs" onclick="criticar(\''.$row['codsuc'].'\',\''.$row['codciclo'].'\',\''.$anio.'\',\''.$mes.'\')"><i class="icon-check"></i></button></td>
                        </tr>';
	    	}
			$date=[
				'titulo'=>'Lecturas',
                'titulopagina'=>'Crítica de Lecturas',
                'periodo'=>$this->mestexto(intval(date('m'))).'-'.date('Y'),
				'ciclos' => $tabla
			];
	      	$js = ['0'=>'lecturas.js'];
				$this->viewAdmin('criticalectura/index',$js,$date);
        }
        
        public function criticar(){
            $codsuc = $_POST['codsuc'];
            $codciclo = $_POST['codciclo'];
            $anio = $_POST['anio'];
            $mes = $_POST['mes'];
            $sqltarifa = $this->lecturas->tarifario($codsuc);
            $tarifa = [];
            foreach ($sqltarifa as $row) {
                $tarifa[$row['catetar']]= $row['volumenesp'];
            }
            $codestados = ['0'=>0,'1'=>3,'2'=>5,'3'=>6,'4'=>13,'5'=>14,'6'=>19,'7'=>25,'8'=>30,'9'=>44,'10'=>46,'11'=>50,'12'=>52,'13'=>53,'14'=>54,'15'=>55,'16'=>58,'17'=>61,'18'=>62,'19'=>63,'20'=>64,'21'=>65,
                            '22'=>68,'23'=>70,'24'=>71,'25'=>72,'26'=>77,'27'=>86,'28'=>102,'29'=>103,'30'=>105,'31'=>120,'32'=>122,'33'=>126,'34'=>128,'35'=>130];
            for($i=0;$i<count($codestados);++$i){
                $items = $this->lecturas->lecturas($codciclo,$anio,$mes,$codestados[$i]);
                foreach($items as $row){
                    switch($codestados){
                        case 0:$consumobajo='';$atipico='';
                            $consumobajo = $this->consumobajo($row['consumo'],$row['lecturapromedio']);
                            if($cb==0){
                                $atipico = $this->atipico($row['catetar'],$row['consumo'],$promedio,$tarifa[$row['catetar']]);
                            }
                        break;
                        case 3:$noingresado='No se ingreso lectura';break;
                    }
                }                
            }
        }

        public function consumobajo($consumo,$promedio){
            $valida = $promedio*0.6;
            if($consumo<$valida){
                echo 'Consumo Bajo';
            }else{
                echo 0;
            }
        }

        public function atipico($catetar,$consumo,$promedio,$asignado){
            $res = 0;
            if($catetar==1 || $catetar==2){
                if($consumo>(2*$promedio)){
                    if($consumo>=(2*$asignado)){
                        $res = 'Atípico';
                    }
                }
            }
            echo $res;
        }
	}
?>
