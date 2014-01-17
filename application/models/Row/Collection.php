<?php
class Application_Model_Row_Collection extends MP_Db_Table_Row implements MP_Db_Table_Row_DataAccess {
	
    /**
     * prida snimek do kolekce
     * 
     * @param Application_Model_Row_Frame $frame snimek k pridani
     * @return Application_Model_Row_Collection
     */
    public function addFrame($frame) {
        $frameId = $frame->frame_id;
        
        $tableAssocs = new Application_Model_CollectionsHaveFrames();
        
        try {
            $tableAssocs->insert(array(
                "frame_id" => $frameId,
                "collection_id" => $this->collection_id
            ));
        } catch (Zend_Exception $e) {
            
        }
        
        return $this;
    }
    
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