<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ButtonLink
 *
 * @author petr
 */
class MP_View_Helper_ButtonLink extends MP_View_Helper_Abstract {
    
    public function buttonLink($caption, $url, array $options = array(), $dialog=false) {
        $options = array_merge(array("class" => ""), $options, array("href" => $url));
        
        if ($dialog) {
            $options["class"] .= " dialog";
        }
        
        return "<span class='button-link'>" . $this->_wrapToTag("a", $caption, $options) . "</span>";
    }
}

?>
