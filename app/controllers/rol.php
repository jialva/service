<?php
	class rol extends Controller{

		public function __construct(){
      if(Session::get('autenticado')){
			$this->functionModel = $this->model('funciones');
			$this->rolModel = $this->model('rolModelo');
			$this->menu();
      	}else{
       		$this->redireccionar();
      	}
		}

    public function index(){
		$date=[
			'titulo'=>'Roles',
			'titulotabla'=>'Roles',
			'url'=> 'rol',
			'modulo'=> 'Seguridad'
		];

		$fgrilla = [
				'0'=>"SELECT rol,idrol,estareg FROM rol",
				'1'=>"ROL",//HEAD DE TABLE
				'2'=>"300",//ANCHO DE CELDA
				'6'=>"",//WHERE
				'7'=>" ORDER BY idrol DESC",//ORDER BY
				'8'=>"rol ",//campos para buscar
				'9'=>"Editar/editar/idrol/success/fa fa-edit,Accesos/acceso/idrol/primary/fa fa-list,Eliminar/eliminar/idrol/warning/fa fa-remove", //BOTONES TITULO,FUNCION,ID,COL,ICON
				'10'=>10,//TOTAL DE REGISTROS POR PAGINA
			]; //SQL

      	$js = [
      		'0'=>'rol.js'
      	];
			$this->viewAdmin('rol/index',$fgrilla,$js,$date);
		}

		public function verdatos(){
			$id = $_POST['id'];
			$item = $this->functionModel->verregistro('rol','idrol',$id,'');
			$json = ['idrol'=>$id,
						'rol'=>trim(utf8_encode($item['rol']))
					];
			echo json_encode($json);
		}

		public function ingresar(){
			$idrol = $_POST['idrol'];
			$rol = $_POST['rol'];
			if($idrol==''){
				$data = [
							'rol'=>$rol,
							'estareg'=>1
						];
				$resp = $this->save($data,'rol');
			}else{
				$data = [
							'idrol'=>$idrol,
							'rol'=>$rol
						];
				$resp = $this->update($data,'rol');
			}
			echo $resp;
		}

		public function eliminar(){
			$data = [
				'idrol'=>$_POST['id']
			];
			echo $this->delete($data,'rol',$_POST['opcion']);
		}

		public function listaacceso(){
			$idrol = $_POST['idrol'];
			$rol = $this->rolModel->nombrerol($idrol);
			$datos = $this->rolModel->modulopadre();
			$cad = '<div class="panel-group accordion" id="accordion">';
			foreach ($datos as $row) {
				$cad .= '<div class="panel panel-white">

                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"  href="#'.$row['idmodulo'].'">
                                        <i class="icon-arrow"></i>'.$row['modulo'].'
                                    </a>
                                </h5>
                            </div>
                            <div id="'.$row['idmodulo'].'" class="panel-collapse collapse">';
                                $modulo = $this->rolModel->modulos($row['idmodulo']);
                                foreach ($modulo as $mod) {
                                	$seleccionar = $this->rolModel->seleccionar($mod['idmodulo'],$idrol);
                                	$checked ='';
                                	$checkver = '';
                                	$checkeditar = '';
                                	$checkcrear  = '';
                                	$checkeliminr = '';
                                	if(!empty($seleccionar)){
                                		$checked = 'checked';
                                		if($seleccionar['ver']==1){
                                			$checkver = 'checked';
                                		}
                                		if($seleccionar['editar']==1){
                                			$checkeditar = 'checked';
                                		}
                                		if($seleccionar['crear']==1){
                                			$checkcrear = 'checked';
                                		}
                                		if($seleccionar['eliminar']==1){
                                			$checkeliminr = 'checked';
                                		}
                                	}
                                	$cad .="<div class='panel-body'>
                                			<div class='col-lg-12'>                        				
					                            <input type='checkbox' class='grey checkbox-callback' ".$checked." onclick='daracceso(".$mod['idmodulo'].")' id='modulo".$mod['idmodulo']."'> ".$mod['modulo']."
					                            	<div class='col-lg-12'>
					                            		<input type='checkbox' ".$checkver." id='ver".$seleccionar['idpermiso']."' onclick='opcioncrud(".$seleccionar['idpermiso'].",1)'> Ver
					                            		<input type='checkbox' ".$checkeditar." id='editar".$seleccionar['idpermiso']."' onclick='opcioncrud(".$seleccionar['idpermiso'].",2)'> Editar
					                            		<input type='checkbox' ".$checkcrear." id='crear".$seleccionar['idpermiso']."' onclick='opcioncrud(".$seleccionar['idpermiso'].",3)'> Crear
					                            		<input type='checkbox' ".$checkeliminr." id='eliminar".$seleccionar['idpermiso']."' onclick='opcioncrud(".$seleccionar['idpermiso'].",4)'> Eliminar
					                            	</div>
					                        </div></div>";
                                }                           
                $cad .=	    	'</div>
                        </div>';
			}
			$cad .='</div>';
			$arr = array('cad'=>$cad,'nombre'=>$rol['rol']);
			echo json_encode($arr);	
		}

		public function daracceso(){
			$idrol = $_POST['idrol'];
			$idmodulo = $_POST['idmodulo'];
			$this->rolModel->daracceso($idrol,$idmodulo);
		}

		public function quitaracceso(){
			$idrol = $_POST['idrol'];
			$idmodulo = $_POST['idmodulo'];
			$this->rolModel->quitaracceso($idrol,$idmodulo);
		}

		public function opcioncrud(){
			$idpermiso = $_POST['idpermiso'];
			$opcion = $_POST['opcion'];
			$est = $_POST['est'];
			$crud = '';
			switch ($opcion) {
				case 1:$crud='ver';break;
				case 2:$crud='editar';break;
				case 3:$crud='crear';break;
				case 4:$crud='eliminar';break;
			}
			$data = [
						'idpermiso'=>$idpermiso,
						$crud=>$est
					];
			$resp = $this->update($data,'permisos');
			echo $resp;
		}
	}
?>