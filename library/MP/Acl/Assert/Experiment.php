<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Experiment
 *
 * @author petr
 */
class MP_Acl_Assert_Experiment implements Zend_Acl_Assert_Interface {
    
    public function assert(\Zend_Acl $acl, \Zend_Acl_Role_Interface $role = null, \Zend_Acl_Resource_Interface $resource = null, $privilege = null) {
        if (!$resource instanceof Application_Model_Row_Experiment) {
            return true;
        }
        
        // vyhodnoceni role
        if ($role->getRoleId() == MP_Role::ROLE_ADMIN) return true;
        
        return Zend_Auth::getInstance()->getIdentity()->id == $resource->user_id;
    }
}

?>
