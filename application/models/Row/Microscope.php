<?php
class Application_Model_Row_Microscope extends MP_Db_Table_Row {
	
    /**
     * vraci metainformace tykajici se mikroskopu
     * 
     * @param string $order razeni
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findMeta($order = null) {
        $tableMeta = new Application_Model_MetainfoMicroscopes();
        
        return $tableMeta->fetchAll(array("microscope_id = ?" => $this->microscope_id), $order);
    }
}