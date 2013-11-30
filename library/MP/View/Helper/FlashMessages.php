<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FlashMessages
 *
 * @author petr
 */
class MP_View_Helper_FlashMessages extends Zend_View_Helper_Abstract {
    
    /**
     * vraci instanci helperu
     * 
     * @return \MP_View_Helper_FlashMessages
     */
    public function flashMessages() {
        return $this;
    }
    
    public function printMessages(array $config = array()) {
        $container = new Zend_Controller_Action_Helper_FlashMessenger();
        
        if (!$container->hasMessages()) return;
        
        $messages = $container->getMessages();
        $container->resetNamespace();
        
        $msgList = array();
        
        foreach ($messages as $msg) {
            $msgList[] = sprintf("<li>%s</li>", $msg);
        }
        
        // slouceni dat do retezce
        $msgStr = implode("", $msgList);
        
        // vytvoreni vystupu
        $retVal = sprintf("<div id='system-messages'><ul>%s</ul></div>", $msgStr);
        
        return $retVal;
    }
}

?>
