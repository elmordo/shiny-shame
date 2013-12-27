<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Header
 *
 * @author petr
 */
class MP_Tiff_Header {
    
    const LITTLE_ENDIAN = "II";
    const BIG_ENDIAN = "MM";
    
    const TIFF_NUMBER = 42;
    
    const FORMAT_UINT16_BE = "n";
    const FORMAT_UINT16_LE = "v";
    const FORMAT_UINT32_BE = "N";
    const FORMAT_UINT32_LE = "V";
    
    const ITEM_OFFSET = "offset";
    const ITEM_ENDIAN = "endian";
    
    /**
     * urcuje poradi bytu 
     *
     * @var str
     */
    private $_endian;
    
    /**
     * obsahuje offset dat
     *
     * @var int
     */
    private $_dataOffset;
    
    public function __construct($data = null) {
        if (!is_null($data)) {
            // jsou k dispozici data - zpracuji se
            if (is_array($data)) {
                // nastaveni dat z pole
                $this->setFromArray($data);
            } else {
                // nastaveni dat z retezce
                // nacteni endianu
                $endian = substr($data, 0, 2);
                $this->setEndian($endian);

                // kontrola cisla oznacujiciho TIFF
                $fourtytwo = substr($data, 2, 2);

                if ($this->_endian == self::BIG_ENDIAN) {
                    $formatN = self::FORMAT_UINT16_BE;
                    $formatO = self::FORMAT_UINT32_BE;
                } else {
                    $formatN = self::FORMAT_UINT16_LE;
                    $formatO = self::FORMAT_UINT32_LE;
                }

                $number = unpack($formatN, $fourtytwo);

                if ($number != self::TIFF_NUMBER) {
                    throw new MP_Tiff_Exception("Bytes number 2 and 3 must contains number " . self::TIFF_NUMBER);
                }

                // nacteni offsetu
                $offsetStr = substr($data, 4, 4);
                $offset = unpack($formatO, $offsetStr);

                $this->_dataOffset = $offset;
            }
        }
    }
    
    /**
     * vraci poradi bytu
     * 
     * @return str
     */
    public function getEndian() {
        return $this->_endian;
    }
    
    /**
     * vraci offset dat
     * 
     * @return int
     */
    public function getOffset() {
        return $this->_dataOffset;
    }
    
    /**
     * vraci True, pokud je poradi Big Endian
     * 
     * @return bool
     */
    public function isBigEndian() {
        return $this->_endian == self::BIG_ENDIAN;
    }
    
    /**
     * vraci True, pokud je poradi bytu Little Endian
     * 
     * @return bool
     */
    public function isLittleEndian() {
        return $this->_endian == self::LITTLE_ENDIAN;
    }
    
    /**
     * nastavi poradi bytu na BE
     * 
     * @return \MP_Tiff_Header
     */
    public function setBigEndian() {
        $this->_endian = self::BIG_ENDIAN;
        
        return $this;
    }
    
    /**
     * nastavi nove poradi bytu
     * 
     * @param str $endian indikator poradi
     * @return \MP_Tiff_Header
     * @throws MP_Tiff_Exception
     */
    public function setEndian($endian) {
        switch ($endian) {
            case self::LITTLE_ENDIAN:
                $this->_endian = self::LITTLE_ENDIAN;
                break;
            
            case self::BIG_ENDIAN:
                $this->_endian = self::BIG_ENDIAN;
                break;
            
            default:
                throw new MP_Tiff_Exception("Invalid byte order set");
        }
        
        return $this;
    }
    
    /**
     * nastavi data hlavicky z pole
     * 
     * @param array $data vstupni data
     * @return \MP_Tiff_Header
     */
    public function setFromArray(array $data) {
        // prochazeni hodnot a jejich zapis
        foreach ($data as $key => $val) {
            switch ($key) {
                case self::ITEM_ENDIAN:
                    $this->setEndian($val);
                    break;
                
                case self::ITEM_OFFSET:
                    $this->setOffset($val);
                    break;
            }
        }
        
        return $this;
    }
    
    /**
     * nastavi poradi bytu na LE
     * 
     * @return \MP_Tiff_Header
     */
    public function setLittleEndian() {
        $this->_endian = self::LITTLE_ENDIAN;
        
        return $this;
    }
    
    /**
     * nastavi novy offset dat od zacatku souboru
     * novy offset musi byt vetsi nez 7 (kvuli hlavicce)
     * 
     * @param type $offset
     * @return \MP_Tiff_Header
     * @throws MP_Tiff_Exception
     */
    public function setOffset($offset) {
        if ($offset < 8) {
            throw new MP_Tiff_Exception("Data offset has to be bigger than 7");
        }
        
        $this->_dataOffset = $offset;
        return $this;
    }
}

?>
