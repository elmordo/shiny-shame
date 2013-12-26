<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Old
 *
 * @author petr
 */
class MP_Parser_Filename_Old implements MP_Parser_Interface {
    
    const TEST_EREG = "/^([a-zA-Z0-9]+)_([0-9]{6})_([0-9]{6})_([0-9]+)\.[a-zA-Z0-9]+/";
    
    /**
     * otestuje, jestli jmeno souboru vyhovuje formatu
     * 
     * @param string $data jmeno souboru
     * @return bool
     */
    public function match($data) {
        return preg_match(self::TEST_EREG, $data);
    }
    
    /**
     * rozlozi jmeno souboru na casti a vraci vysledek zpracovani
     * pokud jmeno souboru nevyhovuje, pak vyhazuje vyjimku
     * 
     * @param string $data jmeno souboru
     * @return MP_Parser_Result
     * @throws MP_Parser_Exception
     */
    public function parse($data) {
        try {
            // rozlozeni na jmeno soubrou a priponu
            list($filename, $ext) = explode(".", $data);
            
            // rozlozeni jmena na casti
            list($collection, $date, $time, $ord) = explode("_", $filename);
            
            // rozlozeni datumu a casu
            $dateParts = $this->explodeToThree($date);
            $timeParts = $this->explodeToThree($time);
        } catch (Exception $e) {
            throw new MP_Parser_Exception("Invalid data format", 1, $e);
        }
        
        // navraceni vysledku
        $retVal = new MP_Parser_Result(array(
        MP_Parser_Result::CONFIG_DATA => array(
            "collection" => $collection,
            "year" => $dateParts[0],
            "month" => $dateParts[1],
            "day" => $dateParts[2],
            "hour" => $timeParts[0],
            "minute" => $timeParts[1],
            "second" => $timeParts[2],
            "ord" => $ord,
            "format" => $ext
        ),
        MP_Parser_Result::CONFIG_PARSER => $this));
        
        return $retVal;
    }
    
    private function explodeToThree($item) {
        return array(
            substr($item, 0, 2),
            substr($item, 2, 2),
            substr($item, 4, 2)
        );
    }
}

?>
