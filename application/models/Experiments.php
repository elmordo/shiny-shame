<?php
class Application_Model_Experiments extends Zend_Db_Table_Abstract {
	
	protected $_name = "experiments";
	
	protected $_primary = array("id");
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
			"user" => array(
					"columns" => "user_id",
					"refTableClass" => "Application_Model_Users",
					"refColumns" => "id"
					)
			);
	
}