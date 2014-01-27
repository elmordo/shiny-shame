<?php

class Application_Form_Microscope extends MP_Form {

    public function init() {
        
        $this->setElementsBelongTo("microscope");
        
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
            "required" => false,
            "filters" => array(
                new Zend_Filter_Null()
            ),
            "class" => "textile",
            "title" => "Supported Textile"
        ));

        $this->addElement("checkbox", "is_suspended", array(
            "label" => "Unavailable",
            "required" => true
        ));

        $this->addElement("submit", "submit", array(
            "label" => "Save"
        ));
    }

}
