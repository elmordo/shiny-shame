<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Layout
 *
 * @author petr
 */
class MP_Controller_Plugin_Layout extends Zend_Controller_Plugin_Abstract {
    
    protected $_supportedLayouts = array("part", "json");
    
    /**
     * nastavi layout dle pripony pozadavku
     * 
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(\Zend_Controller_Request_Abstract $request) {
        // kontrola, jestli se ma novy layout nastavovat
        $action = $request->getActionName();
        
        if (!strpos($action, ".")) return;
        
        $parts = explode(".", $action);
        $layoutType = strtolower($parts[count($parts) - 1]);
        
        // kontrola, jestli je layout podporovan
        if (in_array($layoutType, $this->_supportedLayouts)) {
            // layout je podporovan - nastaveni layoutu
            Zend_Controller_Action_HelperBroker::getStaticHelper("viewRenderer")->view->layout()->setLayout("layout-" . $layoutType);
        }
    }
}

?>
