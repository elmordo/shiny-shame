<?php

class Application_Model_Microscopes extends Zend_Db_Table_Abstract {

    protected $_name = "microscopes";
    protected $_primary = "id";
    protected $_sequence = true;
    protected $_rowClass = "Application_Model_Row_Microscope";

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