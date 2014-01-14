<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Abstract
 *
 * @author petr
 */
class MP_View_Helper_Abstract extends Zend_View_Helper_Abstract {
    
    /**
     * vygeneruje seznam tlacitek akci
     * $actions je asociativni pole kde:
     *  - klic je jmeno routy
     *  - hodnota je nastaveni odkazu
     * 
     * @param array $actions asociavni pole s akcemi
     * @param array $params parametri routy
     * @param string $separator oddelovac akci
     * @return string
     */
    protected function _generateRouteActions(array $actions, array $params, $separator = " ") {
        if (!$actions) {
            return "";
        }
        
        $actList = array();
        
        foreach ($actions as $route => $actionParams) {
            $actionParams = array_merge(array("target" => "_self"), $actionParams);
            
            $actList[] = $this->_generateRouteButtonLink($actionParams["caption"], $route, $params, $actionParams);
        }
        
        return implode($separator, $actList);
    }
    
    /**
     * vygeneruje tlacitkovy odkaz z routy, nazvu a parametru
     * 
     * @param string $caption popisek
     * @param string $route jmeno routy
     * @param array $params parametry routy
     * @return string
     */
    protected function _generateRouteButtonLink($caption, $route, array $params, array $config = array()) {
        $url = $this->view->url($params, $route);
        
        return $this->view->buttonLink($caption, $url, $config);
    }
    
    /**
     * zabali obsah do HTML tagu
     * pokud je $content NULL, pak vytvori neparovy tag
     * 
     * @param string $tag jmeno tagu
     * @param string $content obsah tagu
     * @param array $attributes atributy HTML tagu
     * @return string
     */
    protected function _wrapToTag($tag, $content = null, array $attributes = array()) {
        // vygenerovani seznam atributu
        $attrList = array();
        
        foreach ($attributes as $name => $value) {
            // pokud je hodnota NULL, pokracuje se
            if (!is_null($value)) {
                $attrList[] = sprintf("%s='%s'", $name, addslashes($value));
            }
        }
        
        $attrStr = implode(" ", $attrList);
        
        // vygenerovani dat
        if (is_null($content)) {
            return sprintf("<%s %s/>", $tag, $attrStr);
        } else {
            return sprintf("<%s %s>%s</%s>", $tag, $attrStr, $content, $tag);
        }
    }
}
?>
