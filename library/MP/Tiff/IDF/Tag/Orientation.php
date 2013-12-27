<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Orientation
 *
 * @author petr
 */
class MP_Tiff_IDF_Tag_Orientation extends MP_Tiff_IDF_Tag_Abstract {
    
    const TOP_LEFT = 1;
    const TOP_RIGHT = 2;
    const BOTTOM_RIGHT = 3;
    const BOTTOM_LEFT = 4;
    const LEFT_TOP = 5;
    const RIGHT_TOP = 6;
    const RIGHT_BOTTOM = 7;
    const LEFT_BOTTOM = 8;
    
    protected $_allowedTypes = MP_Tiff_IDF_Entry::TYPE_SHORT;
    
    protected $_allowedValues = array(
        self::BOTTOM_LEFT,
        self::BOTTOM_RIGHT,
        self::LEFT_BOTTOM,
        self::LEFT_TOP,
        self::RIGHT_BOTTOM,
        self::RIGHT_TOP,
        self::TOP_LEFT,
        self::TOP_RIGHT
    );
    
    protected $_tagId = 274;
    
}

?>
