<?php
class UserController extends Zend_Controller_Action {
	
	public function deleteAction() {
		
	}
	
	/**
	 * zobrazi informace o uzivateli (read only)
	 */
	public function getAction() {
		
	}
	
	/**
	 * vypise informace o aktualnim uzivateli
	 */
	public function indexAction() {
		
	}
	
	/**
	 * vypise seznam uzivatelu
	 */
	public function listAction() {
		
	}
	
	/**
	 * prihlaseni uzivatele
	 */
	public function loginAction() {
		// priprava formulare
		$form = new Application_Form_Login();
		$this->view->headTitle("Přihlášení uživatele");
		
		// vyhodnoceni pozadavku
		if ($this->_request->isPost()) {
			// kontrola, zda je formular validni
			if ($form->isValid($this->_request->getParams())) {
				// formular je validni - prihlaseni uzivatele
				$tableUsers = new Application_Model_Users();
			}
		}
		
		// nastaveni formulare do pohledu
		$this->view->form = $form;
	}
	
	/**
	 * vytvori noveho uzivatele
	 */
	public function postAction() {
		
	}
	
	/**
	 * ulozi zmeny existujiciho uzivatele
	 */
	public function putAction() {
		
	}
}