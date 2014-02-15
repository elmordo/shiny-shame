<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SerieController
 *
 * @author petr
 */
class SerieController extends MP_Controller_Action {
    
    protected $_sourceTable = "Application_Model_Series";
    
    public function deleteAction() {
        $form = new MP_Form_Delete();
        $form->setElementsBelongTo("deleteserie");
        
        if ($this->_request->isPost() && $form->isValid($this->_request->getParams())) {
            // nacteni dat
            $serie = $this->findById($this->_request->getParam("serie_id"));
            $info = $serie->toArray();
            
            // smazani serie a oznacena, ze serie byla smazana
            $serie->delete();
            
            $this->view->isDeleted = true;
            $this->view->serieInfo = $info;
        }
        
        $this->view->form = $form;
    }
    
    public function getAction() {
        // nacteni dat
        $serie = $this->findById($this->_request->getParam("serie_id"));
        
        $this->view->serie = $serie;
    }
    
    public function indexAction() {
        // nateni seznamu serii
        $tableSeries = new Application_Model_Series();
        $series = $tableSeries->findBySample($this->_request->getParam("sample_id"));
        
        $this->view->series = $series;
    }
    
    public function postAction() {
        // vytvoreni formulare a nacteni ifnormaci o vzorku
        $form = new Application_Form_Serie();
        $sample = $this->findRowById($this->_request->getParam("sample_id"), "Samples");
        
        // kontrola, jestli byl formular odeslan a zda jsou data validni
        if ($this->_request->isPost() && $form->isValid($this->_request->getParams())) {
            // data jsou validni - vytvoreni nove serie snimku
            $tableSeries = new Application_Model_Series();
            
            $serie = $tableSeries->createRow($form->getValues(true));
            $serie->sample_id = $sample->sample_id;
            $serie->user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
            $serie->save();
            
            $this->view->serie = $serie;
        }
        
        $this->view->form = $form;
    }
    
    public function putAction() {
        // priprava dat
        $form = new Application_Form_Serie();
        $serie = $this->findById($this->_request->getParam("serie_id"));
        $form->populate($serie->toArray());
        
        // kontrola, zda byl formular odeslan
        if ($this->_request->isPost() && $form->isValid($this->_request->getParams())) {
            // formular byl odeslan a je validni - ulozeni zmen
            $serie->setFromArray($form->getValues(true));
            $serie->save();
        }
        
        // zapis do view
        $this->view->serie = $serie;
        $this->view->form = $form;
    }
}

?>
