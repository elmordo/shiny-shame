<?php
class Application_Model_Users extends Zend_Db_Table_Abstract {
	
	protected $_name = "users";
	
	protected $_primary = array("id");
	
	protected $_sequence = true;
	
	protected $_rowClass = "Application_Model_Row_User";
	
	/**
	 * najde uzivatele dle loginu a vraci jeho radek
	 * v opacnem pripade vyhazuje vyjimku
	 * 
	 * @param unknown_type $login
	 * @return Application_Model_Row_User
	 * @throws Zend_Db_Table_Exception
	 */
	public function findByLogin($login) {
		return $this->fetchRow(array("login like ?" => $login));
	}
    
    /**
     * nacte uzivatele dle jeho id
     * 
     * @param int $id id uzivatele
     * @return Application_Model_Row_User
     */
    public function findById($id) {
        return $this->find($id)->current();
    }
}