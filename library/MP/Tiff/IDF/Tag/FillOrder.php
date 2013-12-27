<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FillOrder
 *
 * @author petr
 */
class MP_Tiff_IDF_Tag_FillOrder extends MP_Tiff_IDF_Tag_Abstract {
    
    const FILL_ORDER_LOWER = 1;
    const FILL_ORDER_HIGHER = 2;
    
    protected $_allowedTypes = MP_Tiff_IDF_Entry::TYPE_SHORT;
    
    protected $_allowedValues = array(
        self::FILL_ORDER_HIGHER,
        self::FILL_ORDER_LOWER
    );
    
    protected $_tagId = 266;
    
}

?>
