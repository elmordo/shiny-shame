<?php
class MP_Role {
	
	/**
	 * definice roli
	 */
	const ROLE_GUEST = "guest";
	const ROLE_USER = "user";
	const ROLE_OPERATOR = "operator";
	const ROLE_ADMIN = "admin";
	
	/**
	 * vraco asociativni pole obsahujici role
	 */
	public static function getRoles() {
		return array(
				self::ROLE_GUEST => "Host",
				self::ROLE_USER => "Uživatel",
				self::ROLE_OPERATOR => "Operátor",
				self::ROLE_ADMIN => "Administrátor"
				);
	}
	
	/**
	 * nastavi role do instance ACL
	 * 
	 * @param Zend_Acl $acl cilove acl
	 */
	public static function setRolesToAcl(Zend_Acl $acl) {
		$guest = new Zend_Acl_Role(self::ROLE_GUEST);
		$user = new Zend_Acl_Role(self::ROLE_USER);
		$operator = new Zend_Acl_Role(self::ROLE_OPERATOR);
		$admin = new Zend_Acl_Role(self::ROLE_ADMIN);
		
		$acl->addRole($guest);
		$acl->addRole($user, $guest);
		$acl->addRole($operator, $user);
		$acl->addRole($admin, $operator);
	}
}