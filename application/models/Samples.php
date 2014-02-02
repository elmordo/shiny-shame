<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Samples
 *
 * @author petr
 */
class Application_Model_Samples extends MP_Db_Table {
    
    protected $_name = "samples";
    
    protected $_sequence = true;
    
    protected $_primary = array("id");
    
    protected $_referenceMap = array(
        "experiment" => array(
            "columns" => array("experiment_id"),
            "refTableClass" => "Application_Model_Experiments",
            "refColumns" => array("experiment_id")
        )
    );
    
    protected $_rowClass = "Application_Model_Row_Sample";
    
    protected $_markups = array(
        array(
            "source" => "comment",
            "target" => "comment_html",
            "parser" => self::MARKUP_DEFAULT_PARSER,
            "renderer" => self::MARKUP_DEFAULT_RENDERER
        )
    );
    
    protected $_markupsEnabled = true;
}

?>
