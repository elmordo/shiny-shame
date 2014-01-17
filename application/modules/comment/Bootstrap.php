<?php
class Comment_Bootstrap extends ZSAM_Application_ModuleBootstrap {
	
	/**
	 * inicializace ACL
	 */
	protected function _initAcl() {
		// nacteni ACL
		$acl = Zend_Controller_Front::getInstance()->getPlugin("ZSAM_Controller_Plugin_Acl")->getAcl();
		
		// vytvoreni zdroju
		$acl->addResource(new Zend_Acl_Resource("comment:comment"));
		$acl->addResource(new Zend_Acl_Resource("comment:session"));
		
		// nacteni dat
		$guest = $acl->getRole("guest");
		$admin = $acl->getRole("admin");
		
		// nastaveni pristupu admina
		$acl->allow($admin, "comment:comment");
		$acl->allow($admin, "comment:session");
		
		// nastaveni pristupu guesta
		$acl->allow($guest, "comment:comment", array("create", "get", "post"));
		$acl->allow($guest, "comment:session", array("get"));
	}
}