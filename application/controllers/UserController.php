<?php
class UserController extends Zend_Controller_Action {
	
    /**
     *
     * @var Application_Model_Row_User
     */
    private $_user;

    public function init() {
        $this->_user = Zend_Auth::getInstance()->getIdentity();
    }

    public function deleteAction() {
		
	}
	
	/**
	 * zobrazi informace o uzivateli (read only)
	 */
	public function getAction() {
		// nacteni informaci
		$this->view->user = $this->_user;
	}
    
    public function getotherAction() {
        $tableUsers = new Application_Model_Users();
        
        $this->_user = $tableUsers->findByLogin($this->_request->getParam("login"));
        $this->getAction();
    }
	
	/**
	 * vypise informace o aktualnim uzivateli
	 */
	public function indexAction() {
		$tableUsers = new Application_Model_Users();
        $users = $tableUsers->fetchAll(null, "username");
        
        $this->view->users = $users;
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
		
        // nacteni uzivatele
        $identity = $this->_user;
        $tableUsers = new Application_Model_Users();
        
        $user = $tableUsers->findById($identity->id);
        
		if ($this->_request->isPost()) {
            // formular byl odeslan metodou post - kontrola validity a update dat
            if ($form->isValid($this->_request->getParams())) {
                // formular je validni - update dat
                
                // update jmena
                $user->username = $form->getValue("username");
                
                // update hesla, pokud je treba
                $password = $form->getValue("password");
                
                if (!is_null($password)) {
                    // kontrola stareho hesla
                    $oldPassword = $form->getValue("old_password");
                    
                    if ($user->checkPassword($oldPassword)) {
                        // stare heslo je platne - kontrola shody hesla a potvrzeni hesla
                        if (strcmp($password, $form->getValidValues("password_confirm"))) {
                            $this->view->form = $form;
                        } else {
                            $user->setPassword($password);
                            $user->save();
                            
                            $this->_helper->getHelper("FlashMessenger")->addMessage("Data has been saved, password has been changed");
                        }
                    } else {
                        $this->view->form = $form;
                        $form->getElement("old_password")->addError("Invalid old password");
                    }
                } else {
                    // s klidnym svedomim muzeme uzivatele ulozit
                    $user->save();
                    $this->_helper->getHelper("FlashMessenger")->addMessage("Data has been saved");
                }
                
            } else {
                // formular neni validni - zapis do view
                $this->view->form = $form;
            }
		} else {
            // formular nebyl odeslan metodou post - probehne normalni zobrazeni
            $form->populate($user->toArray());
			$form->isValidPartial($this->_request->getParams());
            $this->view->form = $form;
		}
	}
    
    public function putotherAction() {
        $tableUsers = new Application_Model_Users();
        $user = $tableUsers->findByLogin($this->_request->getParam("login"));
        $form = new Application_Form_User_Admin();
        $form->populate($user->toArray());
        
        $this->view->user = $user;
        $this->view->form = $form;
    }
	
	public function putPartAction() {
		$this->putAction();
	}
}
