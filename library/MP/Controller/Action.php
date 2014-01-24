<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Action
 *
 * @author petr
 */
class MP_Controller_Action extends Zend_Controller_Action {
    
    /**
     * asociativni pole s cachovanymi daty, se kterymi kontrolery pracuji
     * klicem je jmeno tabulky
     * hodnotou je asociativni pole
     *     klicem je id radku
     *     hodnotou je instance radku
     *
     * @var array
     */
    private static $_rowCache = array();
    
    /**
     * zdrojova tabulka s daty
     *
     * @var MP_Db_Table
     */
    protected $_sourceTable=null;
    
    public function __construct(\Zend_Controller_Request_Abstract $request, \Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
        
        // pokud byla nastavena tabulka zdrojovych dat, pak se vytvori instance
        if (is_string($this->_sourceTable)) {
            $this->_sourceTable = new $this->_sourceTable();
        }
    }
    
    /**
     * nacte radek, se kterym kontroler pracuje dle jeho id
     * 
     * @param type $id
     * @return 
     */
    public function findById($id) {
        return self::findRowById($id, $this->_sourceTable);
    }
    
    /**
     * najde v tabulce radek daneho id
     * nejprve zkontroluje cache
     * 
     * @param int $id id radku
     * @param string|MP_Db_Table $table tabulka
     * @param string $module pripadne jmeno modulu pokud je tabulka predana svym jmenem
     * @return MP_Db_Table_Row
     * @throws Zend_Db_Table_Exception
     */
    public static function findRowById($id, $table, $module = "Application") {
        // vyhodnoceni, zda je predana tabulka instance, nebo pouze jmeno
        if (is_object($table)) {
            $tableName = $table->info("name");
        } else {
            $tableName = sprintf("%s_Model_%s", $module, $table);
            $table = new $tableName();
        }
        
        // kontrola, jestli je radek v cache
        $cached = self::findRowInCache($tableName, $id);
        
        if (!is_null($cached)) {
            return $cached;
        }
        
        $retVal = $table->findById($id);
        
        if (!$retVal) {
            throw new Zend_Db_Table_Exception(sprintf("Row #%d was not found in %s", $id, $tableName));
        }
        
        // zapis do cache a vraceni radku
        self::writeRowToCache($tableName, $retVal);
        
        return $retVal;
    }
    
    /**
     * vraci radek z cache
     * pokud radek neexistuje, pak vraci NULL
     * 
     * @param string $tableName jmeno tabulky
     * @param int $id identifikacni cislo zaznamu
     * @return MP_Db_Table_Row
     */
    public static function findRowInCache($tableName, $id) {
        if (!isset(self::$_rowCache[$tableName][$id])) return null;
        
        return self::$_rowCache[$tableName][$id];
    }
    
    /**
     * zapise radek do cache
     * 
     * @param str $tableName jmeno tabulky
     * @param MP_Db_Table_Row $row radek z tabulky
     * @throws Zend_Db_Table_Row_Exception
     */
    public static function writeRowToCache($tableName, MP_Db_Table_Row $row) {
        // kontrola jestli klic tabulky existuje
        if (!isset(self::$_rowCache[$tableName])) {
            self::$_rowCache[$tableName] = array();
        }
        
        // zjisteni primarniho klice
        $tableObj = $row->getTable();
        $primaryKeyName = $tableObj->info(Zend_Db_Table_Abstract::PRIMARY);
        
        // cachovani je pristupne pouze pro jednoduche primarni klice
        if (count($primaryKeyName) != 1) {
            throw new Zend_Db_Table_Row_Exception("Cache is available only for simple primary keys");
        }
        reset($primaryKeyName);
        $primaryVal = $row[current($primaryKeyName)];
        
        self::$_rowCache[$tableName][$primaryVal] = $row;
    }
}
