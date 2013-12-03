<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Meta
 *
 * @author petr
 */
class MP_Db_Table_Row_Meta extends Zend_Db_Table_Row_Abstract {
    
    /**
     * vraci identifikacni cislo rodicovskeho objektu
     * 
     * @return int
     */
    public function getParentId() {
        return $this[$this->getTable()->getReferenceColumn()];
    }
    
}
