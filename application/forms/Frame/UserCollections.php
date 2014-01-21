<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserCollections
 *
 * @author petr
 */
class Application_Form_Frame_UserCollections extends MP_Form {
    
    public function init() {
        $this->setElementsBelongTo("usercollections");
        $this->setName("usercollections");
        
        $this->addElement("submit", "submit");
    }
    
    public function setCollections($collections) {
        $this->clearElements();
        
        foreach ($collections as $collection) {
            $this->addElement("checkbox", $collection->collection_id, array(
                "label" => $collection->name,
                "checked" => $collection->frame_id ? true : false
            ));
        }
        
        $this->init();
    }
}

?>
