<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acl
 *
 * @author petr
 */
class MP_View_Helper_Acl extends Zend_View_Helper_Abstract {
    
    /**
     * cachovane ACL
     *
     * @var Zend_Acl
     */
    private $_acl = null;
    
    /**
     * vraci ACL pluginu
     * 
     * @return Zend_Acl
     */
    public function acl() {
        if (!$this->_acl) {
            $this->_acl = Zend_Controller_Front::getInstance()->getPlugin("MP_Controller_Plugin_Acl")->getAcl();
        }
        
        return $this->_acl;
    }
}

?>
