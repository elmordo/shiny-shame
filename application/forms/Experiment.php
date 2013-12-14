<?php
class Application_Form_Experiment extends MP_Form {
	
	public function init() {
        
        $this->setElementsBelongTo("experiment");
		
		$this->addElement("text", "name", array(
				"label" => "Name",
				"required" => true
				));
		
		$this->addElement("textarea", "comment", array(
				"label" => "Comment",
				"required" => false
				));
		
		$this->addElement("text", "begins", array(
				"label" => "Begins",
				"required" => false,
                "validators" => array(
                    new MP_Validate_SqlDate(MP_Validate_SqlDate::CHECK_DATETIME)
                )
				));
		
		$this->addElement("text", "ends", array(
				"label" => "Ends",
				"required" => false,
                "validators" => array(
                    new MP_Validate_SqlDate(MP_Validate_SqlDate::CHECK_DATETIME)
                )
				));
		
		$this->addElement("submit", "submit", array(
				"label" => "Save"
				));
	}
}
