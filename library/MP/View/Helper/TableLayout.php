<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TableLayout
 *
 * @author petr
 */
class MP_View_Helper_TableLayout extends Zend_View_Helper_Abstract {
    
    public function cell($data, array $config = array()) {
        $config = array_merge(array("cellClasses" => ""), $config);
        
        return $this->_cell($data, $config);
    }
    
    public function row(array $data, array $config = array()) {
        $config = array_merge(array("rowClasses" => "", "cellClasses" => "", "cellTag" => "td"), $config);
        
        return $this->_row($data, $config);
    }
    
    public function tableLayout(array $data = null, array $config = array()) {
        if (is_null($data)) return $this;
    }
    
    private function _cell($data, array $config) {
        $classes = $this->_classes($config["cellClasses"]);
        
        return $this->_wrap($data, $config["cellTag"], $classes);
    }
    
    /**
     * pripravi data trid jako rezec
     * 
     * @param mixed $data data trid
     * @return string
     */
    private function _classes($data) {
        if (is_array($data)) {
            return implode(" ", $data);
        }
        
        // vstup je patrne retezec
        return $data;
    }
    
    private function _row($data, array $config) {
        // riprava trid
        $classes = $this->_classes($config["rowClasses"]);
        
        // vygenerovani sloupci
        $cells = array();
        
        foreach ($data as $item) {
            $cells[] = $this->_cell($item, $config);
        }
        
        $cellsStr = implode("", $cells);
        
        return $this->_wrap($cellsStr, "tr", $classes);
    }

    /**
     * zabali obsah do tagu
     * 
     * @param string $content
     * @param string $tag
     * @param string $classes
     * @return string
     */
    private function _wrap($content, $tag, $classes) {
        return sprintf("<%s class='%s'>%s</%s>", $tag, $classes, $content, $tag);
    }
}

?>
