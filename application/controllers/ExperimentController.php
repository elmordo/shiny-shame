<?php

class ExperimentController extends MP_Controller_Action {

    protected $_sourceTable = "Application_Model_Experiments";
    
    /**
     * zkopiruje metainformace o experimentu
     */
    public function copyinfoAction() {
        $id = $this->_request->getParam("experiment_id");
        $experiment = $this->findById($id);
        
        // nacteni a zapis novych dat
        $experiment->importMicroscopeMeta();
        
        $this->view->experiment = $experiment;
    }
    
    /**
     * smaze experiment
     */
    public function deleteAction() {
        
    }

    /**
     * zobrazi experiment
     */
    public function getAction() {
        // nacteni dat
        $experiment = $this->findById($this->_request->getParam("experiment_id"));

        $this->view->experiment = $experiment;
    }

    /**
     * zobrazi seznam experimentu
     */
    public function indexAction() {
        // nacteni seznamu experimentu
        $tableExperiments = new Application_Model_Experiments();

        $experiments = $tableExperiments->findByUser(Zend_Auth::getInstance()->getIdentity());

        $this->view->experiments = $experiments;
    }

    /**
     * vytvori novy experiment
     */
    public function postAction() {
        // vytvoreni formulare
        $form = self::prepareExperimentForm();

        if ($this->_request->isPost()) {
            // formular byl odeslan -> zkontroluji se data
            if ($form->isValid($this->_request->getParams())) {
                // formular je validni - vytvoreni radku
                $tableExperiments = new Application_Model_Experiments();
                $experiment = $tableExperiments->createExperiment($form->getValues(true), Zend_Auth::getInstance()->getIdentity());

                $this->view->experiment = $experiment;
            }
        }

        $this->view->form = $form;
    }

    /**
     * upravi stavajici experiment
     */
    public function putAction() {
        // nacteni dat
        $form = self::prepareExperimentForm();
        $experiment = $this->findById($this->_request->getParam("experiment_id"));

        if ($this->_request->isPost()) {
            // formular byl odeslan, dojde k validaci a pripadnemu ulozeni dat
            if ($form->isValid($this->_request->getParams())) {
                $experiment->setFromArray($form->getValues(true));
                $experiment->save();

                $this->view->redirect = true;
            }
        } else {
            $form->populate($experiment->toArray());
        }

        $this->view->form = $form;
        $this->view->experiment = $experiment;
    }

    /**
     * nastavi hodnoty formulare
     * pokud formular neni predan, je vytvorena nova instance
     * 
     * @param Application_Form_Experiment $form formular k nastaveni
     * @return Application_Form_Experiment
     */
    public static function prepareExperimentForm($form = null) {
        // kontrola existence formulare
        if (is_null($form)) {
            $form = new Application_Form_Experiment();
        }

        // vytcoreni tabulky a nacteni mikroskopu
        $tableMicroscopes = new Application_Model_Microscopes();
        $microscopes = $tableMicroscopes->findAvailables();

        $micList = array("" => "--NO MICROSCOPE SELECTED--");

        foreach ($microscopes as $microscope) {
            $micList[$microscope->microscope_id] = $microscope->name;
        }

        $form->getElement("microscope_id")->setMultiOptions($micList);

        return $form;
    }

}
