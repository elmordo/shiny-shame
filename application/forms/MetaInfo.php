<?php
require_once APPLICATION_PATH . "/controllers/MetaController.php";

class Application_Form_MetaInfo extends MP_Form {

    public function init() {
        
        $this->setElementsBelongTo("meta");
        
        $this->addElement("text", "name", array(
            "label" => "Name",
            "required" => true
        ));

        $this->addElement("text", "internal_name", array(
            "label" => "Internal name",
            "required" => true
        ));

        $this->addElement("text", "value", array(
            "label" => "Value",
            "required" => true
        ));

        $this->addElement("submit", "submit", array(
            "label" => "Save"
        ));
    }
    
    public function enableAdminMode() {
        $this->addElement("checkbox", "is_constant", array(
            "label" => "Constant value",
            "required" => true,
            "description" => "Constant values can not be changed outside administration mode",
            "order" => 3
        ));
        
        $this->addElement("hidden", MetaController::REQUEST_PARAM_ADMIN, array(
            "value" => 1
        ));
    }
}