<?php
/**
 * @author Ing. Petr Jindra
 */

class MP_Parser_Result {

    const CONFIG_DATA = "data";
    const CONFIG_PARSER = "parser";

    /**
     * seznam klic hodnota naprasovanych dat
     *
     * @var array
     */
    protected $_data = array();

    /**
     * instance parseru, ktera vysledek vytvorila
     *
     * @var MP_Parser_Interface
     */
    protected $_parser = null;
    
    /**
     * vytvori novou instanci parseru a nastavi dodane informace
     *
     * @param array $config konfiguracni pole
     */
    public function __construct(array $config) {
        // kontrola, jeslti pole obsahuje data
        if (isset($config[self::CONFIG_DATA])) {
            $this->_data = (array) $config[self::CONFIG_DATA];
        }

        if (isset($config[self::CONFIG_PARSER])) {
            $this->_parser = $config[self::CONFIG_PARSER];
        }
    }
    
    /**
     * vraci polozku dle jmena
     * 
     * @param string $name jmeno polozky
     * @return mixed
     * @throws MP_Parser_Exception
     */
    public function __get($name) {
        if (!isset($this->_data[$name])) {
            throw new MP_Parser_Exception(sprintf("Item '%s' does not exists in parse result"));
        }
        
        return $this->_data[$name];
    }
    
    /**
     * vraci data vysledku jako pole
     * 
     * @return array
     */
    public function getData() {
        return $this->_data;
    }
    
    /**
     * 
     * @return MP_Parser_Interface
     */
    public function getParser() {
        return $this->_parser;
    }
}
