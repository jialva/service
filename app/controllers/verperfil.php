<?php
	class verperfil extends Controller{

		public function __construct(){
      if(Session::get('autenticado')){
			$this->functionModel = $this->model('funciones');
			$this->menu();
      	}else{
       		$this->redireccionar();
      	}
		}

    public function index(){
		$edificio = $this->select('edificio','nombre_edificio','idedificio',1,'',Session::get('idedificio'));
		$rol = $this->functionModel->verregistro('rol','idrol',Session::get('idrol'),'');
		$datos = $this->functionModel->verregistro('usuario','idusuario',Session::get('idusuario'),'');
		$date=[
			'titulo'=>'Datos de perfil',
			'titulotabla'=>'',
			'edificio'=>$edificio,
			'rol'=>$rol['rol'],
			'nombre'=>$datos['nombre'],
			'apellido'=>$datos['apellido'],
			'email'=>$datos['email'],
			'telefono'=>$datos['telefono'],
			'usuario'=>$datos['usuario']
		];
		$grilla = [
			'tabla'=>'',
			'idtabla'=>'',
			'inner'=>false,
			'left'=>false,
			'where'=>'',
			'campos'=>'',
			'nombrecolumna'=>'',
			'totalrecord'=>0,
			'orden'=>'',
			'botones'=>'',
			'url'=>'inicio',
			'modulo'=>'inicio'
		];
      	$js = ['0'=>'verperfil.js'];
			$this->viewAdmin('verperfil/index',$grilla,$js,$date);
		}
	}
?>
