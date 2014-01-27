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
     * nacte seznam snimku dle experimentu a pripadne dle kolekce
     * 
     * @param id $experimentId id experiment
     * @param int $collectionId id kolekce
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findByExperimentAndCollection($experimentId, $collectionId = null) {
        // sestaveni zakladni podminky
        $where = array("experiment_id = ?" => $experimentId);
        
        // doplneni kolekce, pokud je potreba
        if (!is_null($collectionId)) {
            $nameAssocs = MP_Db_Table::getRealName("Application_Model_CollectionsHaveFrames");
            
            $select = new Zend_Db_Select($this->getAdapter());
            $select->from($nameAssocs, array("frame_id"))->where("collection_id = ?", $collectionId);
            
            $where["frame_id in (?)"] = new Zend_Db_Expr($select->assemble());
        }
        
        return $this->fetchAll($where, "ord");
    }
    
    /**
     * najde snimek podle hodnot, jejich kombinace by mela byt unikatni
     * 
     * @param int $experimentId identifikacni cislo experimentu
     * @param string $tag kolekce, do ktere v zakladu spada
     * @param int $ord poradi snimku
     * @return Application_Model_Row_Frame
     */
    public function findByInfo($experimentId, $tag, $ord) {
        return $this->fetchRow(array(
            "experiment_id = ?" => $experimentId,
            "tag like ?" => $tag,
            "ord = ?" => $ord
        ));
    }
}
