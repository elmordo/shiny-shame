<?php
class Application_Model_Collections extends MP_Db_Table {
	
	protected $_name = "collections";
	
	protected $_primary = array("id");
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
			"experiment" => array(
					"columns" => "experiment_id",
					"refTableClass" => "Application_Model_Experiments",
					"refColumns" => "id"
					)
			);
	
	protected $_rowClass = "Application_Model_Row_Collection";
    
    /**
     * vraci seznam kolekci k experimentu
     * 
     * @param int $experimentId identifikator experimentu
     * @param string $order razeni
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findByExperiment($experimentId, $order = null) {
        $select = $this->prepareSelect();
        $select->where("c.experiment_id = ?", $experimentId);
        
        return $this->_generateRowset($select->query()->fetchAll());
    }
    
    /**
     * najde kolekci dle identifikacniho cisla
     * 
     * @param int $id identifikacni cislo kolekce
     * @return Application_Model_Row_Collection
     */
    public function findById($id) {
        $select = $this->prepareSelect();
        $select->where("c.id = ?", $id);
        
        return $this->_generateRow($select->query()->fetch());
    }
    
    /**
     * pripravi dotazovaci objekt pro nacitani dat
     * 
     * @return \Zend_Db_Select
     */
    public function prepareSelect() {
        $select = new Zend_Db_Select($this->getAdapter());
        
        // propojeni tabulek na snimky
        $nameFrames = self::getRealName("Application_Model_Frames");
        $nameAssocs = self::getRealName("Application_Model_CollectionsHaveFrames");
        
        $select->from(array("c" => $this->_name), array(
            new Zend_Db_Expr("c.*"),
            "frame_count" => new Zend_Db_Expr("COUNT(f.id)")
        ));
        $select->joinLeft(array("a" => $nameAssocs), "c.id = a.collection_id", array());
        $select->joinLeft(array("f" => $nameFrames), "f.id = a.frame_id", array());
        
        $select->group("c.id");
        
        return $select;
    }
}