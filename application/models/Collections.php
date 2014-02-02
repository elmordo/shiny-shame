<?php
class Application_Model_Collections extends MP_Db_Table {
	
	protected $_name = "collections";
	
	protected $_primary = array("collection_id");
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
			"serie" => array(
					"columns" => "serie_id",
					"refTableClass" => "Application_Model_Series",
					"refColumns" => "serie_id"
					)
			);
	
	protected $_rowClass = "Application_Model_Row_Collection";
    
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
     * vytvori novou instanci radku kolekce a vraci ji
     * radek je automaticky ulozen
     * 
     * @param array $data data k ulozeni
     * @param Application_Model_Row_Serie $serie experiment do ktereho kolekce spada
     * @param int $userId id uzivatele
     * @return Application_Model_Row_Collection
     */
    public function createCollection(array $data, $serie, $userId = null) {
        if (is_null($userId)) {
            $userId = Zend_Auth::getInstance()->getIdentity()->user_id;
        }
        
        $retVal = $this->createRow($data);
        $retVal->user_id = $userId;
        $retVal->experiment_id = $serie->serie_id;
        
        $retVal->save();
        
        return $retVal;
    }
    
    /**
     * vraci seznam kolekci k experimentu
     * 
     * @param int $experimentId identifikator experimentu
     * @param string $order razeni
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findBySerie($serieId, $order = null) {
        $select = $this->prepareSelect();
        $select->where("c.serie_id = ?", $serieId);
        
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
        $select->where("c.collection_id = ?", $id);
        
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
        $nameGroups = self::getRealName("Application_Model_Groups");
        $nameUsers = self::getRealName("Application_Model_Users");
        
        // zakladni data
        $select->from(array("c" => $this->_name), array(
            new Zend_Db_Expr("c.*"),
            "frame_count" => new Zend_Db_Expr("COUNT(f.frame_id)")
        ));
        
        // napojeni na snimky
        $select->joinLeft(array("a" => $nameAssocs), "c.collection_id = a.collection_id", array());
        $select->joinLeft(array("f" => $nameFrames), "f.frame_id = a.frame_id", array());
        
        // napojeni na skupinu
        $select->joinLeft(array("g" => $nameGroups), "g.group_id = c.group_id", array( "group_name" => "g.name"));
        
        // napojeni na uzivatele
        $select->joinInner(array("u" => $nameUsers), "u.user_id = c.user_id", array( "username" => "u.username"));
        
        $select->group("c.collection_id");
        
        return $select;
    }
}