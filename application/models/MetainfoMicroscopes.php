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
class Application_Model_MetainfoMicroscopes extends Zend_Db_Table_Abstract {
    
    protected $_name = "metainfo_microscopes";
    
    protected $_primary = "id";
    
    protected $_sequence = true;
    
    protected $_rowClass = "Application_Model_Row_MetainfoMicroscope";
    
    protected $_referenceMap = array(
        "microscope" => array(
            "columns" => "microscope_id",
            "refTableClass" => "Application_Model_Microscopes",
            "refColumns" => "id"
        )
    );
}

?>
