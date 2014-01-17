<?php 
class Comment_Model_Row_Comment extends ZSAM_Db_Table_Row {
	
	/**
	 * vraci radek uctu, ktery komentar vytvoril
	 * vraci NULL pokud
	 * - ucet neexistuje
	 * - modul uzivatelu neni nainstalovan
	 * 
	 * @return User_Model_Row_Account|NULL
	 */
	public function getAccount() {
		// musime zkontorlovat, jestli je aktivni modul uzivatelu
		if (array_key_exists(
				"user", 
				Zend_Controller_Front::getInstance()
						->getControllerDirectory())) 
		{
			// modul existuje
			return $this->findParentRow("User_Model_Accounts", "account");
		} else {
			// modul neexistuje
			return NULL;
		}
	}
	
	/**
	 * vraci radek rodicovskeho komentare
	 * 
	 * @return Comment_Model_Row_Comment|NULL
	 */
	public function getParent() {
		return $this->findParentRow($this->getTable(), "parent");
	}
	
	/**
	 * vraci rodicovske komentare
	 * prvni komentar je nejstarsi a posledni nejnovejsi
	 * 
	 * @param bool $includeThis pokud je TRUE, je posledni prvek tento komentar
	 * @return Comment_Model_Rowset_Comments
	 */
	public function getParents($includeThis = false) {
		// priprava pole vysledku
		$rows = array();
		$parent = $this;
		
		while ($parent = $parent->getParent()) {
			$rows[] = $parent->toArray();
		}
		
		$rows = array_reverse($rows);
		
		if ($includeThis) $rows[] = $this->toArray();
		
		return new Comment_Model_Rowset_Comments(array("data" => $rows, "table" => $this->getTable()));
	}
	
	/**
	 * vraci relaci ke ktere komentar nalezi
	 * 
	 * @return Comment_Model_Row_Session
	 */
	public function getSession() {
		return $this->findParentRow(new Comment_Model_Sessions(), "session");
	}
	
	public function isAuthorised($identity, $operation) {
		/**
		 * @todo sem patri kod pro autorizaci
		 */
	}
}