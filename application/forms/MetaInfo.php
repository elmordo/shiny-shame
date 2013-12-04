<?php

class Application_Form_MetaInfo extends MP_Form {

    public function init() {
        
        $this->setElementsBelongTo("meta");
        
        $this->addElement("text", "name", array(
            "label" => "Name",
            "required" => true
        ));

        $this->addElement("text", "internal_name", array(
            "label" => "Internal name",
            "required" => true
        ));

        $this->addElement("text", "value", array(
            "label" => "Value",
            "required" => true
        ));

        $this->addElement("submit", "submit", array(
            "label" => "Save"
        ));
    }

}