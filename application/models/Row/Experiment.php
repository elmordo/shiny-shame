<?php
class Application_Model_Row_Experiment extends Zend_Db_Table_Row_Abstract implements Zend_Acl_Resource_Interface {
    
    const RESOURCE_NAME = "experiment";
    
    /**
     *
     * @var Application_Model_Row_User
     */
    private $_user = null;
    
    /**
     *
     * @var Application_Model_Row_Microscope
     */
    private $_microscope = null;
    
    /**
     * @return Application_Model_Row_Microscope
     */
    public function findMicroscope() {
        if (is_null($this->_microscope)) {
            $this->_microscope = $this->findParentRow(new Application_Model_Microscopes(), "microscope");
        }
        
        return $this->_microscope;
    }
    
    /**
     * vraci uzivatele, ktery experiment provedl
     * 
     * @return Application_Model_Row_User
     */
    public function findUser() {
        if (is_null($this->_user)) {
            $this->_user = $this->findParentRow(new Application_Model_Users(), "user");
        }
        
        return $this->_user;
    }
    
    /**
     * vraci id zdroje
     * 
     * @return string
     */
    public function getResourceId() {
        return self::RESOURCE_NAME;
    }
    
}
