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
    
    private static $_tableNames = array();
    
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
     * vytvori rowset s daty
     * 
     * @param array $data data v rowsetu
     * @return Zend_Db_Table_Rowset_Abstract
     */
    protected function _generateRowset(array $data) {
        // vytvoreni rowsetu a vraceni dat
        $rowsetName = $this->_rowsetClass;
        $retVal = new $rowsetName(array(
            "rowClass" => $this->_rowClass,
            "data" => $data,
            "table" => $this
        ));
        
        return $retVal;
    }
    
}

?>
