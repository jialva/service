<?php
	class user extends Controller{

		public function __construct(){
	      if(Session::get('autenticado')){
				$this->functionModel = $this->model('funciones');
				$this->menu();
	      	}else{
	       		$this->redireccionar();
	      	}
			}

	    public function index(){
	    	$rol = $this->select('rol','rol','idrol',1,'');
	    	
			$date=[
				'titulo'=>'Administrar Usuarios',
				'titulotabla'=>'Usuarios',
				'select'=> $rol,
				'url'=> 'user',
				'modulo'=> 'Seguridad'
			];

			$fgrilla = [
				'0'=>"SELECT u.nombre, u.apellido, r.rol, u.idusuario, u.estareg FROM usuario u INNER JOIN rol r ON u.idrol=r.idrol",
				'1'=>"NOMBRE,APELLIDO,ROL",//HEAD DE TABLE
				'2'=>"90,90,50",//ANCHO DE CELDA
				'6'=>" WHERE u.idrol!=2",//WHERE
				'7'=>" ORDER BY u.idusuario DESC",//ORDER BY
				'8'=>"u.nombre/u.apellido/r.rol/CONCAT(u.nombre, ' ',u.apellido) ",//campos para buscar
				'9'=>"Editar/editar/idusuario/success/fa fa-edit,Eliminar/eliminar/idusuario/warning/fa fa-remove", //BOTONES TITULO,FUNCION,ID,COL,ICON
				'10'=>10,//TOTAL DE REGISTROS POR PAGINA
			]; //SQL

	      	$js = [
	      		'0'=>'user.js'
	      	];
				$this->viewAdmin('user/index',$fgrilla,$js,$date);
		}

		public function ingresar(){
			$idusuario = $_POST['idusuario'];
			$nombre = trim($_POST['nombre']);
			$apellido = trim($_POST['apellido']);
			$usuario = trim($_POST['usuario']);
			$password = trim($_POST['password']);
			$idrol = $_POST['idrol'];
			$x = null;
			if($idusuario==''){
				$x = $this->functionModel->existe($usuario,'usuario','usuario');
			}
			if(empty($x)){
				if($idusuario==''){
					$data = [
							'nombre'=>$nombre,
							'apellido'=>$apellido,
							'usuario'=>$usuario,
							'password'=>password_hash($password, PASSWORD_DEFAULT),
							'idrol'=>$idrol,
							'estareg'=>1
						];
					$resp = $this->save($data,'usuario');
				}else{
					$data = [
							'idusuario'=>$idusuario,
							'nombre'=>$nombre,
							'apellido'=>$apellido,
							'idrol'=>$idrol
						];
					$resp = $this->update($data,'usuario');
				}
			}else{
				$resp=3;
			}
			echo $resp;
		}

		public function verdatos(){
			$id = $_POST['id'];
			$item = $this->functionModel->verregistro('usuario','idusuario',$id,'');
			$json = ['idusuario'=>$id,
						'nombre'=>trim(utf8_encode($item['nombre'])),
						'apellido'=>trim(utf8_encode($item['apellido'])),
						'usuario'=>trim(utf8_encode($item['usuario'])),
						'idrol'=>$item['idrol']
					];
			echo json_encode($json);
		}

		public function eliminar(){
			$data = [
				'idusuario'=>$_POST['id']
			];
			echo $this->delete($data,'usuario',$_POST['opcion']);
		}
	}
?>