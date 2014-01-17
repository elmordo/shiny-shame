<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group
 *
 * @author petr
 */
class Application_Model_Row_Group extends Zend_Db_Table_Row_Abstract {
    
    const FIND_ALL = 1;
    const FIND_REG = 2;
    const FIND_UNREG = 3;
    
    public function findUsers($who = self::FIND_ALL) {
        
        $select = new Zend_Db_Select($this->_table->getAdapter());
        $nameUsers = MP_Db_Table::getRealName("Application_Model_Users");
        $nameAssocs = MP_Db_Table::getRealName("Application_Model_UsersHaveGroups");
        
        $select->from(array("u" => $nameUsers), array("u.*", "in_group" => new Zend_Db_Expr("IFNULL(a.group_id, 0)")));
        $select->joinLeft(array("a" => $nameAssocs), "u.user_id = a.user_id and a.group_id = " . $this->group_id, array());
        
        return new Zend_Db_Table_Rowset(array(
            "data" => $select->query()->fetchAll(),
            "stored" => true
        ));
    }
    
    public function setUsers(array $values) {
        $tableAssocs = new Application_Model_UsersHaveGroups();
        
        // smazani starych dat
        $tableAssocs->delete(array(
            "group_id = ?" => $this->group_id
        ));
        
        // vytvoreni novych
        $items = array();
        $pattern = "(" . $this->group_id . ", ";
        
        foreach ($values as $id => $in) {
            if ($in) {
                $items[] = $pattern . $id . ")";
            }
        }
        
        if ($items) {
            $nameAssocs = $tableAssocs->info("name");
            $sql = sprintf("INSERT INTO `%s` (`group_id`, `user_id`) VALUES %s", $nameAssocs, implode(", ", $items));
            
            $this->getTable()->getAdapter()->query($sql);
        }
    }
}

?>
