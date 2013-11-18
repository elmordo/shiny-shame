<?php
class Application_Form_User extends MP_Form {
	
	public function init() {
		
		$this->setName("user");
		$this->setMethod("post");
		$this->setElementsBelongTo("user");
		
		$this->addElement("text", "login", array(
				"label" => "Přihlašovací jméno",
				"required" => true
				));
		
		$this->addElement("text", "username", array(
				"label" => "Skutečné jméno",
				"required" => true
				));
		
		$this->addElement("select", "role", array(
				"label" => "Oprávnění",
				"required" => true,
				"multiOptions" => MP_Role::getRoles()
				));
		
		$this->addElement("submit", "submit", array(
				"label" => "Uložit"
				));
	}
}