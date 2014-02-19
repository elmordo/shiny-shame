<?php
class Application_Model_Frames extends MP_Db_Table {
	
	protected $_name = "frames";
	
	protected $_primary = array("frame_id");
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
			"experiment" => array(
					"columns" => "experiment_id",
					"refTableClass" => "Application_Model_Experiments",
					"refColumns" => "experiment_id"
					)
			);
			
	protected $_rowClass = "Application_Model_Row_Frame";
    
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
     * vraci radek dle snimku
     * 
     * @param int $id identifikacni cislo snimku
     * @return Application_Model_Row_Frame
     */
    public function findById($id) {
        $select = $this->prepareSelect();
        $select->where("f.frame_id = ?", $id);
        
        return $this->_generateRow($select->query()->fetch());
    }
	
    /**
     * nacte seznam snimku dle serie a pripadne dle kolekce
     * 
     * @param id $serieId id serie
     * @param int $collectionId id kolekce
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findBySerieAndCollection($serieId, $collectionId = null) {
        // sestaveni zakladni podminky
        $select = $this->prepareSelect();
        $select->where("f.serie_id = ?", $serieId);
        
        // pripadne napojeni na kolekce
        if (!is_null($collectionId)) {
            $nameCollections = self::getRealName("Application_Model_CollectionsHaveFrames");
            $select->joinInner(array("c" => $nameCollections), "c.frame_id = f.frame_id", array());
            $select->where("c.collection_id = ?", $collectionId);
        }
        
        return $this->_generateRowset($select->query()->fetchAll());
    }
    
    /**
     * najde snimek podle hodnot, jejich kombinace by mela byt unikatni
     * 
     * @param int $serieId identifikacni cislo serie snimku
     * @param string $tag kolekce, do ktere v zakladu spada
     * @param int $ord poradi snimku
     * @return Application_Model_Row_Frame
     */
    public function findByInfo($serieId, $tag, $ord) {
        $select = $this->prepareSelect();
        
        $select->where("f.serie_id = ?", $serieId)
                ->where("f.tag like ?", $tag)
                ->where("f.ord = ?", $ord);
        
        return $this->_generateRow($select->query()->fetch());
    }
    
    public function prepareSelect() {
        // zakladni nastaveni
        $select = new Zend_Db_Select($this->getAdapter());
        $select->from(array("f" => $this->_name));
        
        // navazani na serii
        $nameSeries = self::getRealName("Application_Model_Series");
        $select->joinInner(array("se" => $nameSeries), "se.serie_id = f.serie_id", array());
        
        // navazani na vzorek
        $nameSamples = self::getRealName("Application_Model_Samples");
        $select->joinInner(array("sa" => $nameSamples), "sa.sample_id = se.sample_id", array("sa.sample_id", "sa.experiment_id"));
        
        return $select;
    }
}
