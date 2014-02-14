<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sample
 *
 * @author petr
 */
class Zend_View_Helper_Sample extends MP_View_Helper_Abstract {
    
    public function sample($sample = null, array $config = array()) {
        if (is_null($sample)) return $this;
    }
    
    public function samples($samples, array $config = array()) {
        
        $rows = "<thead><tr><th>Name</th><th>Series</th><th>Actions</th></tr></thead><tbody>";
        
        foreach ($samples as $sample) {
            $rows .= sprintf("<tr><td>%s</td><td>%d</td><td>%s</td></tr>", 
                    $sample->name, 
                    $sample->series,
                    $this->_generateRouteButtonLink("Show", "sample-get", $sample->toArray(), $config));
        }
        
        $rows .= "</tbody>";
        
        return $this->_wrapToTag("table", $rows);
    }
}

?>
