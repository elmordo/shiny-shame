<?php

class MicroscopeController extends Zend_Controller_Action {

    public function getAction() {
        // nacteni mikroskopu
        $microscope = self::findByTag($this->_request->getParam("tag"));
        
        $this->view->microscope = $microscope;
    }

    public function indexAction() {
        // nacteni seznamu mikroskopu
        $tableMicroscopes = new Application_Model_Microscopes();
        $microscopes = $tableMicroscopes->fetchAll(null, "name");

        $this->view->microscopes = $microscopes;
    }

    public function postAction() {
        $form = new Application_Form_Microscope();

        if ($this->_request->isPost()) {
            // validace dat
            if ($form->isValid($this->_request->getParams())) {
                // formular je validni
                $tableMicroscopes = new Application_Model_Microscopes();
                $microscope = $tableMicroscopes->createRow($form->getValues(true));
                
                $microscope->save();
                $this->view->microscope = $microscope;
            } else {
                $this->view->form = $form;
            }
        } else {
            $form->isValidPartial($this->_request->getParams());
            $this->view->form = $form;
        }
    }

    public function postPartAction() {
        $this->postAction();
        
        $this->view->form->setAction("create-microscope");
    }

    public function putAction() {
        // nacteni mikroskopu
        $microscope = self::findByTag($this->_request->getParam("tag"));
        $form = new Application_Form_Microscope();
        
        if ($this->_request->isPost()) {
            // validace formulare
            if ($form->isValid($this->_request->getParams())) {
                // update dat
                $microscope->setFromArray($form->getValues(true));
                
                $microscope->save();
                $this->view->redirect = true;
            }
        } else {
            $form->populate($microscope->toArray());
        }
        
        $this->view->microscope = $microscope;
        $this->view->form = $form;
    }

    /**
     * nacte mikroskop dle tagu
     * 
     * @param string $tag zkratka mikroskopu
     * @return Application_Model_Row_Microscope
     * @throws Zend_Db_Table_Exception
     */
    public static function findByTag($tag) {
        // vytvoreni instance tabulky
        $tableMicroscopes = new Application_Model_Microscopes();
        $microscope = $tableMicroscopes->findByTag($tag);
        
        if (is_null($microscope)) {
            throw new Zend_Db_Table_Exception(sprintf("Microscope with tag %s not found", $tag));
        }
        
        return $microscope;
    }
}
