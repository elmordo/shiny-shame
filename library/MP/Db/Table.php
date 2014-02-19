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
    
    /*
     * konstanty asociativniho pole nastaveni markupu
     */
    const MARKUP_SOURCE = "source";
    const MARKUP_TARGET = "target";
    const MARKUP_PARSER = "parser";
    const MARKUP_OPTIONS = "options";
    const MARKUP_RENDERER = "renderer";
    
    /*
     * vychozi parser renderer
     */
    const MARKUP_DEFAULT_PARSER = "Zend_Markup_Parser_Textile";
    const MARKUP_DEFAULT_RENDERER = "Zend_Markup_Renderer_Html";
    
    /**
     * pole obsahujici informace pro prevod markup textu
     * nastaveni ma smysl pouze pokud reprezentace radku dokaze toto pole vyuzit
     * kazdy prvek je asociativnim polem s klici:
     *   source    - jmeno zrojoveho sloupce
     *   target    - jmeno ciloveho sloupce
     *   markup    - jmeno tridy s prekladacem
     *   output    - jmeno tridy pro vystpu
     *   [options] - nepovinne nastaveni prekladace (v aktualni verzi ignorovano
     * 
     * @var array
     */
    protected $_markups = array();
    
    /**
     * prepinac aktivace markup prekladace
     *
     * @var bool
     */
    protected $_markupsEnabled = false;
    
    protected $_rowClass = "MP_Db_Table_Row";
    
    /**
     * asociativni pole uchovavajici realna jmena tabulek
     * klicem je nazev tridy
     * hodnotou nazev tabulky v databazi
     *
     * @var array
     */
    private static $_tableNames = array();
    
    /**
     * prida nastaveni markup prekladace
     * pole musi obsahovat:
     *   source    - jmeno zrojoveho sloupce
     *   target    - jmeno ciloveho sloupce
     *   markup    - jmeno tridy s prekladacem
     *   output    - jmeno tridy pro vystpu
     *   [options] - nepovinne nastaveni prekladace (v aktualni verzi ignorovano
     * 
     * @param array $config asociatvni pole s nastavenim
     * @return \MP_Db_Table
     */
    public function addMarkup(array $config) {
        if (!(isset($config[self::MARKUP_SOURCE]) && isset($config[self::MARKUP_TARGET]))) {
            throw new Zend_Db_Table_Exception("Invalid markup setup");
        }
        
        $this->_markups[] = array_merge(array(
            self::MARKUP_PARSER => self::MARKUP_DEFAULT_PARSER,
            self::MARKUP_RENDERER => self::MARKUP_DEFAULT_RENDERER), $config);
        
        return $this;
    }
    
    /**
     * vycisti nastaveni markup prekladacu
     * 
     * @return \MP_Db_Table
     */
    public function clearMarkups() {
        $this->_markups = array();
        
        return $this;
    }
    
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
     * vraci nastaveni markap prekladacu
     * 
     * @return array
     */
    public function getMarkups() {
        return $this->_markups;
    }
    
    /**
     * vraci True, pokud je preklad pomoci markup prekladacu zapnut
     * 
     * @return bool
     */
    public function getMarkupsEnabled() {
        return $this->_markupsEnabled;
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
     * pripravy vyhledavaci dotaz
     * 
     * @return \Zend_Db_Select
     */
    public function prepareSelect() {
       $retVal = new Zend_Db_Select($this->getAdapter());
       $retVal->from($this->_name);
       
       return $retVal; 
    }
    
    /**
     * zapne nebo vypne markup prekladace
     * 
     * @param bool $enabled nove nastaveni
     * @return \MP_Db_Table
     */
    public function setMarkupEnabled($enabled = true) {
        $this->_markupsEnabled = (bool) $enabled;
        
        return $this;
    }

    /**
     * vytvori radek s daty
     * 
     * @param array $data informace z databaze
     * @param bool $stored prepinac ulozene hodnoty
     * @return Zend_Db_Table_Row_Abstract
     */
    public function _generateRow($data, $stored = true) {
        // pokud jsou data prazdna, vraci NULL
        if (!$data) {
            return null;
        }
        
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
