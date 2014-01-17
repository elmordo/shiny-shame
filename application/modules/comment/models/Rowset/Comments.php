<?php

class Comment_Model_Rowset_Comments extends Zend_Db_Table_Rowset_Abstract {
	
	/**
	 * vraci seznam id uctu, ktere jsou v rowsetu
	 * 
	 * @return array
	 */
	public function getAccountIds() {
		$retVal = array();
		
		foreach ($this->_data as $comment) {
			if ($comment["user_id"] && !in_array($comment["user_id"], $retVal))
				$retVal[] = $comment["user_id"];
		}
		
		return $retVal;
	}
	
	/**
	 * vraci index uctu (dle id uctu), ktere maji komentar v setu
	 * 
	 * @return array
	 */
	public function getAccountIndex() {
		// priprava navratove hodnoty
		$retVal = array();
		
		// pokud neni nainstalovan modul uzivatelu, vraci se prazdne pole
		if (array_key_exists("user", Zend_Controller_Front::getInstance()->getControllerDirectory())) 
			return $retVal;
		
		// pouzijeme metodu pro nacteni id uzivatelu
		$accountIds = $this->getAccountIds();
		
		if (!$accountIds) return $retVal;
		
		// nacteme a naindexujeme uzivatele
		$tableAccounts = new User_Model_Accounts();
		$accounts = $tableAccounts->find($accountIds);
		
		foreach ($accounts as $account) {
			$retVal[$account->id] = $account;
		}
		
		return $retVal;
	}
}
