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
class CollectionController extends Zend_Controller_Action {
    
    /**
     *
     * @var Application_Model_Row_Experiment
     */
    protected $_experiment;
    
    /**
     * nacte experiment, pokud je k dispozici
     */
    public function init() {
        $experimentId = $this->_request->getParam("experiment_id");
        
        if (!is_null($experimentId)) {
            $tableExperiments = new Application_Model_Experiments();
            $this->_experiment = $tableExperiments->findById($experimentId);
        }
    }
    
    public function deleteAction() {
        $form = new MP_Form_Delete();
        $form->setElementsBelongTo("deletecollection");
        
        if ($this->_request->isPost() && $form->isValid($this->_request->getParams())) {
            $collection = self::findCollection($this->_request->getParam("collection_id"));
            
            if (!is_null($collection->tag)) {
                throw new Zend_Db_Table_Row_Exception("Collection with tag can not be deleted");
            }
            
            $experiment = ExperimentController::findExperiment($this->_request->getParam("experiment_id"));
            
            $collection->delete();
            $this->view->isDeleted = true;
            $this->view->experiment = $experiment;
        }
        
        $this->view->deleteForm = $form;
    }
    
    public function getAction() {
        $experiment = $this->_experiment;
        $collection = self::findCollection($this->_request->getParam("collection_id"));
        
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
        $collection = self::findCollection($this->_request->getParam("collection_id"));
        
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
    
    /**
     * nacte kolekci dle id
     * 
     * @param int $id id kolekce
     * @return Application_Model_Row_Collection
     */
    public static function findCollection($id) {
        $tableCollections = new Application_Model_Collections();
        $collection = $tableCollections->findById($id);
        
        if (!$collection) {
            throw new Zend_Db_Table_Exception(sprintf("Collection #%d not found", $id));
        }
        
        return $collection;
    }
}

?>
