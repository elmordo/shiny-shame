<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Frame
 *
 * @author petr
 */
class Application_Form_Frame extends MP_Form {
    
    public function init() {
        parent::init();
        
        $this->setName("frame");
        $this->setElementsBelongTo("frame");
        
        $this->addElement("textarea", "comment", array(
            "label" => "Comment",
            "required" => false,
            "filters" => array(
                new Zend_Filter_Null()
            ),
            "class" => "textile",
            "title" => "Supported Textile"
        ));
        
        $this->addElement("submit", "submit", array(
            "label" => "Save"
        ));
    }
}

?>
