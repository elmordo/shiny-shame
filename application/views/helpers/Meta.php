<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Meta
 *
 * @author petr
 */
class Zend_View_Helper_Meta extends Zend_View_Helper_Abstract {
    
    /**
     * vraci hlavicku tabulky metainformaci
     * 
     * @param array $config konfiguracni pole
     * @return string
     */
    public function head(array $config = array()) {
        $config = array_merge(array("displayActions" => false), $config);
        
        $cols = array("Name", "Value");
        
        if ($config["displayActions"]) {
            $cols[] = "Actions";
        }
        
        return sprintf("<thead><tr><th>%s</th></tr></thead>", implode("</th><th>", $cols));
    }
    
    /**
     * vytvori radek s jednou metainformaci
     * 
     * @param mixed $data data o metainformaci
     * @param array $config konfiguracni pole
     * @return string
     */
    public function information($data, array $config = array()) {
        // doplneni konfiguraku
        $config = array_merge(array("displayActions" => false, "actions" => array()), $config);
        
        // sestaveni zakladni informaci
        $information = array($data["name"], $data["value"]);
        
        if ($config["displayActions"]) {
            $actions = array();
            
            foreach ($config["actions"] as $action) {
                $actions[] = $this->_action($data, $action);
            }
            
            $information[] = implode("", $actions);
        }
        
        return sprintf("<tr><td>%s</td></tr>", implode("</td><td>", $information));
    }
    
    /**
     * zakladni metoda helperu
     * pokud je nastaven parametr $metainfos, pak se vypise tabulka informaci
     * pokud neni nastaven parametr $metainfos, pak se vraci instance helperu
     * 
     * @param mixed $metainfos seznam metainformaci
     * @param array $config konfiguracni pole
     * @return \Application_View_Helper_Meta|string
     */
    public function meta($metainfos = null, array $config = array()) {
        // pokud zadna data nejsou nastavena, pak se vraci instance helperu
        if (is_null($metainfos)) {
            return $this;
        }
        
        // vytvoreni hlavicky
        $head = $this->head($config);
        
        // sestaveni dat
        $items = array();
        
        foreach ($metainfos as $item) {
            $items[] = $this->information($item, $config);
        }
        
        return sprintf("<table>%s<tbody>%s</tbody></table>", $head, implode("", $items));
    }
    
    /**
     * vygeneruje akci
     * 
     * @param mixed $meta metainformace ke ktere se akce vztahuje
     * @param array $config konfigurace akce
     * @return string
     */
    public function _action($meta, array $config) {
        switch ($config["type"]) {
            case "link":
                $url = str_replace("{metaId}", $meta->id, $config["url"]);
                $retVal = sprintf("<a href='%s'>%s</a>", $url, $config["caption"]);
                break;
        }
        
        return $retVal;
    }
}

?>
