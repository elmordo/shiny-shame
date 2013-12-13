<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SqlDate
 *
 * @author petr
 */
class MP_Validate_SqlDate extends Zend_Validate_Abstract {
    
    const INVALID = "INVALID_SQL_DATE";
    
    const CHECK_DATE = 0;
    const CHECK_TIME = 1;
    const CHECK_DATETIME = 3;
    const CHECH_DATE_AND_OR_TIME = 4;
    
    protected $_messageTemplates = array(
        self::INVALID => "Incorrect date format"
    );
    
    protected $_checkType;
    
    public function __construct($checkType = self::CHECH_DATE_AND_OR_TIME) {
        $this->_checkType = $checkType;
    }
    
    public function isValid($value) {
        // regularni vyraz pro kontrolu datumu a casu
        $regEx = "";
        
        switch ($this->_checkType) {
            case self::CHECK_DATE:
                
                break;
            
            case self::CHECK_TIME:
                
                break;
            
            case self::CHECK_DATETIME:
                
                break;
            
            case self::CHECH_DATE_AND_OR_TIME:
                
                break;
        }
        
        if (ereg($regEx, $value) !== false) {
            return true;
        } else {
            $this->_error(self::INVALID);
            return false;
        }
    }
    
}

?>
