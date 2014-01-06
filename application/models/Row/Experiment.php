<?php
class Application_Model_Row_Experiment extends MP_Db_Table_Row implements MP_Db_Table_Row_DataAccess {

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
    
    public function getAccessPermisions() {
        return "access_permisions";
    }
    
    public function getGroupId() {
        return $this->group_id;
    }
    
    public function getOwnerId() {
        return $this->user_id;
    }
}
