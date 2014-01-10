<?php

class Application_Form_User extends MP_Form {

    public function init() {

        $this->setName("user");
        $this->setMethod("post");
        $this->setElementsBelongTo("user");

        $this->addElement("text", "login", array(
            "label" => "Login name",
            "required" => true,
            "validators" => array(
                new Zend_Validate_Alnum(false),
                new Zend_Validate_StringLength(array("min" => 5)),
                new Zend_Validate_Db_NoRecordExists(array(
                    "table" => "users",
                    "field" => "login"
                ))
            )
        ));

        $this->addElement("text", "username", array(
            "label" => "Real name",
            "required" => true
        ));

        $this->addElement("password", "password", array(
            "label" => "Password",
            "required" => true,
            "filters" => array(
                new Zend_Filter_Null()
            ),
            "validators" => array(
                new Zend_Validate_StringLength(array("min" => 5))
            )
        ));

        $this->addElement("password", "password_confirm", array(
            "label" => "Password confirm",
            "required" => true,
            "filters" => array(
                new Zend_Filter_Null()
            )
        ));

        $this->addElement("select", "role", array(
            "label" => "Role",
            "required" => true,
            "multiOptions" => MP_Role::getRoles()
        ));

        $this->addElement("submit", "submit", array(
            "label" => "Save"
        ));

        // priprava validatoru stejneho hesla a kontroly hesla
        $sameValidator = new Zend_Validate_Identical("password", true);
        $sameValidator->setMessage("Password and password confirmation are not same", Zend_Validate_Identical::NOT_SAME);
        $this->_elements["password_confirm"]->addValidator($sameValidator, false);
    }

}
