<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MetaController
 *
 * @author petr
 */
class MetaController extends Zend_Controller_Action {
    
    /*
     * konstanty definujici typ metadat, se kterymi se bude pracovat
     */
    const TYPE_MICROSCOPE = "MICROSCOPE";
    const TYPE_BIO = "BIO";
    const TYPE_TECH = "TECH";
    
    /*
     * definuje jmeno parametru, ve kterem je ulozen typ metadat
     */
    const REQUEST_PARAM_NAME = "META_TYPE";
    
    /*
     * definuje jmeno parametru, kde je v requestu ulozeno id rodicovskeho objketu
     */
    const REQUEST_PARAM_PARENT_ID = "PARENT_ID";

    /**
     * tabulka metainformace
     *
     * @var MP_Db_Table_Meta
     */
    protected $_table = null;
    
    /**
     * identifikacni cislo rodicovskeho objketu nacteneho z dotazu
     *
     * @var int
     */
    protected $_parentId = null;
    
    /**
     * nastavi tabulku s metadaty, se kterou se bude pracovat
     * 
     * @throws Zend_Controller_Action_Exception
     */
    public function init() {
        
        // kontrola, jstli je nastaven request
        if (is_null($this->_request)) {
            throw new Zend_Controller_Action_Exception("Request is not set");
        }
        
        // vyhodnoceni typu. Pokud typ neni nastaven -> vyjimka
        $metaType = $this->_request->getParam(self::REQUEST_PARAM_NAME);
        
        switch ($metaType) {
            case self::TYPE_BIO:
                $this->_table = new Application_Model_MetainfoBiological();
                break;
            
            case self::TYPE_TECH:
                $this->_table = new Application_Model_MetainfoTechnical();
                break;
            
            case self::TYPE_MICROSCOPE:
                $this->_table = new Application_Model_MetainfoMicroscopes();
                break;
            
            default:
                // zadny podporovany typ -> vyjimka
                throw new Zend_Controller_Action_Exception(sprintf("Unsupported meta information type %s", $metaType));
        }
        
        // nactnei id rodicovskeho objektu
        $this->_parentId = $this->_request->getParam(self::REQUEST_PARAM_PARENT_ID);
    }
    
    /*
     * smaze meta informaci
     */
    public function deleteAction() {
        
    }
    
    /**
     * zobrazi seznam metainformaci jako samostatnou stranku
     * 
     * @throws Zend_Controller_Action_Exception
     */
    public function indexAction() {
        // rodicovsky objekt nesmi byt prazdny
        if (is_null($this->_parentId)) {
            throw new Zend_Controller_Action_Exception("Parent id is null");
        }
        
        // nacteni dat dle rodicovskeho objektu
        $items = $this->_table->findByParent($this->_parentId, "name");
        
        $this->view->items = $items;
    }
    
    /**
     * zobrazi seznam meta informaci jako fragment stranky
     */
    public function indexPartAction() {
        $this->indexAction();
    }
    
    /**
     * nova meta informace
     */
    public function postAction() {
        
    }
    
    /**
     * upravi meta informaci
     */
    public function putAction() {
        
    }
    
    /**
     * vraci zaznam z meta dat dle identifikacniho cisla
     * 
     * @param int $id identifikator zaznamu
     * @return MP_Db_Table_Row_Meta
     * @throws Zend_Db_Table_Exception
     */
    public static function findMetaData($id) {
        $retVal = $this->_table->findById($id);
        
        if (is_null($retVal)) {
            throw new Zend_Db_Table_Exception(sprintf("Meta information #%s not found in table '%s'",
                    $id,
                    $this->_table->info("name")));
        }
        
        return $retVal;
    }
}
