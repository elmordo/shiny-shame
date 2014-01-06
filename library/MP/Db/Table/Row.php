<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Row
 *
 * @author petr
 */
class MP_Db_Table_Row extends Zend_Db_Table_Row_Abstract {
    
    protected $_dataAccess = "rwdr--r--";
    
    public function checkAccess($accessRequest, $identity = null) {
        // pokud radek neimplementuje rozhrani DataAccess, navratova hodnota je vzdy True
        if (!$this instanceof MP_Db_Table_Row_DataAccess) return true;
        
        // vyhodnoceni identity
        if (is_null($identity)) $identity = Zend_Auth::getInstance()->getIdentity();
        
        // vyhodnoceni offsetu prav
        $offset = MP_Db_Table_Row_DataAccess::ACCESS_OTHER;
        
        if ($identity) {
            // pokud je uzivatel admin, vraci se vzdy True
            if ($identity->role == MP_Role::ROLE_ADMIN) return true;
            
            // vyhodnoceni uzivatele a skupin
            if ($identity->id == $this->getOwnerId()) {
                $offset = MP_Db_Table_Row_DataAccess::ACCESS_USER;
            } elseif(null) {
                $offset = MP_Db_Table_Row_DataAccess::ACCESS_GROUP;
            }
        }
        
        // vyhodnoceni requestu
        switch ($accessRequest) {
            case MP_Db_Table_Row_DataAccess::ACCESS_READ:
                $offset += MP_Db_Table_Row_DataAccess::ACCESS_READ;
                return $this->_dataAccess[$offset] == MP_Db_Table_Row_DataAccess::VALUE_READ;
                break;
            
            case MP_Db_Table_Row_DataAccess::ACCESS_WRITE:
                $offset += MP_Db_Table_Row_DataAccess::ACCESS_WRITE;
                return $this->_dataAccess[$offset] == MP_Db_Table_Row_DataAccess::VALUE_WRITE;
                break;
            
            case MP_Db_Table_Row_DataAccess::ACCESS_DELETE:
                $offset += MP_Db_Table_Row_DataAccess::ACCESS_DELETE;
                return $this->_dataAccess[$offset] == MP_Db_Table_Row_DataAccess::VALUE_DELETE;
                break;
            
            default:
                throw new MP_Db_Table_Row_DataAccess_Exception(sprintf("invalid access request for %d", $accessRequest));
        }
    }
}

?>
