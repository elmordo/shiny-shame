<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Groups
 *
 * @author petr
 */
class Application_Model_Groups extends MP_Db_Table {
    
    protected $_name = "groups";
    
    protected $_primary = "id";
    
    protected $_sequence = true;
    
    protected $_rowClass = "Application_Model_Row_Group";
    
    /**
     * nacte z databaze radek skupiny podle jebo id
     * 
     * @param int $id id skupiny
     * @return Application_Model_Row_Group
     */
    public function findById($id) {
        $select = $this->prepareSelect();
        $select->where("g.id = ?", $id);
        
        $data = $select->query()->fetch();
        
        return $this->_generateRow($data);
    }
    
    /**
     * vraci rozsireny seznam skupin
     * 
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findGroups() {
        $select = $this->prepareSelect();
        $select->group("g.id")->order("g.name");
        
        $data = $select->query()->fetchAll();
        
        return $this->_generateRowset($data);
    }
    
    /**
     * pripravy select pro rozsirene vyhledavani
     * 
     * @return \Zend_Db_Select
     */
    public function prepareSelect() {
        $nameThis = self::getRealName("Application_Model_Groups");
        $nameAssocs = self::getRealName("Application_Model_UsersHaveGroups");
        
        $select = new Zend_Db_Select($this->getAdapter());
        $select->from(array("g" => $nameThis), array("g.*"));
        $select->joinLeft(array("a" => $nameAssocs), "a.group_id = g.id", array("cnt" => new Zend_Db_Expr("COUNT(user_id)")));
        
        return $select;
    }
}

?>
