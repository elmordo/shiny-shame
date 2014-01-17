<?php
class Comment_View_Helper_Comment extends Zend_View_Helper_Abstract {
	
	public function comment($comment = null, array $config = array()) {
		if (is_null($comment))
			return $this;
		
		$retVal = $this->wrapperBegin();
		$retVal .= $this->controlls($comment, $config);
		$retVal .= $this->content($comment);
		$retVal .= $this->wrapperEnd();
		
		return $retVal;
	}
	
	public function controlls($comment, array $config = array()) {
		$config = array_merge(array(
				"format" => "%name - %date"
				), $config);
		
		$text = $config["format"];
		
		$text = str_replace("%name", $comment->username, $text);
		
		$text = str_replace("%date", $this->view->sqlDate($comment->created_at), $text);
		
		return sprintf("<div class='comment-caption'>%s</div>", $text);
	}
	
	public function content($comment) {
		return "<div class='comment-content'>" . $comment->comment . "</div>";
	}
	
	public function wrapperBegin() {
		return "<div class='comment'>";
	}
	
	public function wrapperEnd() {
		return "</div>";
	}
}