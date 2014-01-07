<?php
class Application_Model_Row_Collection extends MP_Db_Table_Row implements MP_Db_Table_Row_DataAccess {
	
    public function getAccessPermisions() {
        return $this->access_permisions;
    }
    
    public function getGroupId() {
        return $this->group_id;
    }
    
    public function getOwnerId() {
        return $this->user_id;
    }
}