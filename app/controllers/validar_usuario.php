<?php
	class validar_usuario extends Controller{

		public function __construct(){
			$this->validarModel = $this->model('validar_usuarioModelo');
		}

		public function index(){
		}

		public function validar(){
			$usuario = strtoupper($_POST['usuario']);
			$password = trim($_POST['password']);
			$datos = $this->validarModel->validardatos(trim($usuario));
			$pass = strtoupper(trim($password));
			if(!empty($datos)){
				if($pass === $this->desencriptar($datos['contra'])){
					Session::set('autenticado',true);
					Session::set('usuario',$datos['login']);
					Session::set('nombre',$datos['nombres']);
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
