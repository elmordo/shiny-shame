<?php
require_once __DIR__ . "/ExperimentController.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CollectionController
 *
 * @author petr
 */
class CollectionController extends MP_Controller_Action {
    
    protected $_sourceTable = "Application_Model_Collections";
    
    /**
     * aktualne zpracovavany experiment
     *
     * @var MP_Db_Table_Row
     */
    protected $_experiment = null;
    
    public function init() {
        parent::init();
        
        $experimentId = $this->_request->getParam("experiment_id");
        
        if ($experimentId) {
            $this->_experiment = self::findRowById($experimentId, "Experiments");
        }
    }
    
    public function deleteAction() {
        $form = new MP_Form_Delete();
        $form->setElementsBelongTo("deletecollection");
        
        if ($this->_request->isPost() && $form->isValid($this->_request->getParams())) {
            $collection = $this->findById($this->_request->getParam("collection_id"));
            
            if (!is_null($collection->tag)) {
                throw new Zend_Db_Table_Row_Exception("Collection with tag can not be deleted");
            }
            
            $collection->delete();
            $this->view->isDeleted = true;
            $this->view->experiment = $this->_experiment;
        }
        
        $this->view->deleteForm = $form;
    }
    
    public function getAction() {
        $experiment = $this->_experiment;
        $collection = $this->findById($this->_request->getParam("collection_id"));
        
        $this->view->collection = $collection;
        $this->view->experiment = $experiment;
    }
    
    /*
     * zobrazi seznam kolekci experimentu
     */
    public function indexAction() {
        // kontrola pristupu k experimentu
        $experiment = $this->_experiment;
        
        $tableCollections = new Application_Model_Collections();
        $collections = $tableCollections->findByExperiment($experiment->experiment_id);
        
        $this->view->experiment = $experiment;
        $this->view->collections = $collections;
    }
    
    public function postAction() {
        $form = new Application_Form_Collection();
        $experiment = $this->_experiment;
        
        // vyhodnoceni jestli byl formular odeslan jako POST
        if ($this->_request->isPost()) {
            // validace formulare
            if ($form->isValid($this->_request->getParams())) {
                // vytvoreni noveho zaznamu
                $tableCollections = new Application_Model_Collections();
                $row = $tableCollections->createCollection($form->getValues(true), $experiment);
                
                $this->view->row = $row;
            }
        }
        
        $this->view->form = $form;
        $this->view->experiment = $experiment;
    }
    
    public function putAction() {
        $experiment = $this->_experiment;
        $form = new Application_Form_Collection();
        $collection = $this->findById($this->_request->getParam("collection_id"));
        
        $form->populate($collection->toArray());
        
        // vyhodnoceni odeslani
        if ($this->_request->isPost()) {
            // kontrola validity
            if ($form->isValid($this->_request->getParams())) {
                // ulozeni dat
                $collection->setFromArray($form->getValues(true));
                $collection->save();
                
                $this->view->redirect = true;
            }
        }
        
        $this->view->form = $form;
        $this->view->collection = $collection;
        $this->view->experiment = $experiment;
    }
}

?>
