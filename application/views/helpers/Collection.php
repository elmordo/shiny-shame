<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Collection
 *
 * @author petr
 */
class Zend_View_Helper_Collection extends Zend_View_Helper_Abstract {
    
    public function collection($collection = null, array $config = array()) {
        if (is_null($collection)) {
            return $this;
        }
        
        // slouceni konfigu
        $config = array_merge(array(
            "actions" => array()
        ), $config);
        
        // vyhodnoceni akci
        $actions = array();
        
        foreach ($config["actions"] as $item) {
            $actions[] = $this->view->linkButton($item["url"], $item["label"]);
        }
        
        // vytvoreni sablony
        $pattern = "<tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
</tr>";
        
        return sprintf($pattern, $collection->name, $collection->tag, "");
    }
    
    /**
     * vypise seznam kolekci v tabulce
     * 
     * @param type $collections data kolekci
     */
    public function collections($collections, array $config = array()) {
        // sestaveni tabulky kolekci
        $head = $this->header($config);
        $rows = array();
        
        foreach ($collections as $item) {
            $rows[] = $this->collection($item);
        }
        
        return sprintf("<table>%s<tbody>%s</tbody></table>", $head, implode("", $rows));
    }
    
    public function header(array $config = array()) {
        return "<thead>
            <tr>
                <th>Name</th>
                <th>Tag</th>
                <th>Actions</th>
            </tr>
</thead>";
    }
}

?>
