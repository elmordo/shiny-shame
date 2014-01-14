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
     * defaultni identita
     * @var type 
     */
    private $_identity = null;
    
    /**
     * pokud je alespon jeden z prcnich dvou parametru NULL vraci ACL pluginu
     * v opacnem pripade vraci navratovou hodnotu isAllowed
     * 
     * @param $resource zdroj
     * @param $action pozadovana akce
     * @param $identity testovana identita
     * @return Zend_Acl
     */
    public function acl($resource = null, $action = null, $identity = null) {
        if (!$this->_acl) {
            $this->_acl = Zend_Controller_Front::getInstance()->getPlugin("MP_Controller_Plugin_Acl")->getAcl();
        }
        
        // pokud je alespon jeden z prvnych parametru NULL, pak se vraci instance ACL
        if (is_null($resource) || is_null($action)) {
            return $this->_acl;
        }
        
        // kontrola nastaveni identity
        if (is_null($identity)) {
            if (is_null($this->_identity)) {
                $this->_identity = Zend_Auth::getInstance()->getIdentity();
            }
            
            $identity = $this->_identity;
        }
        
        return $this->_acl->isAllowed($identity, $resource, $action);
    }
}

?>
