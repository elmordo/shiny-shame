<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group
 *
 * @author petr
 */
class Application_Form_Group extends MP_Form {
    
    public function init() {
        $this->setName("group");
        $this->setElementsBelongTo("group");
        
        $this->addElement("text", "name", array(
            "required" => true,
            "label" => "Group name",
            "description" => "Name of group"
        ));
        
        $this->addElement("submit", "submit", array(
            "label" => "Save"
        ));
    }
}

?>
