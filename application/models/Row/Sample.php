<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Samples
 *
 * @author petr
 */
class Application_Model_Row_Sample extends MP_Db_Table_Row implements MP_Db_Table_Row_DataAccess {
    
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
