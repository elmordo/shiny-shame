<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MetainfoMicroscopes
 *
 * @author petr
 */
class Application_Model_MetainfoMicroscopes extends MP_Db_Table_Meta {
    
    protected $_name = "metainfo_microscopes";
    
    protected $_primary = "metainfo_microscope_id";
    
    protected $_sequence = true;
    
    protected $_rowClass = "Application_Model_Row_MetainfoMicroscope";
    
    protected $_referenceMap = array(
        "microscope" => array(
            "columns" => "microscope_id",
            "refTableClass" => "Application_Model_Microscopes",
            "refColumns" => "microscope_id"
        )
    );
    
    protected $_referenceColumn = "microscope_id";
    
    /**
     * najde set metainformaci dle id rodice
     * pokud neni nastaveno jinak, radky se radi dle jmena
     * 
     * @param string $parentId i rodice
     * @param stirng $order razeni
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findByParent($parentId, $order = null) {
        // sestaveni vyhledavaci podminky
        $adapter = $this->getAdapter();
        $cnd = sprintf("%s = ?", $adapter->quoteIdentifier($this->_referenceColumn));
        
        $where = array($cnd => $parentId);
        
        // vyhledani dat
        return $this->fetchAll($where, $order);
    }
}

?>
