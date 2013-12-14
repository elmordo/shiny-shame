<?php
class Application_Model_Frames extends MP_Db_Table {
	
	protected $_name = "frames";
	
	protected $_primary = array("id");
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
			"experiment" => array(
					"columns" => "experiment_id",
					"refTableClass" => "Application_Model_Experiments",
					"refColumns" => "id"
					)
			);
			
	protected $_rowClass = "Application_Model_Row_Frame";
	
}
