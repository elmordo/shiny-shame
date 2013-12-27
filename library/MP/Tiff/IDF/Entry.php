<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entry
 *
 * @author petr
 */
class MP_Tiff_IDF_Entry {
    
    /*
     * identifikatory datovych typu 
     */
    const TYPE_BYTE = 1;
    const TYPE_CHAR = 2;
    const TYPE_SHORT = 3;
    const TYPE_LONG = 4;
    const TYPE_RATIONAL = 5;
    const TYPE_SBYTE = 6;
    const TYPE_UNDEFINED = 7;
    const TYPE_SSHORT = 8;
    const TYPE_SLONG = 9;
    const TYPE_SRATIONAL = 10;
    const TYPE_FLOAT = 11;
    const TYPE_DOUBLE = 12;
    
    /*
     * delky datovych typu
     */
    const LENGTH_BYTE = 1;
    const LENGTH_ASCII = -1;        // pouze pro uplnost - retezce jsou ukonceny znakem 0x0
    const LENGTH_SHORT = 2;
    const LENGTH_LONG = 4;
    const LENGTH_RATIONAL = 8;
    const LENGTH_SBYTE = 1;
    const LENGTH_UNDEFINED = 1;
    const LENGTH_SSHORT = 2;
    const LENGTH_SLONG = 4;
    const LENGTH_SRATIONAL = 8;
    const LENGTH_FLOAT = 4;
    const LENGTH_DOUBLE = 8;
    
    const TAG_PHOTOMETRIC_INTERPRETATION = 262;
    const TAG_COMPRESSION = 259;
    const TAG_IMAGE_LENGTH = 257;
    const TAG_IMAGE_WIDTH = 256;
    const TAG_RES_UNIT = 296;
    const TAG_X_RES = 282;
    const TAG_Y_RES = 283;
    const TAG_ROWS_PER_STRIP = 278;
    const TAG_STRIP_OFFSET = 273;
    const TAG_STRIP_BYTE_COUNT = 279;
    
    const WHITE_IS_ZERO = 0;
    const BLACK_IS_ZERO = 1;
    
    const COMPRESSION_NO = 1;
    const COMPRESSION_CCITT = 2;
    const COMPRESSION_PACK_BITS = 32773;
    
    const UNIT_NO = 1;
    const UNIT_INCH = 2;
    const UNIT_CM = 3;
    
    private $_tag;
    
    private $_type;
    
    private $_count;
    
    private $_value;
}

?>
