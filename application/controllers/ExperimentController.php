<?php

class ExperimentController extends Zend_Controller_Action {

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
        $experiment = self::findExperiment($this->_request->getParam("id"));

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
        $experiment = self::findExperiment($this->_request->getParam("id"));

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

    public static function findExperiment($id) {
        $tableExperiments = new Application_Model_Experiments();
        $experiment = $tableExperiments->findById($id);

        if (is_null($experiment))
            throw new Zend_Db_Table_Exception(sprintf("Experiment #%s not found", $id));

        return $experiment;
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
            $micList[$microscope->id] = $microscope->name;
        }

        $form->getElement("microscope_id")->setMultiOptions($micList);

        return $form;
    }

}
