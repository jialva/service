<?php
    require_once $_SERVER['DOCUMENT_ROOT'].BASE_URL.'library/vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
                    $fecha = $this->fechaEs($items['fechareg']);
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
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $codsuc = $_POST['codsuc'];
            $codciclo = $_POST['codciclo'];
            $anio = $_POST['anio'];
            $mes = $_POST['mes'];+
            $fila = 2;
            $sqltarifa = $this->lecturas->tarifario($codsuc);
            $tarifa = [];
            foreach ($sqltarifa as $row) {
                $tarifa[$row['catetar']]= $row['volumenesp'];
            }
            $codestados = ['0'=>0,'1'=>3,'2'=>5,'3'=>6,'4'=>13,'5'=>14,'6'=>19,'7'=>25,'8'=>30,'9'=>44,'10'=>46,'11'=>50,'12'=>52,'13'=>53,'14'=>54,'15'=>55,'16'=>58,'17'=>61,'18'=>62,'19'=>63,'20'=>64,'21'=>65,
                            '22'=>68,'23'=>70,'24'=>71,'25'=>72,'26'=>77,'27'=>86,'28'=>102,'29'=>103,'30'=>105,'31'=>120,'32'=>122,'33'=>126,'34'=>128,'35'=>130];
            $sheet->setCellValue('A1', 'Items');
            $sheet->setCellValue('B1', 'Nro Inscripcion');
            $sheet->setCellValue('C1', 'Observacion');
            for($i=0;$i<count($codestados);++$i){
                $items = $this->lecturas->lecturas($codciclo,$anio,$mes,$codestados[$i]);
                foreach($items as $row){
                    switch(intval($codestados[$i])){
                        ////////////////////////LECTURA NORMAL/////////////////////////////////////////////
                        case 0:
                            $consumobajo='';$atipico='';
                            if($row['consumo']>0){
                                if($row['consumo']>99900){
                                    $sheet->setCellValue('A'.$fila, ($fila-1));
                                    $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                    $sheet->setCellValue('C'.$fila, 'El Consumo es '.$row['consumo'].' se recomienda validar, de ser erronea cambiar a obs. 105');
                                    $fila++; 
                                }else{
                                    $consumobajo = $this->consumobajo($row['consumo'],$row['lecturapromedio']);                                   
                                    if($consumobajo===0){
                                        $atipico = $this->atipico($row['catetar'],$row['consumo'],$row['lecturapromedio'],$tarifa[$row['catetar']]);
                                        if($atipico!=0){
                                            $sheet->setCellValue('A'.$fila, ($fila-1));
                                            $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                            $sheet->setCellValue('C'.$fila, 'Consumo de '.$row['consumo'].', se recomienda cambiar a atipico');
                                            $fila++; 
                                        }                                        
                                    }else{
                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                        $sheet->setCellValue('C'.$fila, 'Consumo bajo en relacion al promedio');
                                        $fila++; 
                                    }
                                }                                  
                            }else{
                                if($row['consumo']==0){
                                    $sheet->setCellValue('A'.$fila, ($fila-1));
                                    $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                    $sheet->setCellValue('C'.$fila, 'Consumo 0, se recomienda cambiar a obs. 50');
                                    $fila++; 
                                }else{
                                    $sheet->setCellValue('A'.$fila, ($fila-1));
                                    $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                    $sheet->setCellValue('C'.$fila, 'Consumo negativo se recomienda cambiar a obs. 105');
                                    $fila++; 
                                }
                                
                            }                                                   
                        break;
                        ////////////////////////LECTURA NO INRGREADA///////////////////////////////////////
                        case 3:
                            $sheet->setCellValue('A'.$fila, $row['nroinscripcion']);
                            $sheet->setCellValue('B'.$fila, 'No se ingreso lectura');
                            $fila++; 
                        break;
                        ////////////////////////MEDIDOR EN CAJA PROFUNDA//////////////////////////////////
                        case 5:
                            if($row['consumo']>0){
                                if($row['consumo']>99900){
                                    $sheet->setCellValue('A'.$fila, ($fila-1));
                                    $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                    $sheet->setCellValue('C'.$fila, 'El Consumo es '.$row['consumo'].' se recomienda validar, de ser erronea cambiar a obs. 105');
                                    $fila++;
                                }else{
                                    $consumobajo = $this->consumobajo($row['consumo'],$row['lecturapromedio']);
                                    if($consumobajo==0){
                                        $atipico = $this->atipico($row['catetar'],$row['consumo'],$row['lecturapromedio'],$tarifa[$row['catetar']]);
                                        if($atipico!=0){
                                            $sheet->setCellValue('A'.$fila, ($fila-1));
                                            $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                            $sheet->setCellValue('C'.$fila, 'Consumo de '.$row['consumo'].', se recomienda cambiar a atipico');
                                            $fila++;
                                        }else{
                                            $sheet->setCellValue('A'.$fila, ($fila-1));
                                            $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                            $sheet->setCellValue('C'.$fila, 'Tiene un consumo de '.$row['consumo'].', se recomiendo cambiar a obs. 0');
                                            $fila++;
                                        }                                     
                                    }else{
                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                        $sheet->setCellValue('C'.$fila, 'Consumo bajo en relacion al promedio');
                                        $fila++;
                                    }
                                }                                    
                            }else{
                                if($row['consumo']==0){
                                    $sheet->setCellValue('A'.$fila, ($fila-1));
                                    $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                    $sheet->setCellValue('C'.$fila, 'Consumo 0, se recomienda cambiar a obs. 50');
                                    $fila++;
                                }else{
                                    $sheet->setCellValue('A'.$fila, ($fila-1));
                                    $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                    $sheet->setCellValue('C'.$fila, 'Consumo negativo se recomienda cambiar a obs. 105');
                                    $fila++;
                                }                                    
                            }                                                       
                        break;
                        ////////////////////////MEDIDOR MANIPULADO///////////////////////////////////////
                        case 6:
                            $sheet->setCellValue('A'.$fila, $row['nroinscripcion']);
                            $sheet->setCellValue('B'.$fila, 'Se promediara por estar manipulado');
                            $fila++; 
                        break;
                        ////////////////////////MEDIDOR ENTERRADO///////////////////////////////////////
                        case 13:
                            if($row['lecturaultima']!=0){
                                $sheet->setCellValue('A'.$fila, $row['nroinscripcion']);
                                if($row['consumo']>0){
                                    if($row['consumo']>99900){
                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                        $sheet->setCellValue('C'.$fila, 'El Consumo es '.$row['consumo'].' se recomienda validar, de ser erronea cambiar a obs. 105, ignorar obs. 13');
                                        $fila++;
                                    }else{
                                        $consumobajo = $this->consumobajo($row['consumo'],$row['lecturapromedio']);
                                        if($consumobajo==0){
                                            $atipico = $this->atipico($row['catetar'],$row['consumo'],$row['lecturapromedio'],$tarifa[$row['catetar']]);
                                            if($atipico!=0){
                                                $sheet->setCellValue('A'.$fila, ($fila-1));
                                                $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                $sheet->setCellValue('C'.$fila, 'Consumo de '.$row['consumo'].', se recomienda cambiar a atipico, ignorar obs. 13');
                                                $fila++;
                                            }else{
                                                $sheet->setCellValue('A'.$fila, ($fila-1));
                                                $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                $sheet->setCellValue('C'.$fila, 'Tiene un consumo de '.$row['consumo'].', se recomiendo cambiar a obs. 0, ignorar obs. 13');
                                                $fila++;
                                            }                                     
                                        }else{
                                            $sheet->setCellValue('A'.$fila, ($fila-1));
                                            $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                            $sheet->setCellValue('C'.$fila, 'Consumo bajo en relacion al promedio, ignorar obs. 13');
                                            $fila++;
                                        }
                                    }                                    
                                }else{
                                    if($row['consumo']==0){
                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                        $sheet->setCellValue('C'.$fila, 'Consumo 0, se recomienda cambiar a obs. 50, ignorar obs. 13');
                                        $fila++;
                                    }else{
                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                        $sheet->setCellValue('C'.$fila, 'Consumo negativo se recomienda cambiar a obs. 105, ignorar obs. 13');
                                        $fila++;
                                    }                                    
                                }                                
                            }                                                   
                        break;
                    }                    
                }                
            }
            if($fila>2){
                $writer = new Xlsx($spreadsheet);
                $writer->save('critica.xlsx');
            }
            echo $fila;          
        }

        public function consumobajo($consumo,$promedio){
            $valida = $promedio*0.6;
            if($consumo<$valida){
                return 'Bajo';
            }else{
                return 0;
            }
        }

        public function atipico($catetar,$consumo,$promedio,$asignado){
            $res = 0;
            if($catetar==1 || $catetar==2){
                if($consumo>(2*$promedio)){
                    if($consumo>=(2*$asignado)){
                        $res = 'Atipico';
                    }
                }
            }
            return $res;
        }
	}
?>
