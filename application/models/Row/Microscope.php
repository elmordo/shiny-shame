<?php
class Application_Model_Row_Microscope extends Zend_Db_Table_Row_Abstract {
	
    /**
     * vraci metainformace tykajici se mikroskopu
     * 
     * @param string $order razeni
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findMeta($order = null) {
        $tableMeta = new Application_Model_MetainfoMicroscopes();
        
        return $tableMeta->fetchAll(array("microscope_id = ?" => $this->id), $order);
    }
}