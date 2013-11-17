<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

	protected function _initIncludes() {
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace("MP_");
	}
	
	protected function _initAcl() {
		
	}

}

