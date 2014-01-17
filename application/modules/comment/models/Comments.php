<?php
class Comment_Model_Comments extends Zend_Db_Table_Abstract {

	protected $_name = "comment_comments";
	
	protected $_primary = array("id");
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
		"session" => array(
			"columns" => array("session_id"),
			"refTableClass" => "Comment_Model_Sessions",
			"refColumns" => array("id")
		),
		
		"account" => array(
			"columns" => array("account_id"),
			"refTableClass" => "User_Model_Accounts",
			"refColumns" => array("id")
		),
			
		"parent" => array(
				"columns" => array("parent_id"),
				"refTableClass" => "Comment_Model_Comments",
				"refColumns" => array("id")
		)
	);
	
	protected $_rowClass = "Comment_Model_Row_Comment";
	
	protected $_rowsetClass = "Comment_Model_Rowset_Comments";
	
	/**
	 * vytvori novy komentar
	 * 
	 * @param Comment_Model_Row_Session $session relace komentaru
	 * @param Comment_Form_Comment $comment formular s daty.
	 * @param User_Model_Row_Account $user reprezentace radku uzivatele
	 * @return Comment_Model_Row_Comment
	 */
	public function createComment(Comment_Model_Row_Session $session,
			Comment_Form_Comment $comment,
			$user = null) {
		
		$row = $this->createRow($comment->getValues(true));
		$row->session_id = $session->id;
		
		if (is_object($user)) { 
			$row->account_id = $user->id;
		} else {
			$row->username = $comment->getValue("username");
		}
		
		$row->save();
		
		return $row;
	}
	
	/**
	 * vraci radek komentare na zaklade jeho id
	 * 
	 * @param int $id identifikacni cislo komentare
	 * @return Comment_Model_Row_Comment|NULL
	 */
	public function findById($id) {
		return $this->find($id)->current();
	}
	
	/**
	 * najde komentare dle objektu reprezentace radku relace
	 * pokud jsou zapnuty rozsirene informace, vraci take informace o odesilateli
	 *
	 * @param Comment_Model_Row_Session $session reprezentace radku relace
	 * @param bool $extended prepinac rozsirenych informaci
	 * @param int $n pocet zaznamu
	 * @param int $page cislo stranky od nuly
	 * @param string $order razeni
	 * @return Comment_Model_Rowset_Comments
	 */
	public function findBySession(Comment_Model_Row_Session $session,
			$extended,
			$n = null,
			$page = 0,
			$order = null) {
		
		return $this->findBySessionId($session->id, $extended, $n, $page);
	}
	
	/**
	 * najde komentare dle objektu vnitrniho id relace
	 * pokud jsou zapnuty rozsirene informace, vraci take informace o odesilateli
	 *
	 * @param int $sessionId  vnitrni id radku relace
	 * @param bool $extended prepinac rozsirenych informaci
	 * @param int $n pocet zaznamu
	 * @param int $page cislo stranky od nuly
	 * @param string $order razeni
	 * @return Comment_Model_Rowset_Comments
	 */
	public function findBySessionId($sessionId,
			$extended,
			$n = null,
			$page = 0,
			$order = null) {
		
		// jmeno teto tabulky, seznam sloupcu a podminka
		$adapter = $this->getAdapter();
		$thisName = $adapter->quoteIdentifier($this->_name);
		
		$columns = "$thisName.*";
		$where = "`session_id` = " . $adapter->quote($sessionId);
		
		// vyhodnoceni rozsirenych informaci
		if ($extended) {
			$tableUsers = new User_Model_Users();
			$nameUsers = $adapter->quoteIdentifier($tableUsers->info("name"));
			
			$columns .= ", $nameUsers.`username`, $nameUsers.`login`, $nameUsers.`email`";
			
			$join = " right join $nameUsers on $nameUsers.`id` = $thisName.`user_id`";
		} else {
			$join = "";
		}
		
		// sestaveni paginace
		if (is_null($n)) {
			$limit = "";
		} else {
			$n = (int) $n;
			$offset = $n * $page;
			$limit = "LIMIT $offset, $n";
		}
		
		// sestaveni dotazu
		$order = $order ? "ORDER BY " . $order : "ORDER BY created_at";
		$sql = "SELECT $columns FROM $thisName WHERE $where $join $order $limit";
		$data = $adapter->query($sql)->fetchAll();
		
		$class = $this->_rowsetClass;
		$retVal = new $class(array("table" => $this, "data" => $data));
		
		return $retVal;
	}
}
