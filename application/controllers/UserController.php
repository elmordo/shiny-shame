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
		// nacteni informaci
		$user = Zend_Auth::getInstance()->getIdentity();
		
		$this->view->user = $user;
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
				if (Zend_Auth::getInstance()->authenticate($form)->isValid()) {
					$this->view->authentised = true;
				}
			}
		}
		
		// nastaveni formulare do pohledu
		$this->view->form = $form;
	}
	
	public function logoutAction() {
		Zend_Auth::getInstance()->clearIdentity();
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
		// nacteni dat a vyhodnoceni formulare
		$form = new Application_Form_User_My();
		
		if ($this->_request->isPost()) {
		
		} else {
			$form->isValidPartial($this->_request->getParams());
		}
	}
	
	public function putPartAction() {
		$this->putAction();
	}
}
