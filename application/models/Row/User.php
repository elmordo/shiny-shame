<?php
class Application_Model_Row_User extends Zend_Db_Table_Row_Abstract implements Zend_Acl_Role_Interface {
	
	/**
	 * (non-PHPdoc)
	 * @see Zend_Acl_Role_Interface::getRoleId()
	 */
	public function getRoleId() {
		return $this->role;
	}
}