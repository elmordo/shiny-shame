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
class Zend_View_Helper_Frame extends Zend_View_Helper_Abstract {
    
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
            "listClass" => "",
            "itemClass" => "",
            "infoContainerClass" => ""
            ), $config);
        
        $items = array();
        
        foreach ($frames as $frame) {
            $items[] = $this->_listFrameItem($frame, $config);
        }
        
        if (!is_null($config["listId"])) {
            $id = sprintf(" id='%s'", $config["listId"]);
        } else {
            $id = "";
        }
        
        return sprintf("<%s%s class='%s'>%s</%s>", $config["listTag"], $id, $config["listClass"], implode("", $items), $config["listTag"]);
    }
    
    public function listFrameItem(Application_Model_Row_Frame $frame, array $config = array()) {
        $config = array_merge(array(
            "itemTag" => "li",
            "itemClass" => "",
            "infoContainerClass" => ""
        ), $config);
        
        return $this->_listFrameItem($frame, $config);
    }
    
    protected function _listFrameItem(Application_Model_Row_Frame $frame, array $config = array()) {
        $date = $this->view->sqlDateTime($frame->taken_at);
        $ord = $frame->ord;
        $imgSrc = $frame->getPublicSmallPath();
        $fullUrl = $frame->getPublicFullPath();
        
        return sprintf("<%s class='%s'><a href='%s' target='_blank'><img src='%s'></a><div class='%s'>%s (%d)</div></%s>", $config["itemTag"], $config["itemClass"], $fullUrl, $imgSrc, $config["infoContainerClass"], $date, $ord, $config["itemTag"]);
    }
}

?>
