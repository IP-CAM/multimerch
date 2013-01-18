<?php

class MsLoader {
   	public function __construct($registry) {
		$this->registry = $registry;		
		spl_autoload_register(array('MsLoader', '_autoloadLibrary'));
		spl_autoload_register(array('MsLoader', '_autoloadController'));
   	}

	public function __get($class) {
		if (!isset($this->$class)){
			$this->$class = new $class($this->registry);
		}

		return $this->$class;		
	}

	/*
	public function __set($class) {
		$this->$class = new $class($this->registry);
		return $this->$class;		
	}
	*/
	private static function _autoloadLibrary($class) {
	    $file = DIR_SYSTEM . 'library/' . strtolower($class) . '.php';
	    if (file_exists($file)) {
	    	$vqmod = new VQMod();
			require_once($vqmod->modCheck($file));
	    }
	}

	private static function _autoloadController($class) {
		preg_match_all('/((?:^|[A-Z])[a-z]+)/',$class,$matches);
		
		if (isset($matches[0][1]) && isset($matches[0][2])) {
		    $file = DIR_APPLICATION . 'controller/' . strtolower($matches[0][1]) . '/' . strtolower($matches[0][2]) . '.php';
		    if (file_exists($file)) {
		    	$vqmod = new VQMod();
				require_once($vqmod->modCheck($file));
		    }
		}
	}
/*
	public function get($class) {
		if (!isset($this->$class)){
			$this->$class = new $class($this->registry);
		}

		return $this->$class;		
   	}

	public function create($class) {
		return new $class($this->registry);
   	}
   */
}

?>
