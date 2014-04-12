<?php
class MP_Form extends Zend_Form {
    
    const PERMISIONS_SUBFORM = "permisions";
    const RETURN_ELEMENT = "__returnto__";

    protected $_decorators = array("MPForm");

    protected $_elementDecorators = array(
        "ViewHelper",
        "Standard"
        );

    public function __construct($options = null) {
        // registrace rozsireni dektoratoru
        $this->addPrefixPath("MP_Form_Decorator_", "MP/Form/Decorator/", Zend_Form::DECORATOR);
        parent::__construct($options);
        
        // nastaveni dekoratoru formulare
        $this->_decorators = array(
            new Zend_Form_Decorator_FormElements(),
            new Zend_Form_Decorator_HtmlTag(array(
                "tag" => "div",
                "class" => "form-content"
            )),
            new Zend_Form_Decorator_Form()
        );

        // vlozeni zakladniho prvku pro navratovou adresu pri neuspechu
        $this->addElement("hidden", self::RETURN_ELEMENT);

        // vlozeni dekoratoru formulare
        $this->setDecorators(array(
            new Zend_Form_Decorator_FormElements(),
            new Zend_Form_Decorator_HtmlTag(array("class" => "form-content")),
            new MP_Form_Decorator_MPForm()
        ));

        $this->setMethod("post");
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
    
    public function populate(array $values, $route=null) {
        parent::populate($values);
        
        if (!is_null($route)) {
            $this->setRouteAction($route, $values);
        }
    }

    /**
     * vykresli formular
     */
    public function render() {
        // kontrola, jesti je nastavena hodnota navratoveho pole
        $retElement = $this->_elements[self::RETURN_ELEMENT];

        if (!$retElement->getValue()) {
            $retElement->setValue($_SERVER["REQUEST_URI"]);
        }

        return parent::render();
    }
    
    /**
     * nastavi akci z routy
     * 
     * @param type $route
     * @param type $params
     * @return \MP_Form
     */
    public function setRouteAction($route, $params) {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $url = $router->assemble($params, $route);
        
        $this->setAction($url);
        
        return $this;
    }
}