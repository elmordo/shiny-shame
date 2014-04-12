<?php

class MP_Form_Decorator_MPForm extends Zend_Form_Decorator_Abstract {

    protected $_helper = "form";

    public function getHelper() {
        return $this->_helper;
    }

    public function render($content) {
        $form    = $this->getElement();
        $view    = $form->getView();

        // vyhodnoceni, jestli se ma vlozit navratovy odkaz
        $returnUrl = $form->getValue(MP_Form::RETURN_ELEMENT);

        if (!is_null($returnUrl) && $returnUrl !== $_SERVER["REQUEST_URI"]) {
            $content = $view->buttonLink("Back to previous page", $returnUrl) . $content;
        }

        if (null === $view) {
            return $content;
        }

        $helper        = $this->getHelper();
        $attribs       = $this->getOptions();
        $name          = $form->getFullyQualifiedName();
        $attribs['id'] = $form->getId();

        $attribs = array_merge($form->getAttribs(), $attribs);
        return $view->$helper($name, $attribs, $content);
    }
}