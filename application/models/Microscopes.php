<?php
class Application_Model_Microscopes extends Zend_Db_Table_Abstract {
	
	protected $_name = "microscopes";
	
	protected $_primary = "id";
	
	protected $_sequence = true;
	
	protected $_rowClass = "Application_Model_Row_Microscope";
}