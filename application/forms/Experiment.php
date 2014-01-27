<?php

class Application_Form_Experiment extends MP_Form {

    public function init() {

        $this->setElementsBelongTo("experiment");

        $this->addElement("text", "name", array(
            "label" => "Name",
            "required" => true
        ));
        
        $this->addElement("select", "microscope_id", array(
            "label" => "Microscope",
            "required" => false,
            "filters" => array(
                new Zend_Filter_Null()
            ),
            "validators" => array(
                new Zend_Validate_Digits()
            )
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

        $this->addElement("text", "begins", array(
            "label" => "Begins",
            "required" => false,
            "validators" => array(
                new MP_Validate_SqlDate(MP_Validate_SqlDate::CHECK_DATETIME)
            ),
            "description" => "Date and time format is YYYY-MM-DD hh:mm:ss",
            "filters" => array(
                new Zend_Filter_Null()
            )
        ));

        $this->addElement("text", "ends", array(
            "label" => "Ends",
            "required" => false,
            "validators" => array(
                new MP_Validate_SqlDate(MP_Validate_SqlDate::CHECK_DATETIME)
            ),
            "description" => "Date and time format is YYYY-MM-DD hh:mm:ss",
            "filters" => array(
                new Zend_Filter_Null()
            )
        ));

        $this->addElement("submit", "submit", array(
            "label" => "Save"
        ));
    }

}
