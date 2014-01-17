<?php 
class Comment_Model_Sessions extends Zend_Db_Table_Abstract {
	
	const OPT_HIDDEN = "hidden";
	
	const OPT_READONLY = "readonly";
	
	protected $_name = "comment_sessions";
	
	protected $_sequence = true;
	
	protected $_primary = array("id");
	
	protected $_referenceMap = array();
	
	protected $_rowClass = "Comment_Model_Row_Session";
	
	protected $_rowsetClass = "Comment_Model_Rowset_Sessions";
	
	/**
	 * vytvori novy zaznam relace komentaru
	 * 
	 * @param string $name jmeno relace
	 * @param array $options dodatecna nastaveni
	 * @return Comment_Model_Row_Session
	 */
	public function createSession($name, array $options = NULL) {
		// vygenerovani hodnot radku
		$data = array("name" => $name);
		
		// kontrola nastaveni
		$options = (array) $options;
		
		if (isset($options[self::OPT_HIDDEN])) $data["is_hidden"] = ($options[self::OPT_HIDDEN] ? 1 : 0);
		if (isset($options[self::OPT_READONLY])) $data["is_readonly"] = ($options[self::OPT_READONLY] ? 1 : 0);
		
		$retVal = $this->createRow($data);
		$retVal->save();
		
		return $retVal;
	}
	
	/**
	 * vraci relaci dle id
	 * 
	 * @param int $id identifikacni cislo relace
	 * @return Comment_Model_Row_Session
	 */
	public function findById($id) {
		return $this->find($id)->current();
	}
	
	/**
	 * vraci naposledy zmenene relace komentaru
	 * 
	 * @param int $n pocet zaznamu na strance
	 * @param int $page cislo stranky
	 * @return Comment_Model_Rowset_Sessions
	 */
	public function getLastModified($n, $page = 0) {
		// radit se bude primarne podle posledni modifikace
		// pak se zkontroluje sekundarni (uzivatelske) razeni
		$orderList = array("modified_at desc");
		
		return $this->fetchAll(1, $orderList, $n, $n * $page);
	}
}