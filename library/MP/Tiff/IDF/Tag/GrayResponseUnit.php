<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GrayResponseUnit
 *
 * @author petr
 */
class MP_Tiff_IDF_Tag_GrayResponseUnit extends MP_Tiff_IDF_Tag_Abstract {
    
    const TENTHS = 1;
    const HUNDREDTHS = 2;
    const THOUSANDTHS = 3;
    const TENTHOUSANDTHS = 4;
    const HUNDREDTHOUSANDTHS = 5;
    
    protected $_allowedTypes = MP_Tiff_IDF_Entry::TYPE_SHORT;
    
    protected $_allowedValues = array(
        self::TENTHS,
        self::HUNDREDTHS,
        self::THOUSANDTHS,
        self::TENTHOUSANDTHS,
        self::HUNDREDTHOUSANDTHS
    );
    
    protected $_tagId = 290;
    
}

?>
