<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Row
 *
 * @author petr
 */
class MP_Db_Table_Row extends Zend_Db_Table_Row_Abstract {
    
    /**
     * vychoti pristupova prava
     *
     * @var str
     */
    protected $_dataAccess = "rwdr--r--";
    
    /**
     * indikator, zda byl radek ulozen
     *
     * @var bool
     */
    protected $_isSaved = false;
    
    public function checkAccess($accessRequest, $identity = null) {
        // pokud radek neimplementuje rozhrani DataAccess, navratova hodnota je vzdy True
        if (!$this instanceof MP_Db_Table_Row_DataAccess) return true;
        
        // vyhodnoceni identity
        if (is_null($identity)) $identity = Zend_Auth::getInstance()->getIdentity();
        
        // vyhodnoceni offsetu prav
        $offset = MP_Db_Table_Row_DataAccess::ACCESS_OTHER;
        
        if ($identity) {
            // pokud je uzivatel admin, vraci se vzdy True
            if ($identity->role == MP_Role::ROLE_ADMIN) return true;
            
            // vyhodnoceni uzivatele a skupin
            if ($identity->id == $this->getOwnerId()) {
                $offset = MP_Db_Table_Row_DataAccess::ACCESS_USER;
            } elseif(null) {
                $offset = MP_Db_Table_Row_DataAccess::ACCESS_GROUP;
            }
        }
        
        // vyhodnoceni requestu
        $permisions = $this[$this->getAccessPermisions()];
        
        switch ($accessRequest) {
            case MP_Db_Table_Row_DataAccess::ACCESS_READ:
                $offset += MP_Db_Table_Row_DataAccess::ACCESS_READ;
                return $permisions[$offset] == MP_Db_Table_Row_DataAccess::VALUE_READ;
                break;
            
            case MP_Db_Table_Row_DataAccess::ACCESS_WRITE:
                $offset += MP_Db_Table_Row_DataAccess::ACCESS_WRITE;
                return $permisions[$offset] == MP_Db_Table_Row_DataAccess::VALUE_WRITE;
                break;
            
            case MP_Db_Table_Row_DataAccess::ACCESS_DELETE:
                $offset += MP_Db_Table_Row_DataAccess::ACCESS_DELETE;
                return $permisions[$offset] == MP_Db_Table_Row_DataAccess::VALUE_DELETE;
                break;
            
            default:
                throw new MP_Db_Table_Row_DataAccess_Exception(sprintf("invalid access request for %d", $accessRequest));
        }
    }
    
    /**
     * resetuje prepinac isSaved
     * 
     * @return MP_Table_Row
     */
    public function clearSaved() {
        $this->_isSaved = false;
        
        return $this;
    }
    
    /**
     * vraci stav prepinace ulozeni
     * 
     * @return bool
     */
    public function isSaved() {
        return $this->_isSaved;
    }
    
    /**
     * provede preklad pomoci markup prekladacu
     * 
     * @param bool $force pokud je True, pokusi se preklad ikdyz je v tabulce vypnut
     * @return MP_Db_Table_Row
     */
    public function processMarkups($force = false) {
        // kontrola podpory ze strany tabulky
        if (!$this->_table instanceof MP_Db_Table) return $this;
        
        // kontrola (nasilne) aktivace
        if (!$force && !$this->_table->getMarkupsEnabled()) return $this;
        
        // nacteni konfigurace a provedeni zmen
        $markupConfig = $this->_table->getMarkups();
        
        $parsers = array();
        $renderers = array();
        
        // prevedeni vsech hodnot
        foreach ($markupConfig as $item) {
            // kontrola, zda byl zdroj modifikovan
            $source = $item[MP_Db_Table::MARKUP_SOURCE];
            
            $parser = $item[MP_Db_Table::MARKUP_PARSER];
            $renderer = $item[MP_Db_Table::MARKUP_RENDERER];
            
            if (!isset($parsers[$parser])) {
                $parsers[$parser] = new $parser();
            }
            
            if (!isset($renderers[$renderer])) {
                $renderers[$renderer] = new $renderer();
            }
            
            $source = $item[MP_Db_Table::MARKUP_SOURCE];
            $target = $item[MP_Db_Table::MARKUP_TARGET];
            
            if (!is_null($this[$source])) {
                // provedeni transformace
                $data = $parsers[$parser]->parse($this[$source]);
                $output = $renderers[$renderer]->render($data);
                
                // zapis vysledku
                $this[$target] = $output;
            }
        }
    }
    
    /**
     * Saves the properties to the database.
     *
     * This performs an intelligent insert/update, and reloads the
     * properties with fresh data from the table on success.
     *
     * @return mixed The primary key value(s), as an associative array if the
     *     key is compound, or a scalar if the key is single-column.
     */
    public function save() {
        $retVal = parent::save();
        
        $this->_isSaved = true;
        
        return $retVal;
    }
    
    /**
     * provede nastaveni dat z pole
     * pripadne provede transformaci dat pomoci markup prekladacu
     * 
     * @param array $data
     * @return \MP_Db_Table_Row
     */
    public function setFromArray(array $data) {
        $retVal = parent::setFromArray($data);
        
        $this->processMarkups();
        
        return $this;
    }
    
    /**
     * nastavi novou hodnotu prepinace isSaved
     * 
     * @param bool $saved nova hodnota prepinace
     * @return \MP_Db_Table_Row
     */
    public function setSaved($saved) {
        $this->_isSaved = (bool) $saved;
        
        return $this;
    }
}

?>
