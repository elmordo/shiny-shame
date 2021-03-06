<?php
require_once __DIR__ . "/ExperimentController.php";

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FrameController
 *
 * @author petr
 */
class FrameController extends MP_Controller_Action {
    
    const FILE_TIFF = "TIFF";
    const FILE_ZIP = "ZIP";
    
    private static $_frames = array();
    
    protected $_sourceTable = "Application_Model_Frames";
    
    public function appletAction() {
        // vytvoreni pomocneho elementu
        $file = new Zend_Form_Element_File("File0");
        
        // nacteni dat
        $serieId = $this->_request->getParam("serie_id");
        $serie = self::findRowById($serieId, "Series");
        $experiment = self::findRowById($serie->experiment_id, "Experiments");
        $archive = new MP_Storage_Frames($experiment);
        
        // nactnei indexu kolekci
        $collectionIndex = $this->_loadCollections($serie);
        
        $this->saveTiff($file, $serie, $archive, $collectionIndex, true, true);
    }
    
    /**
     * stahne originalni TIFF obrazek
     */
    public function downloadAction() {
        // nacteni informaci
        $experiment = self::findRowById($this->_request->getParam("experiment_id"), "Experiments");
        
        // kontrola opravneni pristupu k experimentu
        if (!$experiment->checkAccess(MP_Db_Table_Row_DataAccess::ACCESS_READ)) {
            throw new MP_Db_Table_Row_DataAccess_Exception("Read is forbidden");
        }
        
        // nacteni radku se snimkem
        $frame = $this->findById($this->_request->getParam("frame_id"));
        
        // otevreni uloziste a zapis dat do view
        $storage = new MP_Storage_Frames($experiment);
        
        $this->view->imageContent = $storage->getFrameData($frame);
        $this->view->frame = $frame;
        $this->view->experiment = $experiment;
    }
    
    public function indexAction() {
        // nacteni informaci
        $serieId = $this->_request->getParam("serie_id", null);
        $collectionId = $this->_request->getParam("collection_id", null);
        
        if (is_null($serieId)) throw new Zend_Controller_Router_Exception("Experimet id can not be null");
        
        $tableFrames = new Application_Model_Frames();
        $frames = $tableFrames->findBySerieAndCollection($serieId, $collectionId);

        $this->view->frames = $frames;
    }
    
    /**
     * zobrazi podrobnosti o obrazku
     */
    public function getAction() {
        // nacteni snimku a experimentu
        $frame = $this->findById($this->_request->getParam("frame_id"));
        $serie = self::findRowById($this->_request->getParam("serie_id"), "Series");
        
        // nacteni kolekci
        $collections = $frame->findCollections();
        $userCollections = $frame->findUserCollections();
        
        $formUserCollections = new Application_Form_Frame_UserCollections();
        $formUserCollections->setCollections($userCollections);
        
        $this->view->frame = $frame;
        $this->view->serie = $serie;
        $this->view->collections = $collections;
        $this->view->formUserCollections = $formUserCollections;
    }
    
    /**
     * editace obrazku
     */
    public function putAction() {
        $frame = $this->findById($this->_request->getParam("frame_id"));
        $experiment = self::findRowById($this->_request->getParam("experiment_id"), "Experiments");
        
        $form = new Application_Form_Frame();
        $form->populate($frame->toArray());
        
        if ($this->_request->isPost() && $form->isValid($this->_request->getParams())) {
            $frame->setFromArray($form->getValues(true));
            $frame->save();
        }
        
        $this->view->frame = $frame;
        $this->view->experiment = $experiment;
        $this->view->form = $form;
    }

    public function uploadAction() {
        $form = @new Application_Form_FrameUpload();
        
        if ($this->_request->isPost()) {
            // nacteni informaci
            $form->populate($this->_request->getParams());
            
            $createCols = $form->getValue("create_collections");
            $rewrite = $form->getValue("rewrite_existing");
            
            // nacteni experimentu
            $serie = self::findRowById($this->_request->getParam("serie_id"), "Series");
            $experiment = self::findRowById($this->_request->getParam("experiment_id"), "Experiments");
            
            // nacteni existujici kolekci a jejich indexace dle tagu
            $collections = $this->_loadCollections($serie);
            
            // otevreni archivu
            $archive = new MP_Storage_Frames($experiment);
            
            // vyhodnoceni typu souboru
            $fileElement = $form->getElement("file");
            /* @var $fileElement Zend_Form_Element_File */
            
            $fileName = $fileElement->getFileName();
            $extension = strtoupper(pathinfo($fileName, PATHINFO_EXTENSION));
            
            switch($extension) {
                case self::FILE_TIFF:
                    $this->saveTiff($fileElement, $serie, $archive, $collections, (bool) $createCols, (bool) $rewrite);
                    break;
                
                case self::FILE_ZIP:
                    $this->saveZip($fileElement, $serie, $archive, $collections, (bool) $createCols, (bool) $rewrite);
                    break;
                
            }
            
            $this->view->uploaded = true;
        }
        
        $this->view->form = $form;
    }
    
    public function ucollectionsAction() {
        $frameId = $this->_request->getParam("frame_id");
        $frame = $this->findById($frameId);
        
        $collections = $frame->findUserCollections();
        $formCollections = new Application_Form_Frame_UserCollections();
        $formCollections->setCollections($collections);
        
        // kontrola validity a pripadny zapis zmen
        if ($this->_request->isPost() && $formCollections->isValid($this->_request->getParams())) {
            // smazani starych dat
            $tableAssocs = new Application_Model_CollectionsHaveFrames();

            // vlozeni dat
            $collectionIds = array();
            $values = $formCollections->getValues(true);
            
            foreach ($values as $id => $val) {
                if ($val) {
                    $collectionIds[] = $id;
                }
            }
            
            $tableAssocs->setFrameCollections($frame, $collectionIds);
            $frame->setSaved(true);
        }
        
        $this->view->formCollections = $formCollections;
        $this->view->frame = $frame;
    }
    
    /**
     * ulozi nahrany jeden TIFF obrazek
     * 
     * @param Zend_Form_Element_File $file formularove policko souboru
     * @param Application_Model_Row_Serie $serie radek experimentu, ke kteremu snimek nalezi
     * @param MP_Storage_Frames $archive uloziste dat
     * @param ArrayObject $collectionIndex index kolekci
     * @param bool $createCollections prepinac povolujici nebo zakazujici tvorbu novych kolekci
     * @param bool $rewriteExisting prepinac povolujici nebo zakazujici prepisovani existujicich snimku
     * @return type
     * @throws Zend_File_Transfer_Exception
     */
    public function saveTiff(Zend_Form_Element_File $file, $serie, MP_Storage_Frames $archive, ArrayObject $collectionIndex, $createCollections, $rewriteExisting) {
        // rozlozeni a kontrola nazvu
        $fileName = $file->getFileName();
        $info = pathinfo($fileName);
        $report = MP_Parser_Filename::parse($info["basename"]);
        
        // nacteni kolekce
        $collection = $this->_getCollection($serie, $report->collection, $collectionIndex, $createCollections);
        
        if (is_null($collection)) return;
        
        $file->receive();
        $file->receive();
        
        $filesInfo = $file->getFileInfo();
        
        if (isset($filesInfo["file"])) {
            $fileName = $filesInfo["file"]["tmp_name"];
        } else {
            $fileName = $filesInfo["File0"]["tmp_name"];
        }
        
        // kontrola existence souboru
        if (!is_file($fileName)) {
            $fileName = $file->getFileName();
            
            if (!is_file($fileName)) {
                throw new Zend_File_Transfer_Exception();
            }
        }
        
        $this->_saveFile($serie, $archive, $collection, $fileName, $report, $rewriteExisting);
    }
    
    /**
     * ulozi serii TIFF souboru ze ZIP archivu
     * 
     * @param Zend_Form_Element_File $file formularove policko souboru
     * @param Application_Model_Row_Serie $serie radek experimentu, ke kteremu snimek nalezi
     * @param MP_Storage_Frames $archive uloziste dat
     * @param ArrayObject $collectionIndex index kolekci
     * @param bool $createCollections prepinac povolujici nebo zakazujici tvorbu novych kolekci
     * @param bool $rewriteExisting prepinac povolujici nebo zakazujici prepisovani existujicich snimku
     * @return type
     * @throws Zend_File_Transfer_Exception
     */
    public function saveZip(Zend_Form_Element_File $file, $serie, MP_Storage_Frames $archive, ArrayObject $collectionIndex, $createCollections, $rewriteExisting) {
        // prijem souboru a nacteni jmena
        $file->receive();
        $file->receive();
        
        $filesInfo = $file->getFileInfo();
        $fileName = $filesInfo["file"]["tmp_name"];
        
        // kontrola existence souboru
        if (!is_file($fileName)) {
            $fileName = $file->getFileName();
            
            if (!is_file($fileName)) {
                throw new Zend_File_Transfer_Exception();
            }
        }
        
        // nacteni souboru
        $zipSource = new ZipArchive();
        $zipSource->open($fileName, ZipArchive::CREATE);
        
        // iterace nad zaznamy a zapis dat do databaze a na disk
        $maxI = $zipSource->numFiles;
        
        for ($i = 0; $i < $maxI; $i++) {
            // nacteni zaznamu
            $itemName = $zipSource->getNameIndex($i);
            $itemInfo = pathinfo($itemName, PATHINFO_EXTENSION);
            
            // vyhodnoceni, jestli je soubor tiff obrazek
            $extension = strtoupper($itemInfo);
            
            if ($extension == self::FILE_TIFF) {
                // rozebrani jmena souboru
                $itemFileName = pathinfo($itemName, PATHINFO_BASENAME);
                $parseReport = MP_Parser_Filename::parse($itemFileName);
                
                // kontrola, jestli je parse report null
                if (is_null($parseReport)) {
                    continue;
                }
                
                // rozbaleni a upload souboru
                $tmpFile = tempnam(TMP_PATH, "imp");
                
                $zp = $zipSource->getStream($itemName);
                $fp = fopen($tmpFile, "w");
                
                if ($zp === false) throw new Zend_Exception();
                
                while(!feof($zp)) {
                    // zapisujeme po jednom MB
                    fwrite($fp, fread($zp, 1048510));
                }
                
                // nacteni kolekce
                $collection = $this->_getCollection($serie, $parseReport->collection, $collectionIndex, $createCollections);
                
                // kontrola kolekce - pokud kolekce neni, pak se preskakuje na dalsi snimek
                if (is_null($collection)) {
                    continue;
                }
                
                // import souboru
                $this->_saveFile($serie, $archive, $collection, $tmpFile, $parseReport, $rewriteExisting);
                
                // odstraneni docasneho souboru
                unlink($tmpFile);
            }
        }
    }


    /**
     * zpracuje snimek
     * 
     * @param Application_Model_Row_Experiment $serie zdrojova serie snimku
     * @param MP_Storage_Frames $archive uloziste dat
     * @param Application_Model_Row_Collection $collection kolekce, do ktere bude snimek pridan
     * @param string $fileName jmeno fyzickeho souboru na serveru
     * @param MP_Parser_Result $parseReport zaznam z parsovani jmena souboru
     * @param bool $rewriteExisting povoluje nebo zakazuje prepis existujicich snimku
     * @return Application_Model_Row_Frame
     */
    private function _saveFile($serie, MP_Storage_Frames $archive, Application_Model_Row_Collection $collection, $fileName, MP_Parser_Result $parseReport, $rewriteExisting) {
        // kontrola, jestli neni uz dany objekt zapsan
        $tableFrames = new Application_Model_Frames();
        $frame = $tableFrames->findByInfo($serie->serie_id, $parseReport->collection, $parseReport->ord);
        
        if ($frame) {
            // snimek byl nalezen a musime se rozhodnout, co udelame
            if ($rewriteExisting) {
                // muzeme prepisovat existujici
                $frame->delete();
            } else {
                // nemuzeme prepisovat existujici
                return;
            }
        }
        
        $frame = $tableFrames->createRow(array(
            "serie_id" => $serie->serie_id,
            "tag" => $parseReport->collection,
            "format" => $parseReport->format,
            "taken_at" => sprintf("20%s-%s-%s %s:%s:%s", 
                    $parseReport->year,
                    $parseReport->month,
                    $parseReport->day,
                    $parseReport->hour,
                    $parseReport->minute,
                    $parseReport->second),
            "ord" => $parseReport->ord,
            "size" => filesize($fileName)
        ));
        /*
        // prevedeni na JPEG soubor
        $tmpFullName = $fileName . "_full.jpeg";
        $tmpSmallName = $fileName . "_small.jpeg";
        
        // prevedeni plneho souboru a nahledu
        $cmdFull = sprintf("convert %s %s", $fileName, $tmpFullName);
        $cmdSmall = sprintf("convert %s -resize 300x300 %s", $fileName, $tmpSmallName);
        
        exec($cmdFull);
        exec($cmdSmall);
        
        // otevreni plneho souboru a nacteni velikosti
        $imgSize = getimagesize($tmpFullName);
        
        $frame->width = $imgSize[0];
        $frame->height = $imgSize[1];
        */
        
        // ulozeni snimku a zapis do kolekce
        $frame->save();
        $collection->addFrame($frame);

        // zapis do archivu
        //$archive->addFrame($fileName, $serie, $frame);

        // vytvoreni pozadavku a odeslani na server
        $request = new MP_PyServer_Request("standard.ImagePreviewer", array(
            file_get_contents($fileName),
            $frame->frame_id,
            300,
            300
        ));

        MP_PyServer_Connection::sendRequest($request);

        // pozadavek na zapis do archivu
        $aRequest = new MP_PyServer_Request("standard.WriteToArchive", array(
            file_get_contents($fileName),
            $archive->getStorageLocation(),
            $archive->getFramePath($serie, $frame)
            ));

        MP_PyServer_Connection::sendRequest($aRequest);

        /*
        $frame->setFullPreview($tmpFullName);
        $frame->setSmallPreview($tmpSmallName);
        
        // odstraneni docasnych souboru
        unlink($tmpFullName);
        unlink($tmpSmallName);
        */
        return $frame;
    }
    
    /**
     * vraci kolekci z indexu dle jmena
     * pokud kolekce neexistuje a parameter $createCollection je nastaven na True, pak vytvori novou kolekci
     * 
     * @param $serie radek se serii
     * @param type $tag predpona kolekce
     * @param array $collectionIndex aktualni index kolekci
     * @param bool $createCollections povoleni zda se smi vytvaret nove kolekce
     */
    private function _getCollection($serie, $tag, ArrayObject &$collectionIndex, $createCollections) {
        // kontrola, jestli kolekce exsituje
        if (!isset($collectionIndex[$tag])) {
            // kotnrola potvrzeni vytvaret nove kolekce
            if (!$createCollections) {
                return null;
            }
            
            // vytvoreni nove kolekce
            $tableCollections = new Application_Model_Collections();
            $collection = $tableCollections->createCollection(array(
                "tag" => $tag,
                "name" => $tag
            ), $serie);
            
            $collectionIndex[$tag] = $collection;
        }
        
        // vraceni hodnoty
        return $collectionIndex[$tag];
    }
    
    /**
     * nacte a zaindexuje kolekce
     * 
     * @param Application_Model_Row_Serie $serie serie, ze ktere nacist kolekce
     * @return array
     */
    private function _loadCollections(Application_Model_Row_Serie $serie) {
        $collections = $serie->findCollections();
        $collectionIndex = new ArrayObject(array());
            
        foreach ($collections as $collection) {
            if (!is_null($collection->tag)) {
                $collectionIndex[$collection->tag] = $collection;
            }
        }
        
        return $collectionIndex;
    }
}

?>
