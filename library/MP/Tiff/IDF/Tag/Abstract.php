<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Abstract
 *
 * @author petr
 */
abstract class MP_Tiff_IDF_Tag_Abstract implements MP_Tiff_IDF_Tag_Interface {
    
    /**
     * obsahuje seznam povolenych typu
     * pokud obsahuje hodnotu NULL, pak vsechny typy jsou dovoleny
     *
     * @var NULL|array
     */
    protected $_allowedTypes = null;
    
    /**
     * obsahuje seznam povolenych hodnot
     * pokud je NULL, pak vsechny hodnoty jsou dovoleny
     *
     * @var NULL|mixed
     */
    protected $_allowedValues = null;
    
    /**
     * jmeno tagu
     *
     * @var int
     */
    protected $_tagName = null;
    
    /**
     * identifikator tagu
     *
     * @var int
     */
    protected $_tagId = null;
    
    public function __construct() {
        // kontrola jeslti je id tagu nastaveno
        if (is_null($this->_tagId)) {
            throw new MP_Tiff_IDF_Tag_Exception("Tag name and tag id have to be set");
        }
        
        // prevedeni povolenych typu a hodnot na pole
        if (!is_null($this->_allowedTypes)) {
            $this->_allowedTypes = (array) $this->_allowedTypes;
        }
        
        if (!is_null($this->_allowedValues)) {
            $this->_allowedValues = (array) $this->_allowedValues;
        }
        
        // kontrola vyplneni jmena tagu
        if (is_null($this->_tagName)) {
            $name = get_class($this);
            $this->_tagName = array_pop(explode("_", $name));
        }
    }
    
    /**
     * vraci dovolene typy
     * 
     * @return NULL|array
     */
    public function getAllowedTypes() {
        return $this->_allowedTypes;
    }
    
    /**
     * vraci seznam dovolenych hodnot
     * 
     * @return NULL|array
     */
    public function getAllowedValues() {
        return $this->_allowedValues;
    }
    
    /**
     * vraci identifikator tagu
     * 
     * @return string
     */
    public function getId() {
        return $this->_tagId;
    }
    
    /**
     * vraic jmeno tagu
     * 
     * @return string
     */
    public function getName() {
        return $this->_tagName;
    }


    /**
     * zkontroluje, jestli je hodnota a typ validni pro tag
     * 
     * @param int $type id datoveho typu
     * @param mixed $value zkoumana hodnota
     * @return boolean
     */
    public function isValueValid($type, $value) {
        // kontrola typu
        if (!is_null($this->_allowedTypes)) {
            if (!in_array($type, $this->_allowedTypes)) {
                return false;
            }
        }
        
        // kontrola hodnoty
        if (!is_null($this->_allowedValues)) {
            if (!in_array($value, $this->_allowedValues)) {
                return false;
            }
        }
        
        // vse je v poradku
        return true;
    }
}
?>
