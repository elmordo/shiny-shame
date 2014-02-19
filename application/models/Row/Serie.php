<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Serie
 *
 * @author petr
 */
class Application_Model_Row_Serie extends MP_Db_Table_Row implements MP_Db_Table_Row_DataAccess {
    
    /**
     * seznam kolekci pripojenych k experimentu
     *
     * @var Zend_Db_Table_Rowset_Abstract
     */
    private $_collections = null;
    
    public function findCollections() {
        if (is_null($this->_collections)) {
            $tableCollections = new Application_Model_Collections();
            $this->_collections = $tableCollections->fetchAll(array("serie_id = ?" => $this->serie_id), "name");
        }
        
        return $this->_collections;
    }
    
    public function getOwnerId() {
        return $this->user_id;
    }
    
    public function getGroupId() {
        return $this->group_id;
    }
    
    public function getAccessPermisions() {
        return $this->access_permisions;
    }
    
}

?>
