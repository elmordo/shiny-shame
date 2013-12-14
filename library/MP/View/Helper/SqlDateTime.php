<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SqlDateTime
 *
 * @author petr
 */
class MP_View_Helper_SqlDateTime {
    
    /**
     * prevede datum a cas z formatu SQL na "lidsky" format
     * 
     * @param string $dateTime datum a cas ve formatu SQL
     * @return string
     */
    public function sqlDateTime($dateTime) {
        return str_replace(" ", " at ", str_replace("-", "/", $dateTime));
    }
}

?>
