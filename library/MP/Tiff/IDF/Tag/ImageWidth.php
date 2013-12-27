<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageWidth
 *
 * @author petr
 */
class MP_Tiff_IDF_Tag_ImageWidth extends MP_Tiff_IDF_Tag_Abstract {
    
    protected $_allowedTypes = array(
        MP_Tiff_IDF_Entry::TYPE_SHORT,
        MP_Tiff_IDF_Entry::TYPE_LONG
    );
    
    protected $_tagId = 256;
    
}

?>
