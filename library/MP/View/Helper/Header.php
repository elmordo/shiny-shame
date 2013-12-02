<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Header
 *
 * @author petr
 */
class MP_View_Helper_Header extends Zend_View_Helper_Abstract {
    
    private $_level = 1;

    /**
     * zvysi uroven nadpisu o jednicku
     * 
     * @return \MP_View_Helper_Header
     */
    public function goUp() {
        if ($this->_level > 1)
            $this->_level--;
        
        return $this;
    }
    
    /**
     * snizi uroven nadpisu o jednucku
     * 
     * @return \MP_View_Helper_Header
     */
    public function goDown() {
        $this->_level++;
        
        return $this;
    }
    
    /**
     * pokud je definovan $text, vytvori nadpis
     * v opacnem pripade vraci instanci
     * 
     * @param string $text obsah nadpisu
     * @param array $config konfigurace
     * @return string|\MP_View_Helper_Header
     */
    public function header($text = null, array $config = array()) {
        // pokud text nebyl zadan, pak se vraci instance
        if (is_null($text)) return $this;
        
        // vyhodnoceni urovne
        $level = $this->_level > 6 ? 6 : $this->_level;
        
        return sprintf("<h%s>%s</h%s>", $level, $text, $level);
    }

}

?>
