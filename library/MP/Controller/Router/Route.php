<?php

class MP_Controller_Router_Route extends Zend_Controller_Router_Route {
    
    public function match($path, $partial = false) {
        // kontrola, zda routa obsahuje tecku
        $extension = null;
        
        if (strpos($path, ".")) {
            list($path, $extension) = explode(".", $path);
        }
        
        $retVal = parent::match($path, $partial);
        
        if (!is_null($extension)) {
            // uprava akce
            $retVal["action"] .= "." . $extension;
        }
        
        return $retVal;
    }
}
?>
