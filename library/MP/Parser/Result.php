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
            $this->_parser = $data[self::CONFIG_PARSER];
        }
    }
}
