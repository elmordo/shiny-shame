<?php

class Application_Model_Experiments extends MP_Db_Table {

    protected $_name = "experiments";
    
    protected $_primary = array("experiment_id");
    
    protected $_sequence = true;
    
    protected $_referenceMap = array(
        "user" => array(
            "columns" => "user_id",
            "refTableClass" => "Application_Model_Users",
            "refColumns" => "user_id"
        ),
        
        "microscope" => array(
            "columns" => "microscope_id",
            "refTableClass" => "Application_Model_Microscopes",
            "refColumns" => "microscope_id"
        )
    );
    
    protected $_rowClass = "Application_Model_Row_Experiment";
    
    protected $_markups = array(
        array(
            "source" => "comment",
            "target" => "comment_html",
            "parser" => self::MARKUP_DEFAULT_PARSER,
            "renderer" => self::MARKUP_DEFAULT_RENDERER
        )
    );
    
    protected $_markupsEnabled = true;
    
    /**
     * vytvori a ulozi experiment
     * 
     * @param array $data data z formulare experimentu
     * @param Application_Model_Row_User|int $user uzivatel (radek nebo jen jeho id)
     * @return Application_Model_Row_Experiment
     */
    public function createExperiment(array $data, $user) {
        // vyhodnoceni jestli je uzivatel predan jako objekt nebo jako cislo
        if (is_object($user)) {
            $userId = $user->user_id;
        } else {
            $userId = $user;
        }
        
        $retVal = $this->createRow($data);
        $retVal->user_id = $userId;
        
        $retVal->save();
        
        return $retVal;
    }
    
    /**
     * nacte experiment dle id
     * 
     * @param int $id id experimentu
     * @return Application_Model_Row_Experiment
     */
    public function findById($id) {
        // priprava selectu
        $select = $this->prepareSelect();
        $select->where("et.experiment_id = ?", $id);
        
        return $this->_generateRowset($select->query()->fetchAll())->current();
    }

    /**
     * nacte experimenty dle id uzivatele
     * 
     * @param Application_Model_Row_User|int $user uzivatel nebo jeho id
     * @param string $order sloupec, podle ktereho se bude radit
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function findByUser($user, $order = "created_at desc") {
        if (is_object($user)) {
            $userId = $user->user_id;
        } else {
            $userId = $user;
        }
        
        // vytvoreni selectu
        $select = $this->prepareSelect();
        $select->where("et.user_id = ?", $userId)->order($order);
        
        $retVal = $this->_generateRowset($select->query()->fetchAll());
        
        return $retVal;
    }
    
    /**
     * pripravi a vraci zakladni dotaz pro rozsirene hledani experimentu
     * k tabulce pripojuje i informace o uzivateli a mikroskopu
     * 
     * @return Zend_Db_Select
     */
    public function prepareSelect() {
        $select = new Zend_Db_Select($this->getAdapter());
        
        $select->from(array("et" => $this->_name));
        
        // pripojeni mikroskopu
        $nameMicroscopes = self::getRealName("Application_Model_Microscopes");
        
        $select->joinLeft(array("mt" => $nameMicroscopes), "mt.microscope_id = et.microscope_id", array("microscope_name" => "mt.name"));
        
        // pripojeni uzivatele
        $nameUsers = self::getRealName("Application_Model_Users");
        
        $select->joinLeft(array("ut" => $nameUsers), "ut.user_id = et.user_id", array("username"));
        
        return $select;
    }
    
}
