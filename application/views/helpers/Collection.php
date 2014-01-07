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
    
    /**
     * 
     * @param Application_Model_Row_Collection $collection kolekce obrazku
     * @param array $config
     * @return string
     */
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
        
        // vyhodnoceni akci
        $actions = array();
        
        if ($collection->checkAccess(MP_Db_Table_Row_DataAccess::ACCESS_READ)) {
            $actions[] = sprintf("<a href='%s'>Show</a>", $this->view->url(array("experimentId" => $collection->experiment_id, "id" => $collection->id), "get-collection"));
        }
        
        if ($collection->checkAccess(MP_Db_Table_Row_DataAccess::ACCESS_WRITE)) {
            $actions[] = sprintf("<a href='%s'>Edit</a>", $this->view->url(array("experimentId" => $collection->experiment_id, "id" => $collection->id), "put-collection"));
        }
        
        return sprintf($pattern, $collection->name, $collection->tag, implode(" ", $actions));
    }
    
    /**
     * vypise seznam kolekci v tabulce
     * 
     * @param Application_Model_Row_Collection $collections data kolekci
     * @param Application_Model_Row_Experiment $experiment radek experimentu
     * @return string
     */
    public function collections($collections, array $config = array()) {
        // sestaveni tabulky kolekci
        $head = $this->header($config);
        $rows = array();
        
        foreach ($collections as $item) {
            $rows[] = $this->collection($item, $config);
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
