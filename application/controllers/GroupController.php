<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GroupController
 *
 * @author petr
 */
class GroupController extends MP_Controller_Action {
    
    const DEL_ARRAY = "delgroup";
    
    protected $_sourceTable = "Application_Model_Groups";
    
    /**
     * smaze uzivatelskou skupinu
     */
    public function deleteAction() {
        $form = self::prepareDeleteFrom();
        $params = $this->_request->getParams();
        $this->view->deleted = false;
        
        if ($this->_request->isPost() && isset($params[self::DEL_ARRAY])) {
            if ($form->isValid($params)) {
                $group = $this->findById($this->_request->getParam("group_id"));
                $group->delete();
                
                $this->view->deleted = true;
            }
        }
        
        $this->view->form = $form;
    }
    
    /**
     * vypise informace o uzivatelske skupine
     */
    public function getAction() {
        $group = $this->findById($this->_request->getParam("group_id"));
        
        $this->view->group = $group;
    }
    
    /**
     * zobrazi seznam uzivatelskych skupin
     */
    public function indexAction() {
        // nacteni seznamu skupin
        $tableGroups = new Application_Model_Groups();
        $groups = $tableGroups->findGroups();
        
        $this->view->groups = $groups;
    }
    
    /**
     * vytvori novou uzivatelskou skupinu
     */
    public function postAction() {
        $form = new Application_Form_Group();
        
        if ($this->_request->isPost() && $form->isValid($this->_request->getParams())) {
            $tableGroups = new Application_Model_Groups();
            $row = $tableGroups->createRow($form->getValues(true));
            $row->save();
            
            $this->view->row = $row;
        }
        
        $this->view->form = $form;
    }
    
    /**
     * uzlozi zmeny v uzivatelske skupine
     */
    public function putAction() {
       $form = new Application_Form_Group();
       $group = $this->findById($this->_request->getParam("group_id"));
       $form->populate($group->toArray());
       
       if ($this->_request->isPost()) {
           if ($form->isValid($this->_request->getParams())) {
               $group->setFromArray($form->getValues(true));
               $group->save();
               
               $this->view->saved = true;
           }
       }
       
       $this->view->form = $form;
       $this->view->group = $group;
    }
    
    public function usersAction() {
        $group = $this->findById($this->_request->getParam("group_id"));
        
        $users = $group->findUsers();
        $form = new Application_Form_Group_Users();
        $form->setUsers($users); 
        
        if ($this->_request->isPost() && $this->_request->getParam($form->getElementsBelongTo())) {
            if ($form->isValid($this->_request->getParams())) {
                // zapis dat
                $tableAssocs = new Application_Model_UsersHaveGroups();
                $values = $form->getValues(true);
                unset($values["submit"]);
                
                $group->setUsers($values["groupusers"]);
                
                $this->view->userssaved = true;
            }
        }
        
        $this->view->form = $form;
    }
    
    /**
     * pripravi formular pro smazani skupiny
     * 
     * @param int $id identifikacni cislo skupiny
     * @return \MP_Form_Delete
     */
    public static function prepareDeleteFrom($id = null) {
        $form = new MP_Form_Delete();
        $form->setElementsBelongTo("delgroup");
        
        if (!is_null($id)) {
            $form->setAction("/group/delete?id=" . $id);
        }
        
        return $form;
    }
}

?>
