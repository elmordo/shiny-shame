<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Table
 *
 * @author petr
 */
class MP_Db_Table extends Zend_Db_Table_Abstract {
    
    protected $_rowClass = "MP_Db_Table_Row";
    
    private static $_tableNames = array();
    
    /**
     * vraci radek tabulky dle id
     * pouzitelne pouze pro tabulky s jednim primarnim klicem
     * 
     * @param int $id identifikator tabulky
     * @return MP_Db_Table_Row
     */
    public function findById($id) {
        return $this->find($id)->current();
    }
    
    /**
     * vraci skutecne jmeno tabulky na zaklade jmena tridy
     * 
     * @param string $className jmeno tridy
     * @return string
     */
    public static function getRealName($className) {
        // kontrola jestli zaznam uz existuje
        if (!isset(self::$_tableNames[$className])) {
            // zaznam neexistuje, musi se vytvorit
            $obj = new $className();
            self::$_tableNames[$className] = $obj->info("name");
        }
        
        return self::$_tableNames[$className];
    }

    /**
     * vytvori radek s daty
     * 
     * @param array $data informace z databaze
     * @param bool $stored prepinac ulozene hodnoty
     * @return Zend_Db_Table_Row_Abstract
     */
    public function _generateRow(array $data, $stored = true) {
        $rowClassName = $this->_rowClass;
        $retVal = new $rowClassName(array(
            "data" => $data,
            "stored" => $stored,
            "table" => $this
        ));
        
        return $retVal;
    }
    
    /**
     * vytvori rowset s daty
     * 
     * @param array $data data v rowsetu
     * @param bool $stored prepinac ulozene hodnoty
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function _generateRowset(array $data, $stored = true) {
        // vytvoreni rowsetu a vraceni dat
        $rowsetName = $this->_rowsetClass;
        $retVal = new $rowsetName(array(
            "rowClass" => $this->_rowClass,
            "data" => $data,
            "table" => $this,
            "stored" => $stored
        ));
        
        return $retVal;
    }
    
}

?>
