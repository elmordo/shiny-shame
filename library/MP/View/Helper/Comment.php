<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comment
 *
 * @author petr
 */
class MP_View_Helper_Comment extends MP_View_Helper_Abstract {
    
    /**
     * wrap content to unified HTML code
     * 
     * @param string $data content of content
     * @param string $header headline of section
     * @return string
     */
    public function comment($data, $header = "Comment") {
        $head = is_null($header) ? "" : $this->view->header($header);
        
        return $head . "<div class='comment'>" . $data . "</div>";
    }
}

?>
