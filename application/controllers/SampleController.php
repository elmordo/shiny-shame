<?php
require_once __DIR__ . "/ExperimentController.php";

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SampleController
 *
 * @author petr
 */
class SampleController extends MP_Controller_Action {
    
    /**
     *
     * @var Application_Model_Samples
     */
    protected $_sourceTable = "Application_Model_Samples";
    
    public function deleteAction() {
        $form = new MP_Form_Delete();
        $form->setElementsBelongTo("deletesample");
        
        if ($this->_request->isPost() && $form->isValid($this->_request->getParams())) {
            $sample = $this->findById($this->_request->getParam("sample_id"));
            $sample->delete();
            
            $this->view->isDeleted = true;
            $this->view->experiment = $this->findRowById($this->_request->getParam("experiment_id"), "Experiments");
        }
        
        $this->view->form = $form;
    }
    
    public function getAction() {
        // nacteni dat
        $experiment = self::findRowById($this->_request->getParam("experiment_id"), "Experiments");
        $sample = self::findRowById($this->_request->getParam("sample_id"), "Samples");
        
        $this->view->experiment = $experiment;
        $this->view->sample = $sample;
    }
    
    public function indexAction() {
        // nacteni experimentu
        $experiment = self::findRowById($this->_request->getParam("experiment_id"), "Experiments");
        
        // nacteni vzorku
        $samples = $this->_sourceTable->findByExperiment($experiment);
        
        $this->view->experiment = $experiment;
        $this->view->samples = $samples;
    }
    
    public function postAction() {
        $form = new Application_Form_Sample();
        $url = $this->view->url($this->_request->getParams(), "sample-post");
        $form->setAction($url);
        
        if ($this->_request->isPost() && $form->isValid($this->_request->getParams())) {
            $row = $this->_sourceTable->createRow();
            $row->setFromArray($form->getValues(true));
            $row->experiment_id = $this->_request->getParam("experiment_id");
            $row->user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
            $row->save();
            
            $this->view->row = $row;
        }
        
        $this->view->form = $form;
    }
    
    public function putAction() {
        $form = new Application_Form_Sample();
        $sample = $this->findById($this->_request->getParam("sample_id"), "Samples");
        $form->populate($sample->toArray());

        $url = $this->view->url($this->_request->getParams(), "sample-put");
        $form->setAction($url);
        
        if ($this->_request->isPost() && $form->isValid($this->_request->getParams())) {
            $sample->setFromArray($form->getValues(true));
            $sample->save();
        }
        
        $this->view->sample = $sample;
        $this->view->form = $form;
    }
}

?>
