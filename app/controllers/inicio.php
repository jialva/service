<?php
	class inicio extends Controller{

		public function __construct(){
	      if(Session::get('autenticado')){
				//$this->functionModel = $this->model('fuction');
				//$this->menu();

	      	}else{
	       		$this->redireccionar();
	      	}
			}

	    public function index(){
			$date=[
				'titulo'=>'INICIO'
			];
	      	$js = ['0'=>'inicio.js'];
				$this->viewAdmin('inicio/index',$js,$date);
		}
	}
?>
