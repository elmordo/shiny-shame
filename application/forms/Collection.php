<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Collection
 *
 * @author petr
 */
class Application_Form_Collection extends MP_Form {
    
    public function init() {
        $this->setName("collection");
        $this->setElementsBelongTo("collection");
        
        $this->addElement("text", "name", array(
            "required" => true,
            "description" => "Name of collection",
            "label" => "Name"
        ));
        
        $this->addElement("textarea", "comment", array(
            "required" => false,
            "filters" => array(
                new Zend_Filter_Null()
            ),
            "label" => "Comment",
            "description" => "Comment of collection",
            "class" => "textile",
            "title" => "Supported Textile"
        ));
        
        $this->addElement("text", "tag", array(
            "label" => "Tag",
            "filters" => array(
                new Zend_Filter_Null()
            ),
            "required" => false,
            "description" => "Prefix in filename for automatic classification of new images (read-only)",
            "readonly" => true
        ));
        
        $this->addElement("select", "group_id", array(
            "label" => "Group",
            "required" => false,
            "filters" => array(
                new Zend_Filter_Null()
            ),
            "description" => "User group for data access (can be empty)",
            "multiOptions" => array("0" => "-- NO GROUP SELECTED --")
        ));
        
        $this->addElement("submit", "submit", array(
            "label" => "Save"
        ));
        
        // inicializace skupin
        $groups = Application_Model_Groups::getGroupsIndex();
        
        $this->_elements["group_id"]->addMultiOptions($groups);
    }
}

?>
