<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group
 *
 * @author petr
 */
class Zend_View_Helper_Group extends Zend_View_Helper_Abstract {
    
    public function group($data = null, array $config = array()) {
        if (is_null($data)) {
            return $this;
        }
        
        $helper = $this->view->tableLayout();
        
        return sprintf("<table class='info-table'><tbody>%s%s%s</tbody></table>",
                $helper->row(array("#", $data["id"])),
                $helper->row(array("Name", $data["name"])),
                $helper->row(array("Count of users", $data["cnt"]))
                );
    }
    
    public function groups($data, array $config = array()) {
        // vygenerovani hlavicky
        $tableHelper = $this->view->tableLayout();
        
        $head = $tableHelper->row(array(
            "#",
            "Name",
            "Users"
        ), array("cellTag" => "th"));
        
        // vygenerovani seznamu radku
        $rows = array();
        
        foreach ($data as $item) {
            $url = $this->view->url(array("id" => $item["id"]), "group-get");
            
            $rows[] = $tableHelper->row(array(
                $item["id"],
                sprintf("<a href='%s'>%s</a>", $url, $item["name"]),
                $item["cnt"]
            ));
        }
        
        $body = implode("", $rows);
        
        return sprintf("<table><thead>%s</thead><tbody>%s</tbody></table>", $head, $body);
    }
}

?>
