<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Experiment
 *
 * @author petr
 */
class MP_Storage_Frames {
    
    const DEFAULT_PATH = "/../data/experiments";
    
    const SOURCE_FILE = 0;
    const SOURCE_STRING = 1;
    
    /**
     * archiv s daty
     *
     * @var ZipArchive
     */
    private $_archive = null;
    
    /**
     * radek s experimentem, ktereho se uloziste tyka
     *
     * @var Application_Model_Row_Experiment
     */
    private $_experiment = null;
    
    /**
     * cesta k souboru s archivem
     *
     * @var string
     */
    private $_archivePath = null;
    
    public function __construct(Application_Model_Row_Experiment $experiment, $basePath = self::DEFAULT_PATH) {
        if (is_null($basePath)) {
            $basePath = self::DEFAULT_PATH;
        }
        
        // nastaveni experimentu
        $this->_experiment = $experiment;
        
        // sestaveni cesty k archivu
        $dataDir = APPLICATION_PATH . $basePath;
        $fileName = sprintf("%s/experiment_%d.zip", $dataDir, $experiment->experiment_id);
        
        // kontrola, jestli archiv existuje
        $archive = new ZipArchive();
        
        if (($status = $archive->open($fileName)) !== true) {
            $error = "unknown error";
            
            switch ($status) {
                case ZipArchive::ER_OPEN:
                    $error = "can not open file";
                    break;
            }
            
            throw new MP_Storage_Exception("Error in storage opening. Returned: " . $error);
        }
        
        $this->_archive = $archive;
        $this->_archivePath = $fileName;
    }
    
    /**
     * prida snimek do archivu. Pokud kolekce neni nastavena, vlozi ho do korenoveho adresare
     * 
     * @param string $file jmeno souboru, kde je snimek ulozen
     * @param Application_Model_Row_Frame $frame radek s daty o snimku
     * @param int $source identifikace zdroje
     */
    public function addFrame($file, Application_Model_Row_Frame $frame, $source = self::SOURCE_FILE) {
        // sestaveni interniho jmena a zapis do souboru
        $localName = $this->getFramePath($frame);
        
        switch ($source) {
            case self::SOURCE_FILE:
                $this->_archive->addFile($file, $localName);
                break;
            
            case self::SOURCE_STRING:
                $this->_archive->addFromString($localName, $file);
                break;
        }
    }

    /**
     * vraci experiment
     * 
     * @return Application_Model_Row_Experiment
     */
    public function getExperiment() {
        return $this->_experiment;
    }
    
    /**
     * vraci TIFF jako retezec
     * 
     * @param Application_Model_Row_Frame $frame
     * @return string
     */
    public function getFrameData(Application_Model_Row_Frame $frame) {
        // nacteni cesty
        $path = $this->getFramePath($frame);
        
        // vraceni dat
        return $this->_archive->getFromName($path);
    }
    
    /**
     * vraci cestu ke snimku v archivu
     * 
     * @param Application_Model_Row_Frame $frame radek s infromacemi o snimku
     * @return string
     */
    public function getFramePath($frame) {
        // sestaveni datumu a casu
        list($sqlDate, $sqlTime) = explode(" ", $frame->taken_at);
        $dateParts = explode("-", $sqlDate);
        $date = substr($dateParts[0], 2, 2) . $dateParts[1] . $dateParts[2];
        
        $time = str_replace(":", "", $sqlTime);
        return sprintf("%s/%s_%s_%d.%s", $frame->tag, $date, $time, $frame->ord, $frame->format);
    }
    
    /**
     * vraci jmeno souboru, ve kterem je archiv ulozen
     * 
     * @return string
     */
    public function getStorageLocation() {
        return $this->_archivePath;
    }
    
    /**
     * ulozi zmeny v archivu
     */
    public function saveArchive() {
        // uzavreni (a ulozeni) a nasledne znovu otevreni archivu
        $this->_archive->close();
        $this->_archive->open($this->_archivePath);
    }
}

?>
