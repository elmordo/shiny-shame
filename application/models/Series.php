<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Series
 *
 * @author petr
 */
class Application_Model_Series extends MP_Db_Table {
    
    protected $_name = "series";
    
    protected $_primary = array("serie_id");
    
    protected $_sequence = true;
    
    protected $_referenceMap = array(
        "sample" => array(
            "columns" => "sample_id",
            "refTableClass" => "Application_Model_Samples",
            "refColumns" => "sample_id"
        )
    );
    
    protected $_rowClass = "Application_Model_Row_Serie";
    
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
