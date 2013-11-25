<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

	protected function _initIncludes() {
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace("MP_");
		
		Zend_Controller_Front::getInstance()->registerPlugin(new MP_Controller_Plugin_Acl());
	}
	
	protected function _initRoutes() {
		$front = Zend_Controller_Front::getInstance();
		$router = $front->getRouter();
		
		$router->addRoute(
				"my-account",
				new Zend_Controller_Router_Route("/my-account", array(
						"module" => "default",
						"controller" => "user",
						"action" => "index"
						))
				);
		
		$router->addRoute(
				"experiments",
				new Zend_Controller_Router_Route("/experiments", array(
						"module" => "default",
						"controller" => "experiment",
						"action" => "index"
						))
				);
		
		$router->addRoute(
				"logout",
				new Zend_Controller_Router_Route("/logout", array(
						"module" => "default",
						"controller" => "user",
						"action" => "logout"
						))
				);
		
		$router->addRoute(
				"login",
				new Zend_Controller_Router_Route("/login", array(
						"module" => "default",
						"controller" => "user",
						"action" => "login"
						))
				);
		
		$router->addRoute(
				"microscopes",
				new Zend_Controller_Router_Route("/microscopes", array(
						"module" => "default",
						"controller" => "microscope",
						"action" => "index"
				))
		);
	}
	
	protected function _initAcl() {
		$acl = Zend_Controller_Front::getInstance()->getPlugin("MP_Controller_Plugin_Acl")->getAcl();
		
		// registrace zdroju
		$acl->addResource(new Zend_Acl_Resource("index"));
		$acl->addResource(new Zend_Acl_Resource("error"));
		$acl->addResource(new Zend_Acl_Resource("user"));
		$acl->addResource(new Zend_Acl_Resource("experiment"));
		$acl->addResource(new Zend_Acl_Resource("microscope"));
		
		// povoleni akci hostovi
		$acl->allow(MP_Role::ROLE_GUEST, "index");
		$acl->allow(MP_Role::ROLE_GUEST, "error");
		$acl->allow(MP_Role::ROLE_GUEST, "user", "login");
		
		// povoleni akci uzivateli
		$acl->deny(MP_Role::ROLE_USER, "user", "login");
		$acl->allow(MP_Role::ROLE_USER, "user", array("index", "logout"));
		
		// povoleni akci operatorovi
		
		// povoleni akci adminovi
		$acl->allow(MP_Role::ROLE_ADMIN, "index");
		$acl->allow(MP_Role::ROLE_ADMIN, "error");
		$acl->allow(MP_Role::ROLE_ADMIN, "user");
		$acl->allow(MP_Role::ROLE_ADMIN, "experiment");
		$acl->allow(MP_Role::ROLE_ADMIN, "microscope");
	}
	
	protected function _initNavigation() {
		// inicializace pohledu
		$this->bootstrap("view");
		$view = $this->getResource("view");
		
		// nacteni ACL
		$acl = Zend_Controller_Front::getInstance()->getPlugin("MP_Controller_Plugin_Acl")->getAcl();
		
		// nacteni konfigurace navigace
		$config = new Zend_Config_Xml(sprintf("%s/resources/navigation.xml", APPLICATION_PATH), "nav");
		$navigation = new Zend_Navigation($config);
		
		// nacteni a nastaveni helperu
		$helper = $view->navigation();
		$helper->setAcl($acl);
		
		$user = Zend_Auth::getInstance()->getIdentity();
		$helper->setRole($user ? $user : MP_Controller_Plugin_Acl::ROLE_DEFAULT);
		
		$helper->setContainer($navigation);
		
	}

	protected function _initTranslations() {
		
	}
	
	protected function _initHead() {
		$title = new Zend_View_Helper_HeadTitle();
		$title->setSeparator(" - ");
		$title->headTitle("MicroPic");
	}
	
}

