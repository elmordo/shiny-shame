<?php
class Application_Form_User extends MP_Form {
	
	public function init() {
		
		$this->setName("user");
		$this->setMethod("post");
		$this->setElementsBelongTo("user");
		
		$this->addElement("text", "login", array(
				"label" => "Login name",
				"required" => true
				));
		
		$this->addElement("text", "username", array(
				"label" => "Real name",
				"required" => true
				));
				
		$this->addElement("password", "password", array(
				"label" => "Password",
				"required" => true
				));
				
		$this->addElement("password", "password_confirm", array(
				"label" => "Password confirm",
				"required" => true
				));
		
		$this->addElement("select", "role", array(
				"label" => "Role",
				"required" => true,
				"multiOptions" => MP_Role::getRoles()
				));
		
		$this->addElement("submit", "submit", array(
				"label" => "Save"
				));
	}
}
