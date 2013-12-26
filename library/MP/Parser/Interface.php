<?php
/**
 * @author Ing. Petr Jindra
 */
interface MP_Parser_Interface {

    /**
     * vraci True, pokud data vyhovuji parseru
     *
     * @param string $data kontrolovana data
     * @return bool
     */
    public function match($data);

    /**
     * naparsuje data a vraci vysledek parsovani
     *
     * @param string $data vstupni data ke zpracovani
     * @return MP_Parse_Result
     */
    public function parse($data);

}
