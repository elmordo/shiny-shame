<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PhotometricInterpretation
 *
 * @author petr
 */
class MP_Tiff_IDF_Tag_Artist extends MP_Tiff_IDF_Tag_Abstract {
    
    const WHITE_IS_ZERO = 1;
    const BLACK_IS_ZERO = 2;
    const RGB = 3;
    const PALETTE = 4;
    const TRANSPARENCY_MASK = 5;
    
    protected $_allowedTypes = MP_Tiff_IDF_Entry::TYPE_SHORT;
    
    protected $_allowedValues = array(
        self::WHITE_IS_ZERO,
        self::BLACK_IS_ZERO,
        self::RGB,
        self::PALETTE,
        self::TRANSPARENCY_MASK
    );
    
    protected $_tagId = 262;
    
}

?>
