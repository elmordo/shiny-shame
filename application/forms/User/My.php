<?php
class Application_Form_User_My extends Application_Form_User {
	
	public function init() {
		parent::init();
		
		$this->removeElement("login");
		$this->removeElement("role");
		
		$this->addElement("password", "old_password", array(
				"label" => "Old password",
				"required" => true,
				"order" => 1
				));
	}
}