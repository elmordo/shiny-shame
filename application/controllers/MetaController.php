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
     * definuje jmeno parametru, ve kterem je ulozen prepinac administracniho modu
     */
    const REQUEST_PARAM_ADMIN = "ADMIN_MODE";

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
     * repinac typu rodicovskeho objektu
     *
     * @var string
     */
    protected $_metaType = null;
    
    /**
     * prepinac adminstracniho modu
     *
     * @var bool
     */
    protected $_adminMode = false;
    
    /**
     * prefix primarniho klice
     *
     * @var string 
     */
    protected $_metaPrimaryPrefix = null;
    
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
        $this->_metaType = $metaType;
        
        switch ($metaType) {
            case self::TYPE_BIO:
                $this->_table = new Application_Model_MetainfoBiological();
                $this->_metaPrimaryPrefix = "metainfo_biological_";
                break;
            
            case self::TYPE_TECH:
                $this->_table = new Application_Model_MetainfoTechnical();
                $this->_metaPrimaryPrefix = "metainfo_technical_";
                break;
            
            case self::TYPE_MICROSCOPE:
                $this->_table = new Application_Model_MetainfoMicroscopes();
                $this->_metaPrimaryPrefix = "metainfo_microscope_";
                break;
            
            default:
                // zadny podporovany typ -> vyjimka
                throw new Zend_Controller_Action_Exception(sprintf("Unsupported meta information type %s", $metaType));
        }
        
        // nactnei id rodicovskeho objektu
        $this->_parentId = $this->_request->getParam(self::REQUEST_PARAM_PARENT_ID);
        
        // nastaveni hodnot do view
        $this->view->parentId = $this->_parentId;
        $this->view->metaType = $metaType;
        $this->view->primaryPrefix = $this->_metaPrimaryPrefix;
        
        // vyhodnoceni administracniho prepinace
        if ($this->_request->getParam(self::REQUEST_PARAM_ADMIN, 0)) {
            // kontrola acl
            $acl = $this->getFrontController()->getPlugin("MP_Controller_Plugin_Acl")->getAcl();
            $user = Zend_Auth::getInstance()->getIdentity();
            
            if (!$acl->isAllowed($user, "meta", "admin")) throw new Zend_Acl_Exception("User can not change constant meta values");
            
            $this->_adminMode = true;
        }
    }
    
    /*
     * smaze meta informaci
     */
    public function deleteAction() {
        // nacteni a kontrola dat
        $form = new MP_Form_Delete();
        
        if ($form->isValid($this->_request->getParams())) {
            // nacteni a smazani polozky
            $meta = self::findMetaData($this->_request->getParam("metaId"), $this->_table);
            
            $meta->delete();
            
            $this->view->deleted = true;
        } else {
            // chyba - polozka nemuze byt smazana
            $this->view->deleted = false;
        }
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
        // vytvoreni formulare a nacteni dat
        $form = new Application_Form_MetaInfo();
        $form->enableAdminMode();
        
        $form->setAction($this->view->url(array(
            self::REQUEST_PARAM_NAME => $this->_metaType, 
            self::REQUEST_PARAM_PARENT_ID => $this->_parentId), "meta-post"));
        
        if ($this->_request->isPost()) {
            // validace formulare
            if ($form->isValid($this->_request->getParams())) {
                // vytvoreni noveho zaznamu
                $item = $this->_table->createMetaItem($form->getValues(true), $this->_parentId);
                
                $this->view->item = $item;
            }
        } else {
            $form->isValidPartial($this->_request->getParams());
        }
        
        $this->view->form = $form;
    }
    
    /**
     * upravi meta informaci
     */
    public function putAction() {
        $form = new Application_Form_MetaInfo();
        
        // pokud je aktivovan administracni mod, prepne se formular
        if ($this->_adminMode) {
            $form->enableAdminMode();
        }
        
        $meta = self::findMetaData($this->_request->getParam("metaId"), $this->_table);
        $form->populate($meta->toArray());
        
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getParams())) {
                $meta->setFromArray($form->getValues(true));
                $meta->save();
                
                $this->view->meta = $meta;
            }
        } else {
            $form->isValidPartial($this->_request->getParams());
            
            // nastaveni formulare smazani
            $deleteForm = new MP_Form_Delete();
            
            // nastaveni akce
            $action = sprintf("/meta/delete?%s=%s&%s=%s&metaId=%s", 
                    self::REQUEST_PARAM_NAME, 
                    $this->_metaType, 
                    self::REQUEST_PARAM_PARENT_ID, 
                    $this->_parentId,
                    $meta[$this->_metaPrimaryPrefix . "id"]);
            
            $deleteForm->setAction($action);
            
            $this->view->deleteForm = $deleteForm;
        }
        
        $this->view->form = $form;
    }
    
    /**
     * vraci zaznam z meta dat dle identifikacniho cisla
     * 
     * @param int $id identifikator zaznamu
     * @param MP_Db_Table_Meta $table tabulka meta dat
     * @return MP_Db_Table_Row_Meta
     * @throws Zend_Db_Table_Exception
     */
    public static function findMetaData($id, MP_Db_Table_Meta $table) {
        $retVal = $table->findById($id);
        
        if (is_null($retVal)) {
            throw new Zend_Db_Table_Exception(sprintf("Meta information #%s not found in table '%s'",
                    $id,
                    $table->info("name")));
        }
        
        return $retVal;
    }
}
