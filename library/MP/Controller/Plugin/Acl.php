<?php
class MP_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {
	
	/**
	 * vychozi role
	 * @var string
	 */
	const ROLE_DEFAULT = MP_Role::ROLE_GUEST;
	
	/**
	 * ACL
	 * 
	 * @var Zend_Acl
	 */
	private $_acl;
	
	/**
	 * vychozo role, pokud uzivatel neni prihlasen
	 * 
	 * @var Zend_Acl_Role
	 */
	private $_defaultRole = self::ROLE_DEFAULT;
	
	/**
	 * vytvori instanci ACL tridy a vytvori role
	 */
	public function __construct() {
		// vytvoreni ACL
		$this->_acl = new Zend_Acl();
		
		// zapis roli
		MP_Role::setRolesToAcl($this->_acl);
	}
	
	/**
	 * vraci instanci ACL
	 */
	public function getAcl() {
		return $this->_acl;
	}
	
	/**
	 * vraci vychozi roli
	 * 
	 * @return string
	 */
	public function getDefaultRole() {
		return $this->_defaultRole;
	}
	
	/**
	 * provede kontrolu pristupu k akci
	 * @throws Zend_Acl_Exception
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		// vyhodnoceni pristpuku k akci
		$user = Zend_Auth::getInstance()->getIdentity();
		
		// vyhodnoceni role
		$role = $user ? $user : $this->_defaultRole;
		
		// vyhodnoceni zdroje a akce
		$resource = $request->getControllerName();
		$action = $request->getActionName();
		
		// kontrola jineho modulu nez defaultniho
		$module = $request->getModuleName();
		
		if ($module != Zend_Controller_Front::getInstance()->getDefaultModule()) {
			$resource = sprintf("%s:%s", $module, $resource);
		}
		
		// vyhodnoceni opravneni
		if (!$this->_acl->isAllowed($role, $resource, $action)) {
			throw new Zend_Acl_Exception(sprintf("This action is forbidden for role '%s'", $role));
		}
	}
	
	/**
	 * nastavi novou instanci ACL
	 * @param Zend_Acl $acl nove ACL
	 * @return MP_Controller_Plugin_Acl
	 */
	public function setAcl(Zend_Acl $acl) {
		$this->_acl = $acl;
		
		return $this;
	}
	
	/**
	 * nastavi novou vychozi roli
	 * 
	 * @param string $role nova vychozi role
	 * @return MP_Controller_Plugin_Acl
	 */
	public function setDefaultRole($role) {
		$this->_defaultRole = $role;
	}
}