<?php
class Application_Model_CollectionsHaveFrames extends MP_Db_Table {
	
	protected $_name = "collections_have_frames";
	
	protected $_primary = array("frame_id", "collection_id");
	
	protected $_sequence = false;
	
	protected $_referenceMap = array(
			"collection" => array(
					"columns" => "collection_id",
					"refTableClass" => "Application_Model_Collections",
					"refColumns" => "collection_id"
					),
			
			array(
					"columns" => "frame_id",
					"refTableClass" => "Application_Model_Frames",
					"refColumns" => "frame_id"
					)
				);

	protected $_rowClass = "Application_Model_Row_CollectionsHaveFrames";
	
    /**
     * vlozi snimek do vybranych uzivatelskych kolekci
     * 
     * @param Application_Model_Row_Frame $frame radek se snimkem
     * @param array $collectionIds seznam id kolekci, ktere budou vlozeny
     * @return \Application_Model_CollectionsHaveFrames
     */
    public function setFrameCollections(Application_Model_Row_Frame $frame, array $collectionIds) {
        // smazani starych dat
        $nameCollections = self::getRealName("Application_Model_Collections");
        $select = new Zend_Db_Select($this->getAdapter());
        $select->from($nameCollections, array("collection_id"));
        
        $select->where("tag IS NULL")->where("experiment_id = ?", $frame->experiment_id);
        
        $this->delete(array(
            "frame_id = ?" => $frame->frame_id,
            "collection_id in (?)" => new Zend_Db_Expr($select->assemble())
        ));
        
        // kontrola, jestli byly predany nejake kolekce
        if (!$collectionIds) return $this;
        
        // vlozeni novych kolekci
        $records = array();
        $pattern = sprintf("(%d, %%d)", $frame->frame_id);
        
        foreach ($collectionIds as $id) {
            $records[] = sprintf($pattern, $id);
        }
        
        $sql = sprintf("INSERT INTO %s (frame_id, collection_id) VALUES %s", $this->getAdapter()->quoteIdentifier($this->_name), implode(",", $records));
        $this->getAdapter()->query($sql);
        
        return $this;
    }
}
