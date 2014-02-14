<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Serie
 *
 * @author petr
 */
class Application_Form_Serie extends MP_Form {
    
    public function init() {
        
        $this->setName("serie");
        $this->setElementsBelongTo("serie");
        
        $this->addElement("text", "name", array(
            "label" => "Serie name",
            "required" => true,
            "description" => "Order of serie, e.t.c."
        ));
        
        $this->addElement("textarea", "comment", array(
            "label" => "Comment",
            "required" => false,
            "description" => "Description of serie",
            "filters" => array(
                new Zend_Filter_Null()
            ),
            "class" => "textile"
        ));
        
        $this->addElement("text", "start_at", array(
            "label" => "Start",
            "validators" => array(
                new MP_Validate_SqlDate(MP_Validate_SqlDate::CHECK_DATETIME)
            ),
            "filters" => array(
                new Zend_Filter_Null()
            ),
            "description" => "Date and time when measure was started"
        ));
        
        $this->addElement("text", "end_at", array(
            "label" => "End",
            "validators" => array(
                new MP_Validate_SqlDate(MP_Validate_SqlDate::CHECK_DATETIME)
            ),
            "filters" => array(
                new Zend_Filter_Null()
            ),
            "description" => "Date and time when measure was ended"
        ));
        
        $this->addElement("submit", "submit", array(
            "label" => "Save"
        ));
    }
}

?>
