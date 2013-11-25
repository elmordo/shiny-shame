<?php
class Application_Form_User_Admin extends Application_Form_User {
	
	public function init() {
		parent::init();
		
		$this->removeElement("login");
	}
}