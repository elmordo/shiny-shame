<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Frame
 *
 * @author petr
 */
class Zend_View_Helper_Frame extends MP_View_Helper_Abstract {
    
    public function frame($frame = null, array $config = array()) {
        if (is_null($frame)) {
            return $this;
        }
    }
    
    public function frames($frames, array $config = array()) {
        $config = array_merge(array(
            "listTag" => "ul",
            "listId" => null,
            "itemTag" => "li",
            "listClass" => null,
            "itemClass" => null,
            "infoContainerClass" => null,
            "actions" => array(),
            "actionContainerClass" => null
            ), $config);
        
        $items = array();
        
        foreach ($frames as $frame) {
            $items[] = $this->_listFrameItem($frame, $config);
        }
        
        $content = implode("", $items);
        
        return $this->_wrapToTag($config["listTag"], $content, array("listClass" => $config["listClass"]));
    }
    
    public function listFrameItem(Application_Model_Row_Frame $frame, array $config = array()) {
        $config = array_merge(array(
            "itemTag" => "li",
            "itemClass" => null,
            "infoContainerClass" => null,
            "actions" => array(),
            "actionContainerClass" => null
        ), $config);
        
        return $this->_listFrameItem($frame, $config);
    }
    
    protected function _listFrameItem(Application_Model_Row_Frame $frame, array $config = array()) {
        $date = $this->view->sqlDateTime($frame->taken_at);
        $ord = $frame->ord;
        $imgSrc = $frame->getPublicSmallPath();
        $fullUrl = $frame->getPublicFullPath();
        
        // sestaveni obrazku a informaci
        $img = $this->_wrapToTag("img", null, array("src" => $imgSrc));
        $info = $this->_wrapToTag("div", sprintf("%s (%d)", $date, $ord), array("class" => $config["infoContainerClass"]));
        
        // wrap odkazu
        $a = $this->_wrapToTag("a", $img, array("href" => $fullUrl, "target" => "_blank"));
        
        // vytvoreni akci
        if ($config["actions"]) {
            $params = $frame->toArray();
            $actionList = $this->_generateRouteActions($config["actions"], $params);
            
            $actions = $this->_wrapToTag("div", $actionList, array("class" => $config["actionContainerClass"]));
        } else {
            $actions = "";
        }
        
        return $this->_wrapToTag($config["itemTag"], $a . $info . $actions, array("class" => $config["itemClass"]));
    }
}

?>
