<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author petr
 */
class Application_Form_Group_Users extends MP_Form {
    
    public function init() {
        $this->setName("groupusers");
        $this->_elementsBelongTo = "groupusers";
        
        $this->addElement("submit", "submit", array(
            "label" => "Save",
            "order" => 999999
        ));
    }
    
    public function setUsers($users) {
        $this->clearElements();
        $this->_elementsBelongTo = "groupusers";
        
        foreach ($users as $user) {
            $this->addElement("checkbox", $user->user_id, array(
                "label" => $user->username,
                "value" => $user->in_group ? 1 : 0
            ));
        }
        
        $this->init();
    }
}

?>
