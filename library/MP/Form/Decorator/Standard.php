<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Standard
 *
 * @author petr
 */
class MP_Form_Decorator_Standard extends Zend_Form_Decorator_Abstract {
    
    public function render($content) {
        $element = $this->getElement();
        
        // pripojeni pripadneho popisku
        $description = $element->getDescription();
        
        if ($description) {
            $content .= "<span class='description'>" . $description . "</span>";
        }
        
        // vyhodnoceni typu prvku (jestli je submit nebo button
        if ($element instanceof Zend_Form_Element_Submit || $element instanceof Zend_Form_Element_Button) {
            // element je tlacitko, CSS trida bude definovana dle typu prvku
            $className = get_class($element);
            $classParts = explode("_", $className);
            $cssClass = strtolower($classParts[count($classParts) - 1]);
            
            $contet = "<div class='$cssClass'>" . $content . "</div>";
        } else {
            // vygenerovani labelu
            $labelGenerator = $element->getView();
            $label = $labelGenerator->formLabel($element->getName(), $element->getLabel(), array(
                "class" => $element->isRequired() ? "required" : ""
            ));

            if ($element instanceof Zend_Form_Element_Textarea) {
                // element je textarea, ta se zobrazuje specialne
                $content = sprintf("<div class='textarea-label'>%s</div><div class='textarea'>%s</div>", $label, $content);
            } else {
                $content = sprintf("<div class='label'>%s</div><div class='element'>%s</div><br class='clear' />", $label, $content);
            }
        }
        
        return sprintf("<div class='element-row'>%s</div>", $content);
    }
}

?>
