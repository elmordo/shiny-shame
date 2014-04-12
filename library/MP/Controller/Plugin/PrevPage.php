<?php

class MP_Controller_Plugin_PrevPage extends Zend_Controller_Plugin_Abstract {

    /**
     * vraci data predchozi stranky
     */
    public function getData() {
        $session = new Zend_Session_Namespace("MPSystem__");

        return $session->prevPage;
    }

    /**
     * provede zapis informaci o strance do session
     */
    public function postDispatch() {

        // otevreni systemove session
        $session = new Zend_Session_Namespace("MPSystem__");

        // nacteni prapuvodniho requestu
        $originalRequest = Zend_Controller_Front::getInstance()->getRequest();

        // nastaveni dat do session
        $pageData = array(
            "HTTP_REFERER" => isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "/",
            "URL" => $_SERVER["REQUEST_URI"],
            "REQUEST_PARAMS" => $originalRequest->getParams());

        $session->prevPage = $pageData;
    }
}