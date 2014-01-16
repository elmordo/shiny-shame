<?php
class MP_Form extends Zend_Form {
	
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
}