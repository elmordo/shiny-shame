<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Upload
 *
 * @author petr
 */
class Application_Form_FrameUpload extends MP_Form {
    
    public function init() {
        
        $this->setName("uploadframes");
        $this->setElementsBelongTo("uploadframes");
        $this->setEnctype("multipart/form-data");
        
        $this->addElement("checkbox", "create_collections", array(
            "label" => "Create collections",
            "required" => false,
            "value" => 1,
            "description" => "If there is not category with image's tag, it will be created. Otherwise, frame will be ignored"
        ));
        
        $this->addElement("checkbox", "rewrite_existing", array(
            "label" => "Rewrite existing frames",
            "required" => false,
            "value" => 1,
            "description" => "If there is some frame with identical ord in collection, this frame will be replaced. Otherwise, it will be ignored"
        ));
        
        $fileElement = new Zend_Form_Element_File("file");
        $fileElement->setOptions(array(
            "label" => "Files",
            "required" => true,
            "description" => "Select TIFF file or ZIP file with archived TIFF images",
            "attribs" => array(
                "multiple" => "multiple",
                "accept" => "application/zip,image/tiff"
            ),
            "validators" => array()
        ));
        
        $this->addElement($fileElement);
        $fileElement->setBelongsTo(null);
        $fileElement->getTransferAdapter()->setDestination(TMP_PATH);
        
        $this->addElement("submit", "submit", array(
            "label" => "Upload"
        ));
    }
}

?>
