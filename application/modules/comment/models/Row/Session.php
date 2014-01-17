<?php
class Comment_Model_Row_Session extends ZSAM_Db_Table_Row {
	
	const OPERATION_ADDCOMMENT = "ADDCOMMENT";
	
	/**
	 * vraci komentare v relaci
	 * pokud je $n == 0, pak se vraci vsechny komentare
	 * 
	 * @param string $order razeni komentaru
	 * @param int $n pocet komentaru
	 * @param int $page strana komentari
	 * @return Comment_Model_Rowset_Comments
	 */
	public function findComments($order, $n = null, $page = 0) {
		$tableComments = new Comment_Model_Comments();
		
		$where = array("session_id = " . $this->id);
		
		if (is_null($n)) {
			// pokud je $n == null, pak je strana bezpredmetna
			// vraci se vsechny komentare
			$offset = 0;
		} else {
			$offset = $page * $n;
		}
		
		return $tableComments->fetchAll($where, $order, $n, $offset);
	}
	
	public function isAuthorised($identity, $operation) {
		/**
		 * @todo sem patri kod pro autorizaci
		 */
	}
}