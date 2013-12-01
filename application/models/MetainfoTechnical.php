<?php
class Application_Model_MetainfoTechnical extends MP_Db_Table_Meta {
	
	protected $_name = "metainfo_technical";
	
	protected $_primary = array("id");
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
			"experiment" => array(
					"columns" => "experiment_id",
					"refTableClass" => "Application_Model_Experiments",
					"refColumns" => "id"
					)
			);
	
	protected $_rowClass = "Application_Model_Row_MetainfoTechnical";
        
        protected $_referenceColumn = "experiment_id";
}
