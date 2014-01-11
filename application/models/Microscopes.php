<?php

class Application_Model_Microscopes extends MP_Db_Table {

    protected $_name = "microscopes";
    protected $_primary = "microscope_id";
    protected $_sequence = true;
    protected $_rowClass = "Application_Model_Row_Microscope";
    
    /**
     * nacte seznam dostupnych mikroskopu
     * 
     * @param string $order razeni
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findAvailables($order = "name") {
        $retVal = $this->fetchAll(array(
            "is_suspended = ?" => 0
        ), $order);
        
        return $retVal;
    }
    
    /**
     * vraci mikroskop dle id
     * 
     * @param int $id id mikroskopu
     * @return Application_Model_Row_Microscope
     */
    public function findById($id) {
        return $this->find($id)->current();
    }
    
    /**
     * nalezne mikroskop dle tagu
     * 
     * @param string $tag zkratka mikroskopu
     * @return Application_Model_Row_Microscope
     */
    public function findByTag($tag) {
        return $this->fetchRow(array(
                    "`tag` like ?" => $tag
        ));
    }

}