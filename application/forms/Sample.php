<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sample
 *
 * @author petr
 */
class Application_Form_Sample extends MP_Form {
    
    public function init() {
        $this->setName("sample");
        $this->setElementsBelongTo("sample");
        
        $this->addElement("text", "name", array(
            "label" => "Sample name",
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
        
        $this->addElement("submit", "save", array(
            "label" => "Save"
        ));
    }
}

?>
