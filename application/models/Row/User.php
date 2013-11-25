<?php
class Application_Model_Row_User extends Zend_Db_Table_Row_Abstract implements Zend_Acl_Role_Interface {
	
	/**
	 * (non-PHPdoc)
	 * @see Zend_Acl_Role_Interface::getRoleId()
	 */
	public function getRoleId() {
		return $this->role;
	}
	
	/**
	 * zkontroluje heslo
	 * 
	 * @param string $psw heslo ke kontrole
	 * @return bool
	 */
	public function checkPassword($psw) {
		return strcmp($this->password, $this->_hashPassword($psw)) == 0;
	}
	
	/**
	 * nastavi nove heslo
	 * 
	 * @param string $psw nove heslo
	 * @return Application_Model_Row_User
	 */
	public function setPassword($psw) {
		$this->password = $this->_hashPassword($psw);
		
		return $this;
	}

	/**
	 * zahashuje heslo
	 * @param string $psw heslo
	 * @return string
	 */
	protected function _hashPassword($psw) {
		return sha1($this->salt . $psw);
	}
}