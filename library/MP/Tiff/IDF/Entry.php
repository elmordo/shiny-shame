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
    
    /**
     * id tagu
     * 
     * @var int
     */
    private $_tag;
    
    /**
     * datovy typ zaznamu
     *
     * @var int
     */
    private $_type;
    
    /**
     * pocet hodnot
     *
     * @var int
     */
    private $_count;
    
    /**
     * hodnota tagu
     *
     * @var mixed
     */
    private $_value;
    
    /**
     * pokud jsou predany hodnoty, inicializuje instanci
     * 
     * @param array|string $data vstupni data pro inicializaci
     * @param int $pos pozice v datech (pouze pokud je $data retezec)
     */
    public function __construct($data = null, $pos = -1) {
        
    }
    
    /**
     * vraci pocet hodnot
     * 
     * @return int
     */
    public function getCount() {
        return $this->_count;
    }
    
    /**
     * vraci identifikator tagu
     * 
     * @return int
     */
    public function getTag() {
        return $this->_tag;
    }
    
    /**
     * vraci identifikator datoveho typu
     * 
     * @return int
     */
    public function getType() {
        return $this->_type;
    }
    
    /**
     * vraci hodnotu
     * 
     * @return mixed
     */
    public function getValue() {
        return $this->_value;
    }
    
    /**
     * nastavi data instance z pole
     * 
     * @param array $data asociativni pole dat
     * @return \MP_Tiff_IDF_Entry
     */
    public function setFromArray(array $data) {
        // nastaveni dat z pole
        foreach ($data as $key => $val) {
            switch ($key) {
                case self::ITEM_COUNT:
                    $this->_count = (int) $val;
                    break;
                
                case self::ITEM_TAG:
                    $this->setTag($val);
                    break;
                
                case self::ITEM_TYPE:
                    $this->setType($val);
                    break;
                
                case self::ITEM_VALUE:
                    $this->_value = (int) $val;
            }
        }
        
        return $this;
    }
    
    /**
     * nastavi id tagu
     * id musi byt jednim z konstant zacinajicich TAG_
     * 
     * @param int $tag nove id tagu
     * @return \MP_Tiff_IDF_Entry
     * @throws MP_Tiff_IDF_Exception
     */
    public function setTag($tag) {
        // kontrola spravneho tagu
        switch ($tag) {
            case self::TAG_COMPRESSION:
            case self::TAG_IMAGE_LENGTH:
            case self::TAG_IMAGE_WIDTH:
            case self::TAG_PHOTOMETRIC_INTERPRETATION:
            case self::TAG_RES_UNIT:
            case self::TAG_ROWS_PER_STRIP:
            case self::TAG_STRIP_BYTE_COUNT:
            case self::TAG_STRIP_OFFSET:
            case self::TAG_X_RES:
            case self::TAG_Y_RES:
                $this->_tag = $tag;
                break;
            
            default:
                throw new MP_Tiff_IDF_Exception(sprintf("Invalid tag %d", $tag));
        }
        
        return $this;
    }
    
    /**
     * nastavi novy datovy typ zaznamu
     * datovy typ musi byt jednim z konstant zacinajicich TYPE_
     * @param type $type
     * @return \MP_Tiff_IDF_Entry
     * @throws MP_Tiff_IDF_Exception
     */
    public function setType($type) {
        // kontrola, jeslti je typ podporovany
        switch ($type) {
            case self::TYPE_BYTE:
            case self::TYPE_CHAR:
            case self::TYPE_DOUBLE:
            case self::TYPE_FLOAT:
            case self::TYPE_LONG:
            case self::TYPE_RATIONAL:
            case self::TYPE_SBYTE:
            case self::TYPE_SHORT:
            case self::TYPE_SLONG:
            case self::TYPE_SRATIONAL:
            case self::TYPE_SSHORT:
            case self::TYPE_UNDEFINED:
                $this->_type = $type;
                break;
            
            default:
                throw new MP_Tiff_IDF_Exception(sprintf("Invalid date type %d", $type));
        }
        
        return $this;
    }
}

?>
