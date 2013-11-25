<?php
class Application_Form_Login extends MP_Form implements Zend_Auth_Adapter_Interface {
	
	const AUTH_ERROR = "Invalid login or password";
	
	/**
	 * @var Application_Model_Users
	 */
	private $_tableUsers;
	
	public function init() {
		$this->setMethod("post");
		$this->setName("login");
		$this->setElementsBelongTo("loginform");
		
		$this->addElement("text", "login", array(
				"label" => "Login name",
				"required" => true
				));
		
		$this->addElement("password", "password", array(
				"label" => "Password",
				"required" => true
				));
		
		$this->addElement("submit", "submit", array(
				"label" => "Log in"
				));
		
		$this->_tableUsers = new Application_Model_Users();
	}
	
	/**
	 * 
	 */
	public function authenticate() {
		// nalezeni uzivatele a kontrola existence
		$user = $this->_tableUsers->findByLogin($this->getValue("login"));
		
		if (!$user) {
			$this->getElement("login")->addError(self::AUTH_ERROR);
			return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, null);
		}
		
		// kontrola hesla
		if (!$user->checkPassword($this->getValue("password"))) {
			$this->getElement("login")->addError(self::AUTH_ERROR);
			return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, null);
		}
		
		// identita nalezena
		return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $user);
	}
}