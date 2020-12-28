<?php
	class validar_usuario extends Controller{

		public function __construct(){
			$this->validarModel = $this->model('validar_usuarioModelo');
		}

		public function index(){
		}

		public function validar(){
			$usuario = strtoupper($_POST['usuario']);
			$password = $_POST['password'];
			$datos = $this->validarModel->validardatos(trim($usuario));
			$pass = strtoupper(trim($this->encriptar($password)));
			if(!empty($datos)){
				if($pass === strtoupper($datos['contra'])){
					Session::set('autenticado',true);
					Session::set('usuario',$datos['login']);
					$data['mensaje'] ='Ingresando al sistema';
					$data['res']=1;
				}else{
					$data['mensaje'] ='La clave es incorrecta';
					$data['res']=2;
				}
			}else{
				$data['mensaje'] ='El usuario ingresado no existe';
				$data['res']=3;
			}
			echo json_encode($data);
		}

		public function salir(){
			Session_destroy();
			$this->redireccionar('salir');
		}
	}
?>
