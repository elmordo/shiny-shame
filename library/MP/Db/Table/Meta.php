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
class MP_Db_Table_Meta extends Zend_Db_Table_Abstract {
    
    protected $_referenceColumn = null;
    
    protected $_rowClass = "MP_Db_Table_Row_Meta";
    
    /**
     * vraci zaznam dle jeho id
     * 
     * @param int $id id zaznamu
     * @return MP_Db_Table_Row_Meta
     */
    public function findById($id) {
        return $this->find($id)->current();
    }
    
    /**
     * vraci zaznamy dle rodice
     * 
     * @param int $parentId identifikacni cilo rodice
     * @param string $order razeni
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findByParent($parentId, $order = null) {
        return $this->fetchAll(array(
            sprintf("%s = ?", $this->_referenceColumn) => $parentId
        ), $order);
    }
}
