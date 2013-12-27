<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author petr
 */
interface MP_Tiff_IDF_Tag_Interface {
    
    /**
     * otestuje, jestli hodnota vyhovuje danemu tagu
     * 
     * @param int $type identifikator datoveho typu
     * @param mixed $value testovana hodnota
     * @return bool
     */
    public function isValueValid($type, $value);
}
?>
