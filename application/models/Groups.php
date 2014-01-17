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
    
    /**
     * obsahuje seznam radku existujicich skupin
     *
     * @var Zend_Db_Table_Rowset_Abstract
     */
    protected static $_groups = null;
    
    /**
     * obsahuje asociativni pole klic hodnota
     * klic je id skupiny
     * hodnota je jmeno skupiny
     *
     * @var array
     */
    protected static $_groupSelect = null;
    
    protected $_name = "groups";
    
    protected $_primary = "group_id";
    
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
        $select->where("g.group_id = ?", $id);
        
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
        $select->group("g.group_id")->order("g.name");
        
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
        $select->joinLeft(array("a" => $nameAssocs), "a.group_id = g.group_id", array("cnt" => new Zend_Db_Expr("COUNT(user_id)")));
        
        return $select;
    }
    
    /**
     * vraci seznam skupin jako rowset
     * 
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public static function getGroups() {
        if (is_null(self::$_groupSelect)) {
            self::_cacheGroups();
        }
        
        return self::$_groups;
    }
    
    /**
     * vraci asociativni pole klic hodnota
     * klic je id skupiny
     * hodnota je jmeno skupiny
     * 
     * @return array
     */
    public static function getGroupsIndex() {
        if (is_null(self::$_groupSelect)) {
            self::_cacheGroups();
        }
        
        return self::$_groupSelect;
    }
    
    protected static function _cacheGroups() {
        $table = new self();
        $groups = $table->findGroups();
        
        // zapsani radku
        self::$_groups = $groups;
        
        // vytvoreni asociativniho pole
        $index = array();
        
        foreach ($groups as $group) {
            $index[$group->group_id] = $group->name;
        }
        
        self::$_groupSelect = $index;
    }
}

?>
