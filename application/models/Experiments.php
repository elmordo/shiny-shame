<?php

class Application_Model_Experiments extends Zend_Db_Table_Abstract {

    protected $_name = "experiments";
    
    protected $_primary = array("id");
    
    protected $_sequence = true;
    
    protected $_referenceMap = array(
        "user" => array(
            "columns" => "user_id",
            "refTableClass" => "Application_Model_Users",
            "refColumns" => "id"
        ),
        
        "microscope" => array(
            "columns" => "microscope_id",
            "refTableClass" => "Application_Model_Microscopes",
            "refColumns" => "id"
        )
    );
    
    protected $_rowClass = "Application_Model_Row_Experiment";

    /**
     * nacte experimenty dle id uzivatele
     * 
     * @param Application_Model_Row_User|int $user uzivatel nebo jeho id
     * @param string $order sloupec, podle ktereho se bude radit
     * @return Zend_Db_Table_Rowset_Abstract
     */
    function findByUser($user, $order = "created_at desc") {
        if (is_object($user)) {
            $userId = $user->id;
        } else {
            $userId = $user;
        }
        
        return $this->fetchAll(array(
            "user_id = ?" => $userId
        ), $order);
    }
}
