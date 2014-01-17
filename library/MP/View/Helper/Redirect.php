<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Redirect
 *
 * @author petr
 */
class MP_View_Helper_Redirect extends Zend_View_Helper_Abstract {
    
    /**
     * provede presmerovani
     * 
     * @param string $route URL nebo jmeno routy pro presmerovani
     * @param bool $exit pokud je True, po presmerovani se ukonci beh
     * @param array $params parametry routy, pokud jsou NULL, je v $route ulozena URL
     */
    public function redirect($route, $exit = true, array $params = null) {
        if (!is_null($params)) {
            $route = $this->view->url($params, $route);
        }
        
        // vytvoreni redirectoru a provedeni presmerovani
        $redirector = new Zend_Controller_Action_Helper_Redirector();
        
        if ($exit) {
            $redirector->gotoUrlAndExit($route);
        } else {
            $redirector->gotoUrl($route);
        }
    }
}

?>
