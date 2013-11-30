<?php
class MicroscopeController extends Zend_Controller_Action {
	
	public function getAction() {
		
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
            
        } else {
            $form->isValidPartial($this->_request->getParams());
            $this->view->form = $form;
        }
	}
    
    public function postPartAction() {
        $this->postAction();
    }
	
	public function putAction() {
		
	}
}