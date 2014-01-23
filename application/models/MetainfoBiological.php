<?php
class Application_Model_MetainfoBiological extends MP_Db_Table_Meta {
	
	protected $_name = "metainfo_biological";
	
	protected $_primary = array("metainfo_biological_id");
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
			"experiment" => array(
					"columns" => "experiment_id",
					"refTableClass" => "Application_Model_Experiments",
					"refColumns" => "experiment_id"
					)
			);
	
	protected $_rowClass = "Application_Model_Row_MetainfoBiological";
        
    protected $_referenceColumn = "experiment_id";
}
