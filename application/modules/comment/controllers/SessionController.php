<?php
class Comment_SessionController extends Zend_Controller_Action {
	
	public function appendAction() {
		$this->getAction();
	}
	
	public function createAction() {
		$form = new Comment_Form_Session();
		$form->isValidPartial($this->getRequest()->getParams());
		
		$this->view->form = $form;
	}
	
	/**
	 * smaze relaci a vsechny komentare
	 */
	public function deleteAction() {
		$session = $this->_loadSession();
		$session->isAuthorised(Zend_Auth::getInstance()->getIdentity(), ZSAM_Db_Table_Row::OPERATION_DELETE);
		
		$session->delete();
	}
	
	/**
	 * zobrazi relaci podle nastaveni
	 */
	public function getAction() {
		$session = $this->_loadSession();
		$session->isAuthorised(Zend_Auth::getInstance()->getIdentity(), ZSAM_Db_Table_Row::OPERATION_GET);
		
		// nacteni dat
		$pageNo = $this->getRequest()->getParam("pageNo");
		$perPage = $this->getRequest()->getParam("perPage");
		
		$comments = $session->findComments("created_at", $perPage, $pageNo);
		$this->view->session = $session;
		$this->view->comments = $comments;
		$this->view->pageNo = $pageNo;
		$this->view->perPage = $perPage;
	}
	
	/**
	 * zobrazi seznam relaci podle nastaveni
	 */
	public function listAction() {
		
	}
	
	/**
	 * vytvori novou relaci
	 */
	public function postAction() {
		try {
			$form = $this->_setAndValidate($this->getRequest()->getParams());
		} catch (Zend_Form_Exception $e) {
			$this->_forward("create");
			return;
		}
		
		// zapis dat
		$tableSessions = new Comment_Model_Sessions();
		$session = $tableSessions->createRow($form->getValues(true));
		$session->save();
		
		// presmerovani na get
		$url = $this->view->url(array("sessionId" => $session->id), "comment-session-get");
		$this->_redirect($url);
	}
	
	/**
	 * upravi informace o relaci
	 */
	public function putAction() {
		$session = $this->_loadSession();
		$session->isAuthorised(Zend_Auth::getInstance()->getIdentity(), ZSAM_Db_Table_Row::OPERATION_PUT);
		$form = $this->_setAndValidate($this->getRequest()->getParams());
	}
	
	/**
	 * nacte relaci z databaze dle odeslanych hodnot
	 * 
	 * @throws Zend_Db_Table_Exception
	 * @return Comment_Model_Row_Session
	 */
	protected function _loadSession() {
		$tableSessions = new Comment_Model_Sessions();
		$session = $tableSessions->findById($this->getRequest()->getParam("sessionId", 0));
		
		if (!$session) throw new Zend_Db_Table_Exception("Session not found");
		
		return $session;
	}
	
	/**
	 * nastavi data formulari a zvaliduje je
	 * pokud data nejsou validni vyhazuje vyjimku
	 * 
	 * @param array $params parametry formulare
	 * @throws Zend_Form_Exception
	 * @return Comment_Form_Session
	 */
	protected function _setAndValidate($params) {
		$form = new Comment_Form_Session();
		if (!$form->isValid($params)) throw new Zend_Form_Exception("Session form data is not valid");
		
		return $form;
	}
}