<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Compression
 *
 * @author petr
 */
class MP_Tiff_IDF_Tag_Compression extends MP_Tiff_IDF_Tag_Abstract {
    
    const COMPRESSION_NO = 1;
    const COMPRESSION_CCITT = 2;
    const COMPRESSION_PACK = 32773;
    
    protected $_allowedTypes = MP_Tiff_IDF_Entry::TYPE_SHORT;
    
    protected $_allowedValues = array(
        self::COMPRESSION_NO,
        self::COMPRESSION_CCITT,
        self::COMPRESSION_PACK
    );
    
    protected $_tagId = 259;
    
}

?>
