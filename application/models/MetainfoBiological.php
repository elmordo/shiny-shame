<?php
class Application_Model_MetainfoBiological extends MP_Db_Table_Meta {
	
	protected $_name = "metainfo_biological";
	
	protected $_primary = array("id");
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
			"experiment" => array(
					"columns" => "experiment_id",
					"refTableClass" => "Application_Model_Experiments",
					"refColumns" => "id"
					)
			);
	
	protected $_rowClass = "Application_Model_Row_MetaInfoBiological";
        
        protected $_referenceColumn = "experiment_id";
}
