<?php
class MP_Form extends Zend_Form {
    
    const PERMISIONS_SUBFORM = "permisions";
	
    /**
     * nejprve zkonstroluje, jestou jsou nejaka data k dipozici
     * 
     * @param $data kontrolovana data
     */
    public function isValid($data) {
        // vyhodnoceni, jestli je nastaveno elementsBelongsTo
        if ($this->_elementsBelongTo) {
            // vyhodnoceni jestli je tato hodnota v datech pritomna
            if (!isset($data[$this->_elementsBelongTo])) {
                return false;
            }
        }
        
        return parent::isValid($data);
    }
    
    public function getValues($suppressArrayNotation = false) {
        $retVal = parent::getValues($suppressArrayNotation);
        
        // kontrola subformularu, jestli tam je access permisions
        foreach ($this->getSubForms() as $name => $subForm) {
            if ($subForm instanceof MP_Form_AccessPermisions) {
                // odstraneni puvodni hodnoty
                unset($retVal[$subForm->getElementsBelongTo()]);
                
                // nacteni hodnot a zapis do navratove hodnoty
                $permData = $subForm->getPermisions();
                
                // zapis hodnot do navratove hodnoty
                $belongs = $this->getElementsBelongTo();
                
                if (!$suppressArrayNotation) {
                    $retVal[$belongs] += $permData;
                } else {
                    $retVal += $permData;
                }
            }
        }
        
        return $retVal;
    }
}