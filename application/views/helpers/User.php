<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author petr
 */
class Zend_View_Helper_User extends Zend_View_Helper_Abstract {
    
    /**
     * vraci HTML hlavicku tabulky
     * @param array $config
     * @return string
     */
    public function header(array $config = array()) {
        return "<thead><tr><th>#</th><th>Login name</th><th>Real name</th><th>Actions</th></tr></tbody>";
    }
    
    public function user($user = null, array $config = array()) {
        if (is_null($user)) {
            return $this;
        }
    }
    
    /**
     * vygeneruje tabulku se seznamem uzivatelu
     * 
     * @param mixed $users seznam uzivatelu
     * @param array $config konfiguracni pole
     * @return string
     */
    public function users($users, array $config = array()) {
        $config = array_merge(array("actions" => array()), $config);
        // vygenerovani hlavicky
        $header = $this->header();
        
        // vygenerovani radku
        $rows = array();
        
        foreach ($users as $user) {
            // vygenerovani akci
            $actions = array();
            
            foreach ($config["actions"] as $action => $label) {
                $url = $this->view->url($user->toArray(), $action);
                
                $actions[] = sprintf("<a href='%s'>%s</a>", $url, $label);
            }
            
            $rows[] = sprintf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td></tr>", 
                    $user->user_id,
                    $user->login,
                    $user->username,
                    implode(" ", $actions));
        }
        
        return sprintf("<table>%s<tbody>%s</tbody></table>", $header, implode("", $rows));
    }
}

?>
