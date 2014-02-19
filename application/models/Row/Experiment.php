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
     * smaze biologicke metainformace
     * 
     * @return Application_Model_Row_Experiment
     */
    public function clearBiological() {
        $this->_clearMeta(new Application_Model_MetainfoBiological());
        
        return $this;
    }
    
    /**
     * smaze technicke metainformace
     * 
     * @return \Application_Model_Row_Experiment
     */
    public function clearTechnical() {
        $this->_clearMeta(new Application_Model_MetainfoTechnical());
        
        return $this;
    }
    
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
    
    public function importMicroscopeMeta() {
        // kontrola, jeslti je nastaven mikroskop
        if (is_null($this->microscope_id)) throw new Zend_Db_Table_Row_Exception("Microscope not set");
        
        // smazani starych dat
        $this->clearTechnical();
        
        // vygenerovani dotazu pro vlozeni novych dat
        $tableMicro = new Application_Model_MetainfoMicroscopes();
        $select = new Zend_Db_Select($tableMicro->getAdapter());
        $select->from($tableMicro->info("name"), array(
            "name",
            "internal_name",
            "value",
            "is_constant",
            new Zend_Db_Expr($this->experiment_id)
        ));
        
        $select->where("microscope_id = ?", $this->microscope_id);
        
        $tableTech = new Application_Model_MetainfoTechnical();
        
        $sqlPattern = "insert into %s (name, internal_name, value, is_constant, experiment_id) %s";
        $sql = sprintf($sqlPattern, $tableTech->info("name"), $select->assemble());
        
        $this->getTable()->getAdapter()->query($sql);
        
        return $this;
    }
    
    private function _clearMeta(MP_Db_Table_Meta $table) {
        $table->delete(array(
            "experiment_id = ?" => $this->experiment_id
        ));
    }
}
