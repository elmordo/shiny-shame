<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersHaveGroups
 *
 * @author petr
 */
class Application_Model_UsersHaveGroups extends MP_Db_Table {
    
    protected $_name = "users_have_groups";
    
    protected $_primary = array("user_id", "group_id");
    
    protected $_sequence = false;
    
    protected $_referenceMap = array(
        "user" => array(
            "columns" => "user_id",
            "refTableClass" => "Application_Model_Users",
            "refColumns" => array("id")
        ),
        
        "group" => array(
            "columns" => "group_id",
            "refTableClass" => "Application_Model_Groups",
            "refColumns" => "id"
        )
    );
}

?>
