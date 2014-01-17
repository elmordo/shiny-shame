<?php
class Application_Model_Row_User extends Zend_Db_Table_Row_Abstract implements Zend_Acl_Role_Interface {
    
    /**
     * seznam skupin, ve kterych je uzivatel clenem
     *
     * @var array
     */
    protected $_groups = array();
    
    /**
     * inicializuje instanci nactenim seznamu id skupin
     */
    public function init() {
        // nacteni seznamu skupin
        $select = new Zend_Db_Select($this->getTable()->getAdapter());
        $nameGroups = MP_Db_Table::getRealName("Application_Model_Groups");
        $nameAssocs = MP_Db_Table::getRealName("Application_Model_UsersHaveGroups");
        
        $select->from(array("g" => $nameGroups), array("group_id"));
        $select->joinInner(array("a" => $nameAssocs), "a.group_id = g.group_id", array());
        
        $data = $select->query()->fetchAll();
        $this->_groups = array();
        
        foreach ($data as $item) {
            $this->_groups[] = $item["group_id"];
        }
    }
    
    public function __sleep() {
        $array = parent::__sleep();
        $array[] = "_groups";
        
        return $array;
    }
	
    /**
     * vygeneruje novou sul
     * 
     * @return \Application_Model_Row_User
     */
    public function generateSalt() {
        $this->salt = sha1(time() . microtime(false));
        
        return $this;
    }
    
	/**
	 * (non-PHPdoc)
	 * @see Zend_Acl_Role_Interface::getRoleId()
	 */
	public function getRoleId() {
		return $this->role;
	}
    
    /**
     * vraci True, pokud uzivatel nalezi do dane skupiny
     * 
     * @param int $groupId id skupiny
     * @return bool
     */
    public function hasGroup($groupId) {
        return in_array($groupId, $this->_groups);
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