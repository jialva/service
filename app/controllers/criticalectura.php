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
            $sheet->setCellValue('D1', 'Descuento');
            for($i=0;$i<count($codestados);++$i){
                $items = $this->lecturas->lecturas($codciclo,$anio,$mes,$codestados[$i]);                
                foreach($items as $row){
                    if($codestados[$i]==3 || $codestados[$i]==6){
                        if($codestados[$i]==3){//NO INGRESA LECTURA U OBSERVACION
                            $sheet->setCellValue('A'.$fila, ($fila-1));
                            $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                            $sheet->setCellValue('C'.$fila, 'No se ingreso lectura o observacion');
                            $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                            $sheet->setCellValue('D'.$fila, $descuento);
                            $fila++; 
                        }else{
                            if($codestados[$i]==6){//MEDIDOR MANIPULADO
                                $sheet->setCellValue('A'.$fila, ($fila-1));
                                $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                $sheet->setCellValue('C'.$fila, 'Se promediará por estar manipulado');
                                $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                $sheet->setCellValue('D'.$fila, $descuento);
                                $fila++; 
                            }
                        }                                                
                    }else{
                        if($codestados[$i]==0 || $codestados[$i]==19 || $codestados[$i]==25 || $codestados[$i]==64){//LECTURA NORMAL/////
                            if($row['consumo']>0){
                                if($row['consumo']>99900){
                                    $sheet->setCellValue('A'.$fila, ($fila-1));
                                    $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                    $sheet->setCellValue('C'.$fila, 'El Consumo es '.$row['consumo'].' se recomienda validar, de ser erronea cambiar a obs. 105');
                                    $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                    $sheet->setCellValue('D'.$fila, $descuento);
                                    $fila++; 
                                }else{
                                    $consumobajo = $this->consumobajo($row['consumo'],$row['lecturapromedio']);                                   
                                    if($consumobajo===0){
                                        $atipico = $this->atipico($row['codciclo'],$row['catetar'],$row['consumo'],$row['lecturapromedio'],$tarifa[$row['catetar']]);
                                        if($atipico!=0){
                                            $sheet->setCellValue('A'.$fila, ($fila-1));
                                            $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                            $sheet->setCellValue('C'.$fila, 'Consumo de '.$row['consumo'].', se recomienda cambiar a atipico');
                                            $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                            $sheet->setCellValue('D'.$fila, $descuento);
                                            $fila++; 
                                        }                                        
                                    }else{
                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                        $sheet->setCellValue('C'.$fila, 'Consumo bajo ('.$row['consumo'].') en relacion al promedio ('.$row['lecturapromedio'].')');
                                        $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                        $sheet->setCellValue('D'.$fila, $descuento);
                                        $fila++; 
                                    }
                                }                                  
                            }else{
                                if($row['consumo']==0){
                                    if($codestados[$i]!=64){
                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                        $sheet->setCellValue('C'.$fila, 'Consumo 0, se recomienda cambiar a obs. 50');
                                        $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                        $sheet->setCellValue('D'.$fila, $descuento);
                                        $fila++;
                                    }                                     
                                }else{
                                    $sheet->setCellValue('A'.$fila, ($fila-1));
                                    $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                    $sheet->setCellValue('C'.$fila, 'Consumo negativo se recomienda cambiar a obs. 105, ignorar obs. '.$codestados[$i]);
                                    $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                    $sheet->setCellValue('D'.$fila, $descuento);
                                    $fila++; 
                                }
                                
                            }   
                        }else{
                            if($codestados[$i]==50 || $codestados[$i]==68 || $codestados[$i]==71 || $codestados[$i]==72 || $codestados[$i]==126){//CONSUMO CERO////
                                if($row['consumo']>0){
                                    if($row['consumo']>99900){
                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                        $sheet->setCellValue('C'.$fila, 'El Consumo es '.$row['consumo'].' se recomienda validar, de ser erronea cambiar a obs. 105');
                                        $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                        $sheet->setCellValue('D'.$fila, $descuento);
                                        $fila++; 
                                    }else{
                                        $consumobajo = $this->consumobajo($row['consumo'],$row['lecturapromedio']);                                  
                                        if($consumobajo===0){
                                            $atipico = $this->atipico($row['codciclo'],$row['catetar'],$row['consumo'],$row['lecturapromedio'],$tarifa[$row['catetar']]);
                                            if($atipico!=0){
                                                $sheet->setCellValue('A'.$fila, ($fila-1));
                                                $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                $sheet->setCellValue('C'.$fila, 'Consumo de '.$row['consumo'].', se recomienda cambiar a atipico');
                                                $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                $sheet->setCellValue('D'.$fila, $descuento);
                                                $fila++; 
                                            }else{
                                                $sheet->setCellValue('A'.$fila, ($fila-1));
                                                $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                $sheet->setCellValue('C'.$fila, 'Tiene un consumo de '.$row['consumo'].' se recomienda cambiar a obs. 0, ignorar obs. '. $codestados[$i]);
                                                $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                $sheet->setCellValue('D'.$fila, $descuento);
                                                $fila++; 
                                            }                                     
                                        }else{
                                            $sheet->setCellValue('A'.$fila, ($fila-1));
                                            $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                            $sheet->setCellValue('C'.$fila, 'Consumo bajo ('.$row['consumo'].') en relacion al promedio ('.$row['lecturapromedio'].')');
                                            $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                            $sheet->setCellValue('D'.$fila, $descuento);
                                            $fila++; 
                                        }
                                    }                                  
                                }else{
                                    if($row['consumo']<0){
                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                        $sheet->setCellValue('C'.$fila, 'Consumo negativo se recomienda cambiar a obs. 105, ignorar obs. '.$codestados[$i]);
                                        $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                        $sheet->setCellValue('D'.$fila, $descuento);
                                        $fila++; 
                                    }                               
                                }
                            }else{
                                if($codestados[$i]==5 || $codestados[$i]==13 || $codestados[$i]==14 || $codestados[$i]==30 || $codestados[$i]==46 || $codestados[$i]==52 || $codestados[$i]==53 || $codestados[$i]==54 || $codestados[$i]==55 || $codestados[$i]==58 || $codestados[$i]==61 || $codestados[$i]==62 || $codestados[$i]==63 || $codestados[$i]==102){//LECTURA IGUAL 0//
                                    if($row['lecturaultima']!=0){
                                        if($row['consumo']>0){
                                            if($row['consumo']>99900){
                                                $sheet->setCellValue('A'.$fila, ($fila-1));
                                                $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                $sheet->setCellValue('C'.$fila, 'El Consumo es '.$row['consumo'].' se recomienda validar, de ser erronea cambiar a obs. 105, ignorar obs. '.$codestados[$i]);
                                                $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                $sheet->setCellValue('D'.$fila, $descuento);
                                                $fila++;
                                            }else{
                                                $consumobajo = $this->consumobajo($row['consumo'],$row['lecturapromedio']);
                                                if($consumobajo===0){
                                                    $atipico = $this->atipico($row['codciclo'],$row['catetar'],$row['consumo'],$row['lecturapromedio'],$tarifa[$row['catetar']]);
                                                    if($atipico!=0){
                                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                        $sheet->setCellValue('C'.$fila, 'Consumo de '.$row['consumo'].', se recomienda cambiar a atipico, ignorar obs. '.$codestados[$i]);
                                                        $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                        $sheet->setCellValue('D'.$fila, $descuento);
                                                        $fila++;
                                                    }else{
                                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                        $sheet->setCellValue('C'.$fila, 'Tiene un consumo de '.$row['consumo'].', se recomiendo cambiar a obs. 0, ignorar obs. '.$codestados[$i]);
                                                        $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                        $sheet->setCellValue('D'.$fila, $descuento);
                                                        $fila++;
                                                    }                                     
                                                }else{
                                                    $sheet->setCellValue('A'.$fila, ($fila-1));
                                                    $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                    $sheet->setCellValue('C'.$fila, 'Consumo bajo ('.$row['consumo'].') en relacion al promedio ('.$row['lecturapromedio'].'), ignorar obs. '.$codestados[$i]);
                                                    $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                    $sheet->setCellValue('D'.$fila, $descuento);
                                                    $fila++;
                                                }
                                            }                                    
                                        }else{
                                            if($row['consumo']==0){
                                                $sheet->setCellValue('A'.$fila, ($fila-1));
                                                $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                $sheet->setCellValue('C'.$fila, 'Consumo 0, se recomienda cambiar a obs. 50, ignorar obs. '.$codestados[$i]);
                                                $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                        $sheet->setCellValue('D'.$fila, $descuento);
                                                $fila++;
                                            }else{
                                                $sheet->setCellValue('A'.$fila, ($fila-1));
                                                $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                $sheet->setCellValue('C'.$fila, 'Consumo negativo se recomienda cambiar a obs. 105, ignorar obs. '.$codestados[$i]);
                                                $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                        $sheet->setCellValue('D'.$fila, $descuento);
                                                $fila++;
                                            }                                    
                                        }                                
                                    }
                                }else{
                                    if($codestados[$i]==44 || $codestados[$i]==120 || $codestados[$i]==70){
                                        if($row['consumo']>0){
                                            if($row['consumo']>99900){
                                                $sheet->setCellValue('A'.$fila, ($fila-1));
                                                $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                $sheet->setCellValue('C'.$fila, 'El Consumo es '.$row['consumo'].' se recomienda validar, de ser erronea cambiar a obs. 105, ignorar obs. '.$codestados[$i]);
                                                $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                $sheet->setCellValue('D'.$fila, $descuento);
                                                $fila++;
                                            }else{
                                                $consumobajo = $this->consumobajo($row['consumo'],$row['lecturapromedio']);
                                                if($consumobajo===0){
                                                    $atipico = $this->atipico($row['codciclo'],$row['catetar'],$row['consumo'],$row['lecturapromedio'],$tarifa[$row['catetar']]);
                                                    if($atipico!=0){
                                                        if($codestados[$i]==120){
                                                            $sheet->setCellValue('A'.$fila, ($fila-1));
                                                            $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                            $sheet->setCellValue('C'.$fila, 'No cumple los críterios');
                                                            $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                            $sheet->setCellValue('D'.$fila, $descuento);
                                                            $fila++; 
                                                        }                     
                                                    }                                  
                                                }else{
                                                    $sheet->setCellValue('A'.$fila, ($fila-1));
                                                    $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                    $sheet->setCellValue('C'.$fila, 'Consumo bajo ('.$row['consumo'].') en relacion al promedio ('.$row['lecturapromedio'].'), ignorar obs. '.$codestados[$i]);
                                                    $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                    $sheet->setCellValue('D'.$fila, $descuento);
                                                    $fila++;
                                                }
                                            }                                    
                                        }else{
                                            if($row['consumo']==0){
                                                $sheet->setCellValue('A'.$fila, ($fila-1));
                                                $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                $sheet->setCellValue('C'.$fila, 'Consumo 0, se recomienda cambiar a obs. 50, ignorar obs. '.$codestados[$i]);
                                                $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                        $sheet->setCellValue('D'.$fila, $descuento);
                                                $fila++;
                                            }else{
                                                $sheet->setCellValue('A'.$fila, ($fila-1));
                                                $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                $sheet->setCellValue('C'.$fila, 'Consumo negativo se recomienda cambiar a obs. 105, ignorar obs. '.$codestados[$i]);
                                                $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                        $sheet->setCellValue('D'.$fila, $descuento);
                                                $fila++;
                                            }                                    
                                        }
                                    }else{
                                        if($codestados[$i]==105){
                                            if($row['consumo']>=0 && $row['consumo']<99900){
                                                $consumobajo = $this->consumobajo($row['consumo'],$row['lecturapromedio']);
                                                if($consumobajo===0){
                                                    $atipico = $this->atipico($row['codciclo'],$row['catetar'],$row['consumo'],$row['lecturapromedio'],$tarifa[$row['catetar']]);
                                                    if($atipico!=0){
                                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                        $sheet->setCellValue('C'.$fila, 'Consumo de '.$row['consumo'].', se recomienda cambiar a atipico, ignorar obs. '.$codestados[$i]);
                                                        $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                        $sheet->setCellValue('D'.$fila, $descuento);
                                                        $fila++;
                                                    }else{
                                                        $sheet->setCellValue('A'.$fila, ($fila-1));
                                                        $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                        $sheet->setCellValue('C'.$fila, 'Tiene un consumo de '.$row['consumo'].', se recomiendo cambiar a obs. 0, ignorar obs. '.$codestados[$i]);
                                                        $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                        $sheet->setCellValue('D'.$fila, $descuento);
                                                        $fila++;
                                                    }                                     
                                                }else{
                                                    $sheet->setCellValue('A'.$fila, ($fila-1));
                                                    $sheet->setCellValue('B'.$fila, $row['nroinscripcion']);
                                                    $sheet->setCellValue('C'.$fila, 'Consumo bajo ('.$row['consumo'].') en relacion al promedio ('.$row['lecturapromedio'].'), ignorar obs. '.$codestados[$i]);
                                                    $descuento = $this->descuento($row['nroinscripcion'],$anio,$mes);
                                                    $sheet->setCellValue('D'.$fila, $descuento);
                                                    $fila++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
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

        public function atipico($codciclo,$catetar,$consumo,$promedio,$asignado){
            $res = 0;
            if($codciclo!=21){
                if($catetar==1 || $catetar==2){
                    if($consumo>(2*$promedio)){
                        if($consumo>=(2*$asignado)){
                            $res = 'Atipico';
                        }
                    }
                }
            }
            return $res;
        }

        public function descuento($nroinscripcion,$anio,$mes){
            $descuento = $this->lecturas->buscardescuento($nroinscripcion,$anio,$mes);
            if(empty($descuento)){
                return 'No';
            }else{
                return 'Si';
            }
        }
	}
?>
