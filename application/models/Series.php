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
    
    /**
     * vraci seznam serii dle vzorku
     * 
     * @param int $sampleId identifikacni cislo vzorku
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findBySample($sampleId) {
        $select = $this->prepareSelect();
        $select->where("sample_id = ?" ,$sampleId);
        
        $data = $select->query()->fetchAll();
        
        return $this->_generateRowset($data);
    }
    
    /**
     * pripravy select pro rozsirene vyhledavani
     * 
     * @return \Zend_Db_Select
     */
    public function prepareSelect() {
        // zakladni informace
        $select = new Zend_Db_Select($this->getAdapter());
        $select->from(array("s" => $this->_name))->group("s.serie_id");
        
        // pripojeni snimku
        $nameFrames = self::getRealName("Application_Model_Frames");
        $select->joinLeft(array("f" => $nameFrames), "f.serie_id = s.serie_id", array(
            "frames" => new Zend_Db_Expr("COUNT(f.frame_id)")
        ));
        
        return $select;
    }
}

?>
