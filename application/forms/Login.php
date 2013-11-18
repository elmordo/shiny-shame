<?php
class Application_Form_Login extends MP_Form {
	
	public function init() {
		$this->setMethod("post");
		$this->setName("login");
		$this->setElementsBelongTo("loginform");
		
		$this->addElement("select", "login", array(
				"label" => "Uživatel",
				"required" => true
				));
		
		$this->addElement("submit", "submit", array(
				"label" => "Přihlásit"
				));
	}
}