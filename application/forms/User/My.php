<?php
class Application_Form_User_My extends Application_Form_User {
	
	public function init() {
		parent::init();
		
        $this->setElementsBelongTo("myaccount");
        
		$this->removeElement("login");
		$this->removeElement("role");
		
		$this->addElement("password", "old_password", array(
				"label" => "Old password",
				"required" => false,
				"order" => 1,
                "filters" => array(
                    new Zend_Filter_Null()
                )
				));
        
        $this->setPasswordRequireStatus(false);
	}
    
    /**
     * vraci TRUE pokud jsou hesla vyzadovana
     * 
     * @return bool
     */
    public function getPasswordRequiredStatus() {
        return $this->getElement("password")->isRequired();
    }
    
    /**
     * zvaliduje hesla
     * 
     * @return bool
     */
    public function validatePasswords() {
        $psw = $this->getElement("password");
        $confirm = $this->getElement("password_confirm");
        
        return $psw->isValid($psw->getValue()) && $confirm->isValid($confirm->getValue());
    }
    
    /**
     * nastavi, zda jsou hesla pozadovana nebo ne
     * 
     * @param bool $required nova hodnota pozadavku na hesla
     * @return Application_Form_User_My
     */
    public function setPasswordRequireStatus($required) {
        $this->getElement("password")->setRequired($required);
        $this->getElement("password_confirm")->setRequired($required);
        
        return $this;
    }
}