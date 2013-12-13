<?php
class ExperimentController extends Zend_Controller_Action {
	
	/**
	 * smaze experiment
	 */
	public function deleteAction() {
		
	}
	
	/**
	 * zobrazi experiment
	 */
	public function getAction() {
		
	}
	
	/**
	 * zobrazi seznam experimentu
	 */
	public function indexAction() {
		// nacteni seznamu experimentu
        $tableExperiments = new Application_Model_Experiments();
        
        $experiments = $tableExperiments->findByUser(Zend_Auth::getInstance()->getIdentity());
        
        $this->view->experiments = $experiments;
	}
	
	/**
	 * vytvori novy experiment
	 */
	public function postAction() {
		// vytvoreni formulare
        $form = new Application_Form_Experiment();
        
        $this->view->form = $form;
	}
	
	/**
	 * upravi stavajici experiment
	 */
	public function putAction() {
		
	}
}