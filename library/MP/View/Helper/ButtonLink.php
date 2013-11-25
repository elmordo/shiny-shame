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
class MP_View_Helper_ButtonLink extends Zend_View_Helper_Abstract {
    
    public function buttonLink($caption, $url, $class = "button", $target = "_self") {
        return sprintf("<a href='%s' target='%s' class='%s'>%s</a>", $url, $target, $class, $caption);
    }
}

?>
