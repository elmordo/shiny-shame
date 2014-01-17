<?php
class Comment_View_Helper_Session extends Zend_View_Helper_Abstract {
	
	public function session($comments) {
		$commentArr = array();
		
		$helper = new Comment_View_Helper_Comment();
		$helper->setView($this->view);
		
		foreach ($comments as $comment) {
			$commentArr[] = $helper->comment($comment);
		}
		
		return sprintf("<div class='comment-session'>%s</div>", implode("", $commentArr));
	}
}