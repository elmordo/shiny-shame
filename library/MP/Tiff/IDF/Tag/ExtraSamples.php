<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExtraSamples
 *
 * @author petr
 */
class MP_Tiff_IDF_Tag_ExtraSamples extends MP_Tiff_IDF_Tag_Abstract {
    
    const EXTRA_SAMPLES_UNSPECIFIED = 1;
    const EXTRA_SAMPLES_ASSOCIATED_ALPHA = 2;
    const EXTRA_SAMPLES_UNASSOCIATED_ALPHA = 3;
    
    protected $_allowedTypes = MP_Tiff_IDF_Entry::TYPE_SHORT;
    
    protected $_allowedValues = array(
        self::EXTRA_SAMPLES_ASSOCIATED_ALPHA,
        self::EXTRA_SAMPLES_UNASSOCIATED_ALPHA,
        self::EXTRA_SAMPLES_UNSPECIFIED
    );
    
    protected $_tagId = 338;
    
}

?>
