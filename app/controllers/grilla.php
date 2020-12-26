<?php
class grilla extends Controller{
	public function __construct(){
      if(Session::get('autenticado')){
			$this->grillaModel = $this->model('grillaModelo');
      	}		
	}

	public function index(){}

	public function tabla(){
			$page = (int) (!isset($_REQUEST['pageId']) ? 1 :$_REQUEST['pageId']);
			$page = ($page == 0 ? 1 : $page);
			$recordsPerPage = $_POST['total'];
			$start = ($page-1) * $recordsPerPage;
			$limite = $start.','.$recordsPerPage;
			$busca ="";
			if($_POST['buscar']!=''){
				$grilla = '';
				if($_POST['where']==""){
					if($_POST['txtbuscar']!=""){
						$xbuscar = explode('/', $_POST['buscar']);
						$busca = " WHERE ";
						for ($k=0; $k < count($xbuscar); $k++) { 
							$busca .=$xbuscar[$k]." LIKE '%".$_POST['txtbuscar']."%' OR ";
						}
						$busca = substr($busca, 0,-3);
					}				
				}else{
					if($_POST['txtbuscar']!=""){
						$xbuscar = explode('/', $_POST['buscar']);
						$busca = " AND (";
						for ($k=0; $k < count($xbuscar); $k++) { 
							$busca .=$xbuscar[$k]." LIKE '%".$_POST['txtbuscar']."%' OR ";
						}
						$busca = substr($busca, 0,-3);
						$busca .=")";
					}
				}
			}
			
			$query= $this->grillaModel->total($_POST['sql'].$_POST['where'].$busca);
			$count = count($query);
			$adjacents = "2";
			$prev = $page - 1;
			$next = $page + 1;
			$lastpage = ceil($count/$recordsPerPage);
			$lpm1 = $lastpage - 1; 
			$pag = '<ul class="pagination pagination-blue margin-bottom-10" style="float:right">';
			
			 if ($lastpage < 6 + ($adjacents * 2)){
			 	for ($counter = 1; $counter <= $lastpage; $counter++){
			 		if ($counter == $page){
					 	$pag.= "<li class='disabled active'><a href='javascript:void(0)'>$counter</a></li>";
					 }else{
					 $pag.= "<li><a href='#Page=".($counter)."' onClick='changePagination(".($counter).");'>$counter</a></li>";
					}
			 	}
			 }else{
			 	//echo $lastpage.'-'.(($adjacents * 2));exit;
			 	if($lastpage > 5 + ($adjacents * 2)){
			 		//echo $page.'<'.(1+($adjacents * 2));exit;
				 	if($page < 1 + ($adjacents * 2)){
				 		for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					 		if($counter == $page){
					 			$pag.= "<li class='disabled active'><a href='javascript:void(0)'>$counter</a></li>";
					 		}else{
					 			$pag.= "<li><a href='#Page=".($counter)."' onClick='changePagination(".($counter).");'>$counter</a></li>";
							}
				 		}
					 	$pag.= "...";
					 	$pag.= "<li class='disabled active'><a href='#Page=".($lpm1)."' onClick='changePagination(".($lpm1).");'>$lpm1</a></li>";
					 	$pag.= "<li class='disabled active'><a href='#Page=".($lastpage)."' onClick='changePagination(".($lastpage).");'>$lastpage</a></li>"; 

				 	}else if($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
					 $pag.= "<li><a href='#Page=1' onClick='changePagination(1);'>1</a></li>";
					 $pag.= "<li><a href='#Page=2' onClick='changePagination(2);'>2</a></li>";
					 $pag.= "...";
					 for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
						 if($counter == $page){
						 	$pag.= "<li class='disabled active'><a href='javascript:void(0)'>$counter</li>";
						 }else{
						 	$pag.= "<li><a href='#Page=".($counter)."' onClick='changePagination(".($counter).");'>$counter</a></li>";
						}
					 }
					 $pag.= "..";
					 $pag.= "<li><a href='#Page=".($lpm1)."' onClick='changePagination(".($lpm1).");'>$lpm1</a></li>";
					 $pag.= "<li><a href='#Page=".($lastpage)."' onClick='changePagination(".($lastpage).");'>$lastpage</a></li>"; 
				 	}else{
						$pag.= "<li><a href='#Page=1' onClick='changePagination(1);'>1</a></li>";
						$pag.= "<li><a href='#Page=2' onClick='changePagination(2);'>2</a></li>";
						$pag.= "..";
						for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
							if($counter == $page){
								$pag.= "<li class='disabled active'>$counter</li>";
							}else{
								$pag.= "<li><a href='#Page=".($counter)."' onClick='changePagination(".($counter).");'>$counter</a></li>";
							} 
						}
					}
				}
			}
			$pag .= "</ul>";
			
			$datos = $this->grillaModel->registros($_POST['sql'].$_POST['where'].$busca.$_POST['order'],$limite);
			
			$grilla .= '<table class="table table-striped table-hover">';
			$columnas = explode(',', $_POST['columnas']);
			$ancho = explode(',', $_POST['ancho']);
			$grilla .='<thead>
                            <tr>';
            if(count($columnas)>0){
            	$grilla .= '<th width="15">ITEM</th>';
            }
            for ($i=0; $i <count($columnas) ; $i++) { 
            	$grilla .= '<th width="'.$ancho[$i].'">'.$columnas[$i].'</th>';
            }
            if($_POST['botones']!=''){
            	$grilla .= '<th width="10">OPCION</th>';
            }
            $grilla .='</tr>
                        </thead>
                        <tbody>';
            $c=1;
            $botones = explode(',', $_POST['botones']);
            if($page==1){
            	$au = 0;
            }else{
            	$au = $recordsPerPage;
            }
            
            foreach ($datos as $row) {
            	$grilla .= '<tr><td>'.($c+$au).'</td>'; //nro item
            	for ($i=0; $i <count($columnas) ; $i++) {
	            	$grilla .= '<td>'.$row[$i].'</td>'; //datos
	            }
	            $x='';
	            if(count($botones)>0){
	            	if($row['estareg']==1){
		            	for ($j=0; $j < count($botones); $j++) {
		            		$but = explode('/', $botones[$j]);
		            		$x .='<button class="btn btn-xs btn-'.$but[3].'" onclick="'.$but[1].'('.$row[$but[2]].')"><i class="'.$but[4].'"></i></button>&nbsp;';
		            	}
		            }else{
		            	$but = explode('/', $botones[0]);
		            	if($row['estareg']==0){
		            		$x .='<button class="btn btn-xs btn-warning" title="Restablecer" onclick="restablecer('.$row[$but[2]].')"><i class="fa fa-refresh"></i></button>&nbsp;';
		            		$x .='<button class="btn btn-xs btn-danger" title="Eliminar" onclick="borrar('.$row[$but[2]].')"><i class="fa fa-trash"></i></button>&nbsp;';
		            	}
		            }
		            	$grilla .= '<td>'.$x.'</td>';
	            }
	            
	            $grilla .='</tr>';
	            $c++;          	
            }
	            $grilla .='<tbody>
	            	</table>';
			echo $grilla.$pag;
	}
}
?>