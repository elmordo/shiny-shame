<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessPermisions
 *
 * @author petr
 */
class MP_Form_AccessPermisions extends Zend_Form_SubForm {
    
    const USER_NAME = "user";
    const GROUP_NAME = "group";
    const OTHER_NAME = "other";
    const GROUP_ID_NAME = "group_id";
    
    const FORM_BELONGS_TO = "subform_permisions";
    
    protected $_permisions = "access_permisions";
    
    protected $_groupId = "group_id";
    
    public function init() {
        
        $this->setElementsBelongTo(self::FORM_BELONGS_TO);
        $this->setLegend("Permisions");
        
        // priprava prav
        $none = "---";
        $read = "r--";
        $write = "rw-";
        $delete = "rwd";
        
        $vals = array(
            $none => "No access",
            $read => "Only read",
            $write => "Read and write",
            $delete => "Read, write and delete"
        );
        
        $this->addElement("select", self::GROUP_ID_NAME, array(
            "label" => "Group",
            "description" => "User group who has special access rights",
            "filters" => array(
                new Zend_Filter_Null()
            ),
            "required" => false,
            "multiOptions" => array("" => "-- NO GROUP SELECTED --") + Application_Model_Groups::getGroupsIndex()
        ));
        
        $this->addElement("select", self::USER_NAME, array(
            "multiOptions" => $vals,
            "value" => $delete,
            "required" => true,
            "label" => "User"
        ));
        
        $this->addElement("select", self::GROUP_NAME, array(
            "multiOptions" => $vals,
            "value" => $read,
            "required" => true,
            "label" => "Group"
        ));
        
        $this->addElement("select", self::OTHER_NAME, array(
            "multiOptions" => $vals,
            "value" => $read,
            "required" => true,
            "label" => "Other"
        ));
        
    }
    
    public function getPermisions() {
        return array(
            $this->_groupId => $this->getValue(self::GROUP_ID_NAME),
            $this->_permisions => $this->getValue(self::USER_NAME) . $this->getValue(self::GROUP_NAME) . $this->getValue(self::OTHER_NAME)
        );
    }
    
    public function setDefaults(array $values) {
        // vyhodnoceni, jestli byl formular odeslan
        if (isset($values[self::FORM_BELONGS_TO])) {
            parent::setDefaults($values);
        } else {
            // rozlozeni pristupovych prav na segmenty
            $elementName = $this->_permisions;
            $user = substr($values[$elementName], 0, 3);
            $group = substr($values[$elementName], 3, 3);
            $other = substr($values[$elementName], 6, 3);
            
            // sestaveni pole
            $newVals = array(
                self::FORM_BELONGS_TO => array(
                    self::GROUP_ID_NAME => $values[$this->_groupId],
                    self::USER_NAME => $user,
                    self::GROUP_NAME => $group,
                    self::OTHER_NAME => $other
                )
            );
            
            parent::setDefaults($newVals);
        }
       
    }
    
}

?>
