<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Delete
 *
 * @author petr
 */
class MP_Form_Delete extends MP_Form {
    
    public function init() {
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setName("deleteform");
        $this->setElementsBelongTo("delete");
        
        $this->addElement("checkbox", "confirm", array(
            "label" => "Confirm deletion",
            "required" => true,
            "value" => "0",
            "validators" => array(
                new Zend_Validate_Identical("1")
            ),
            "attribs" => array(
                "required" => "required"
            )
        ));
        
        $this->addElement("submit", "submit", array(
            "label" => "Delete"
        ));
    }
}

?>
