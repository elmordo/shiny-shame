<?php
class MP_PyServer_Request {

	/**
	 * jmeno volane metody
	 * @var string
	 */
	protected $_method;

	/**
	 * seznam parametru
	 * @var array
	 */
	protected $_params = array();

	/**
	 * vytvori instanci a nastavi hodnoty
	 * @param string $method jmeno volane methody
	 * @param array $params dodatecne parametry
	 */
	public function __construct($method, array $params=array()) {
		$this->_method = $method;
		$this->_params = $params;
	}

	/**
	 * zresetuje nastaveni parametru
	 */
	public function clearParams() {
		$this->_params = array();
	}

	/**
	 * vraci jmeno metody
	 * @return string
	 */
	public function getMethod() {
		return $this->_method;
	}

	/**
	 * vraci nastavene parametry
	 * @return array
	 */
	public function getParams() {
		return $this->_params;
	}

	/**
	 * prevede pozadavek na zpravu pro server
	 * @return string
	 */
	public function serialize() {
		// priprava pole
		$chunks = array($this->_method);

		// zakodovani parametru
		foreach ($this->_params as $param) {
			$chunks[] = base64_encode($param);
		}

		// sestaveni retezce
		$strMessage = implode("\n", $chunks);

		// sestaveni headeru
		$msgLen = strlen($strMessage);
		$encLen = pack("V", $msgLen);

		// vraci sestavene zpravy
		return $encLen . $strMessage;
	}

	/**
	 * nastavi nove jmeno metody
	 * @param string $method nove jmeno
	 */
	public function setMethod($method) {
		$this->_method = $method;
	}

	/**
	 * nastavi novy seznam parametru
	 * @param array $params novy seznam parametru
	 */
	public function setParams(array $params) {
		$this->_params = $params;
	}
}