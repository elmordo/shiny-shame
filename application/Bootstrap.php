<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

	protected function _initIncludes() {
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace("MP_");
		
		Zend_Controller_Front::getInstance()->registerPlugin(new MP_Controller_Plugin_Acl());
	}
	
	protected function _initAcl() {
		$acl = Zend_Controller_Front::getInstance()->getPlugin("MP_Controller_Plugin_Acl")->getAcl();
		
		// registrace zdroju
		$acl->addResource(new Zend_Acl_Resource("index"));
		$acl->addResource(new Zend_Acl_Resource("error"));
		$acl->addResource(new Zend_Acl_Resource("user"));
		$acl->addResource(new Zend_Acl_Resource("experiment"));
		
		// povoleni akci hostovi
		$acl->allow(MP_Role::ROLE_GUEST, "index");
		$acl->allow(MP_Role::ROLE_GUEST, "error");
		$acl->allow(MP_Role::ROLE_GUEST, "user", "login");
		
		// povoleni akci uzivateli
		
		// povoleni akci operatorovi
		
		// povoleni akci adminovi
		$acl->allow(MP_Role::ROLE_ADMIN);
	}

	protected function _initTranslations() {
		
	}
	
	protected function _initHead() {
		$title = new Zend_View_Helper_HeadTitle();
		$title->setSeparator(" - ");
		$title->headTitle("MicroPic");
	}
	
}

