<?php
class Application_Model_Row_Frame extends Zend_Db_Table_Row_Abstract {
	
    const POSTFIX_SMALL = "_small";
    const POSTFIX_FULL = "_full";
    
    const PREFIX = "prev_";
    
    /**
     * najde seznam kolekci, kterych je snimek clenem
     * 
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findCollections() {
        $tableCollections = new Application_Model_Collections();
        $select = $tableCollections->prepareSelect();
        
        $select->where("a.frame_id = ?", $this->frame_id);
        
        return $tableCollections->_generateRowset($select->query()->fetchAll());
    }
    
    /**
     * vraci cestu k velkemu nahledu
     * 
     * @return string
     */
    public function getFullPath() {
        return $this->_getPath(self::POSTFIX_FULL);
    }
    
    /**
     * vraci cestu k malemu nahledu
     * 
     * @return string
     */
    public function getSmallPath() {
        return $this->_getPath(self::POSTFIX_SMALL);
    }
    
    /**
     * vraci verejnou cestu k velkemu nahledu
     * 
     * @return string
     */
    public function getPublicFullPath() {
        return $this->_getPublicPath(self::POSTFIX_FULL);
    }
    
    /**
     * vraci verejnou cestu k malemu nahledu
     * 
     * @return string
     */
    public function getPublicSmallPath() {
        return $this->_getPublicPath(self::POSTFIX_SMALL);
    }
    
    public function getRepresentativeName() {
        list($date, $time) = explode(" ", $this->taken_at);
        
        $dateArr = explode("-", $date);
        $timeArr = explode(":", $time);
        
        return sprintf("%s_%s%s%s_%s%s%s_%d.%s", $this->tag, substr($dateArr[0], 2, 2), $dateArr[1], $dateArr[2], $timeArr[0], $timeArr[1], $timeArr[2], $this->ord, $this->format);
    }
    
    /**
     * nastavi soubor velkeho nahledu
     * 
     * @param string $source zdrojovy soubor
     */
    public function setFullPreview($source) {
        $this->_setPreview($source, $this->getFullPath());
    }
    
    /**
     * nastavi soubor maleho nahledu
     * 
     * @param string $source zdrojovy soubor
     */
    public function setSmallPreview($source) {
        $this->_setPreview($source, $this->getSmallPath());
    }
    
    /**
     * smaze soubory nahledu
     */
    protected function _delete() {
        parent::_delete();
        
        $full = $this->getFullPath();
        $small = $this->getSmallPath();
        
        if (is_file($full)) {
            unlink($full);
        }
        
        if (is_file($small)) {
            unlink($small);
        }
    }

    /**
     * vraci zakladni cestu k souboru
     * 
     * @return string
     */
    private function _getPath($postfix) {
        return sprintf("%s/%s%d%s.jpeg", IMAGE_PREVIEW_PATH, self::PREFIX, $this->frame_id, $postfix);
    }
    
    /**
     * vraci verejnou cestu k souboru
     * 
     * @return string
     */
    private function _getPublicPath($postfix) {
        return sprintf("%s/%s%d%s.jpeg", IMAGE_PREVIEW_PUBLIC, self::PREFIX, $this->frame_id, $postfix);
    }
    
    /**
     * prekopiruje soubor z mista na misto
     * 
     * @param string $source zdrojovy soubor
     * @param string $target cilove umisteni
     */
    private function _setPreview($source, $target) {
        // pokud soubor existuje, odebere se
        if (is_file($target)) {
            unlink($target);
        }
        
        copy($source, $target);
    }
}
