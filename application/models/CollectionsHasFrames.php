<?php
class Application_Model_CollectionsHasFrames extends Zend_Db_Table_Abstract {
	
	protected $_name = "collections_has_frames";
	
	protected $_primary = array("frame_id", "collection_id");
	
	protected $_sequence = false;
	
	protected $_referenceMap = array(
			"collection" => array(
					"columns" => "collection_id",
					"refTableClass" => "Application_Model_Collections",
					"refColumns" => "id"
					),
			
			array(
					"columns" => "frame_id",
					"refTableClass" => "Application_Model_Frames",
					"refColumns" => "id"
					)
				);

	protected $_rowClass = "Application_Model_Row_CollectionsHasFrames";
	
}
