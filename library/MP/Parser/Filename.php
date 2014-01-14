<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Filename
 *
 * @author petr
 */
class MP_Parser_Filename {
    
    private static $_parsers = null;
    
    public static function parse($fileName) {
        if (is_null(self::$_parsers)) {
            self::_init();
        }
        
        foreach (self::$_parsers as $parser) {
            if ($parser->match($fileName)) {
                return $parser->parse($fileName);
            }
        }
        
        return null;
    }
    
    private static function _init() {
        $dirName = __DIR__ . "/Filename/";
        $dir = dir($dirName);
        
        while ($name = $dir->read()) {
            // kontrola, jestli se jedna o PHP soubor
            $info = pathinfo($name);
            if (strtolower($info["extension"]) == "php") {
                // jedna se o soubor - vytvori se instance
                $className = "MP_Parser_Filename_" . $info["filename"];
                self::$_parsers[$info["filename"]] = new $className();
            }
        }
    }
}

?>
