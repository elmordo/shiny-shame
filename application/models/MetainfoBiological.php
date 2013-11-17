<?php
class Application_Model_MetainfoBiological extends Zend_Db_Table_Abstract {
	
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
	
}