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
    
    protected $_primary = array("sample_id");
    
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
    
    /**
     * najde vzorky vazane k experimentu
     * 
     * @param int|Application_Model_Row_Experiment $experiment experiment nebo jeho id
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findByExperiment($experiment) {
        if (is_object($experiment)) {
            $experiment = $experiment->experiment_id;
        }
        
        $select = $this->prepareSelect();
        $select->where("s.experiment_id = ?", $experiment);
        
        return $this->_generateRowset($select->query()->fetchAll());
    }
    
    /**
     * 
     * @param int $id
     * @return Application_Model_Row_Sample
     */
    public function findById($id) {
        $select = $this->prepareSelect();
        $select->where("s.sample_id = ?", $id);
        
        return $this->_generateRow($select->query()->fetch(), true);
    }
    
    /**
     * priprave vyhledavaci dotaz
     * 
     * @return \Zend_Db_Select
     */
    public function prepareSelect() {
        // zakladni vyhledavani
        $select = new Zend_Db_Select($this->getAdapter());
        $select->from(array("s" => $this->_name));
        
        // provazani na serie a ziskani poctu serii
        $select->joinLeft(array("se" => self::getRealName("Application_Model_Series")), "se.sample_id = s.sample_id", array(
            "series" => new Zend_Db_Expr("COUNT(se.serie_id)")
        ));
        
        $select->group("s.sample_id");
        
        return $select;
    }
}

?>
