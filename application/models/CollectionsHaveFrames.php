<?php
class Application_Model_CollectionsHaveFrames extends MP_Db_Table {
	
	protected $_name = "collections_have_frames";
	
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

	protected $_rowClass = "Application_Model_Row_CollectionsHaveFrames";
	
}
