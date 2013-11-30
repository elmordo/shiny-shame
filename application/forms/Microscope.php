<?php
class Application_Form_Microscope extends MP_Form {
	
	public function init() {
		
		$this->addElement("text", "name", array(
				"label" => "Name",
				"required" => true
				));
		
		$this->addElement("text", "tag", array(
				"label" => "Tag",
				"required" => true
				));
		
		$this->addElement("textarea", "comment", array(
				"label" => "Comment",
				"required" => true
				));
		
		$this->addElement("checkbox", "is_supressed", array(
				"label" => "Unavailable",
				"required" => true
				));
		
        $this->addElement("submit", "submit", array(
            "label" => "Save"
        ));
	}
}