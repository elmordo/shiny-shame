<?php
class MP_Form extends Zend_Form {
    
    const PERMISIONS_SUBFORM = "permisions";
    
    protected $_elementDecorators = array(
        "ViewHelper",
        "Standard"
        );

    public function __construct($options = null) {
        $this->addPrefixPath("MP_Form_Decorator_", "MP/Form/Decorator/", Zend_Form::DECORATOR);
        parent::__construct($options);
        
        $this->_decorators = array(
            new Zend_Form_Decorator_FormElements(),
            new Zend_Form_Decorator_HtmlTag(array(
                "tag" => "div",
                "class" => "form-content"
            )),
            new Zend_Form_Decorator_Form()
        );
    }


    /**
     * nejprve zkonstroluje, jestou jsou nejaka data k dipozici
     * 
     * @param $data kontrolovana data
     */
    public function isValid($data) {
        // vyhodnoceni, jestli je nastaveno elementsBelongsTo
        if ($this->_elementsBelongTo) {
            // vyhodnoceni jestli je tato hodnota v datech pritomna
            if (!isset($data[$this->_elementsBelongTo])) {
                return false;
            }
        }
        
        return parent::isValid($data);
    }
    
    public function getValues($suppressArrayNotation = false) {
        $retVal = parent::getValues($suppressArrayNotation);
        
        // kontrola subformularu, jestli tam je access permisions
        foreach ($this->getSubForms() as $name => $subForm) {
            if ($subForm instanceof MP_Form_AccessPermisions) {
                // odstraneni puvodni hodnoty
                unset($retVal[$subForm->getElementsBelongTo()]);
                
                // nacteni hodnot a zapis do navratove hodnoty
                $permData = $subForm->getPermisions();
                
                // zapis hodnot do navratove hodnoty
                $belongs = $this->getElementsBelongTo();
                
                if (!$suppressArrayNotation) {
                    $retVal[$belongs] += $permData;
                } else {
                    $retVal += $permData;
                }
            }
        }
        
        return $retVal;
    }
}