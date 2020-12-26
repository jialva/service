<?php
	//error_reporting(0);
	class Core {
		protected $controller = 'index';
		protected $metod = 'index';
		protected $params = [];

		public function __construct(){
			$url = $this->getUrl();
			if(!empty($url[0])){
				if(file_exists('../app/controllers/'.$url[0].'.php')){
					$this->controller = $url[0];
					unset($url[0]);
				}
			}
			require_once '../app/controllers/'.$this->controller.'.php';
			$this->controller = new $this->controller;

			if(isset($url[1])){
				if(method_exists($this->controller, $url[1])){
					$this->metod = $url[1];
					unset($url[1]);
				}
			}

			$this->params = $url ? array_values($url) : [];

			call_user_func_array([$this->controller, $this->metod], $this->params);

			//echo $this->params;

		}

		public function getUrl(){
			//echo $_GET['url'];
			if(isset($_GET['url'])){
				$url = rtrim($_GET['url'],'/');
				$url = filter_var($url, FILTER_SANITIZE_URL);
				$url = explode('/', $url);
				return $url;
			}
		}
	}
?>
