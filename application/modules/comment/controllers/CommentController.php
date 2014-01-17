<?php
class Comment_CommentController extends Zend_Controller_Action {
	
	public function createAction() {
		$form = new Comment_Form_Comment();
		$form->isValidPartial($this->getRequest()->getParams());
		
		// akce
		$sessionId = $this->getRequest()->getParam("sessionId", 0);
		$action = $this->view->url(array("sessionId" => $sessionId), "comment-post");
		$form->setAction($action);
		
		// presmerovani
		if (!$this->getRequest()->getParam("redirect_to", false)) {
			$form->getElement("redirect_to")->setValue(
					$this->view->url(array("sessionId" => $sessionId), "comment-session-get")
			);
		}
		
		$this->view->form = $form;
	}
	
	public function deleteAction() {
		$comment = $this->_findComment();
		$comment->isAuthorised(Zend_Auth::getInstance()->getIdentity(), ZSAM_Db_Table_Row::OPERATION_DELETE);
		
		$comment->delete();
	}
	
	public function editAction() {
		$comment = $this->_findComment();
		$form = new Comment_Form_Comment();
		$form->populate($comment->toArray());
		
		$this->view->form = $form;
	}
	
	public function getAction() {
		$comment = $this->_findComment();
		$comment->isAuthorised(Zend_Auth::getInstance()->getIdentity(), ZSAM_Db_Table_Row::OPERATION_GET);
		$this->view->comment = $comment;
	}
	
	public function postAction() {
		// nacteni relace
		$sessionId = $this->getRequest()->getParam("sessionId", 0);
		$tableSessions = new Comment_Model_Sessions();
		$session = $tableSessions->findById($sessionId);
		$session->isAuthorised(Zend_Auth::getInstance()->getIdentity(), Comment_Model_Row_Session::OPERATION_ADDCOMMENT);
		
		if (!$session) throw new Zend_Db_Exception("Session not found");
		
		// vytvoreni radku
		$tableComments = new Comment_Model_Comments();
		$comment = $tableComments->createRow(array("session_id" => $sessionId));
		
		$this->_setComment($comment)->save();
		
		$this->view->row = $row;
	}
	
	public function putAction() {
		$comment = $this->_findComment();
		$comment->isAuthorised(Zend_Auth::getInstance()->getIdentity(), ZSAM_Db_Table_Row::OPERATION_PUT);
		
		// uprava a ulozeni radku
		$this->_setComment($comment)->save();
		
		$this->view->comment = $comment;
	}
	
	/**
	 * nastavi radek komentare daty z requestu
	 * vraci ten samy radek
	 * 
	 * @param Comment_Model_Row_Comment $row radek komentare
	 * @throws Zend_Form_Exception
	 * @return Comment_Model_Row_Comment
	 */
	protected function _setComment(Comment_Model_Row_Comment $row) {
		$form = new Comment_Form_Comment();
		
		if (!$form->isValid($this->getRequest()->getParams())) throw new Zend_Form_Exception("Invalid data of comment");
		$row->setFromArray($form->getValues(true));
		
		/**
		 * @todo dodelat nejaky prevod textu
		 */
		$row->comment = $row->comment_original;
		
		return $row;
	}
	
	/**
	 * nacte radek komentare z databaze
	 * 
	 * @throws Zend_Db_Table_Exception
	 * @return Comment_Model_Row_Comment
	 */
	protected function _findComment() {
		$tableComments = new Comment_Model_Comments();
		$commentId = $this->getRequest()->getParam("commentId", 0);
		$comment = $tableComments->findById($commentId);
		
		if (!$comment) throw new Zend_Db_Table_Exception("Comment not found");
		
		return $comment;
	}
}