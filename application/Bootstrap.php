<?php
require_once APPLICATION_PATH . '/controllers/MetaController.php';

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initIncludes() {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace("MP_");

        Zend_Controller_Front::getInstance()->registerPlugin(new MP_Controller_Plugin_Acl());
    }

    protected function _initRoutes() {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        $router->addRoute(
                "my-account", new Zend_Controller_Router_Route("/my-account", array(
            "module" => "default",
            "controller" => "user",
            "action" => "index"
                ))
        );

        $router->addRoute(
                "edit-profile", new Zend_Controller_Router_Route("/edit-profile", array(
            "module" => "default",
            "controller" => "user",
            "action" => "put"
                ))
        );

        $router->addRoute(
                "experiments", new Zend_Controller_Router_Route("/experiments", array(
            "module" => "default",
            "controller" => "experiment",
            "action" => "index"
                ))
        );

        $router->addRoute(
                "logout", new Zend_Controller_Router_Route("/logout", array(
            "module" => "default",
            "controller" => "user",
            "action" => "logout"
                ))
        );

        $router->addRoute(
                "login", new Zend_Controller_Router_Route("/login", array(
            "module" => "default",
            "controller" => "user",
            "action" => "login"
                ))
        );

        $router->addRoute(
                "microscopes", new Zend_Controller_Router_Route("/microscopes", array(
            "module" => "default",
            "controller" => "microscope",
            "action" => "index"
                ))
        );
        
        $router->addRoute(
                "create-microscope", new Zend_Controller_Router_Route("/create-microscope", array(
            "module" => "default",
            "controller" => "microscope",
            "action" => "post"
                ))
        );
        
        $router->addRoute(
                "microscope-get", new Zend_Controller_Router_Route("/microscope/:tag", array(
                    "module" => "default",
                    "controller" => "microscope",
                    "action" => "get"
                ))
                );
        
        $router->addRoute(
                "microscope-put", new Zend_Controller_Router_Route("/microscope/:tag/edit", array(
                    "module" => "default",
                    "controller" => "microscope",
                    "action" => "put"
                ))
                );
        
        $router->addRoute(
                "meta-post", new Zend_Controller_Router_Route(sprintf("/meta/:%s/parent/:%s/post", MetaController::REQUEST_PARAM_NAME, MetaController::REQUEST_PARAM_PARENT_ID), array(
                    "module" => "default",
                    "controller" => "meta",
                    "action" => "post"))
                );
        
        $router->addRoute(
                "meta-put-microscope", new Zend_Controller_Router_Route(sprintf("/microscope/:%s/meta/:metaId/put", MetaController::REQUEST_PARAM_PARENT_ID), array(
                    "module" => "default",
                    "controller" => "meta",
                    "action" => "put",
                    MetaController::REQUEST_PARAM_NAME => MetaController::TYPE_MICROSCOPE
                ))
                );
        
        $router->addRoute(
                "create-experiment", new Zend_Controller_Router_Route("/new-experiment", array(
                    "module" => "default",
                    "controller" => "experiment",
                    "action" => "post"
                ))
                );
        
        $router->addRoute(
                "edit-experiment", new Zend_Controller_Router_Route("/experiment/:id/edit", array(
                    "module" => "default",
                    "controller" => "experiment",
                    "action" => "put"
                ))
                );
        
        $router->addRoute(
                "get-experiment", new Zend_Controller_Router_Route("/experiment/:id/overview", array(
                    "module" => "default",
                    "controller" => "experiment",
                    "action" => "get"
                ))
                );
        
        $router->addRoute(
                "post-collection", new Zend_Controller_Router_Route("/experiment/:experimentId/new-collection", array(
                    "module" => "default",
                    "controller" => "collection",
                    "action" => "post"
                ))
                );
        
        $router->addRoute(
                "put-collection", new Zend_Controller_Router_Route("/experiment/:experimentId/collection/:id/edit", array(
                    "module" => "default",
                    "controller" => "collection",
                    "action" => "put"
                ))
                );
    }

    protected function _initAcl() {
        /* @var $acl Zend_Acl */
        $acl = Zend_Controller_Front::getInstance()->getPlugin("MP_Controller_Plugin_Acl")->getAcl();

        // registrace zdroju
        $acl->addResource(new Zend_Acl_Resource("index"));
        $acl->addResource(new Zend_Acl_Resource("error"));
        $acl->addResource(new Zend_Acl_Resource("user"));
        $acl->addResource(new Zend_Acl_Resource("experiment"));
        $acl->addResource(new Zend_Acl_Resource("microscope"));
        $acl->addResource(new Zend_Acl_Resource("meta"));
        $acl->addResource(new Zend_Acl_Resource("collection"));

        // povoleni akci hostovi
        $acl->allow(MP_Role::ROLE_GUEST, "index");
        $acl->allow(MP_Role::ROLE_GUEST, "error");
        $acl->allow(MP_Role::ROLE_GUEST, "user", "login");

        // povoleni akci uzivateli
        $acl->deny(MP_Role::ROLE_USER, "user", "login");
        $acl->allow(MP_Role::ROLE_USER, "user", array("index", "logout"));
        $acl->allow(MP_Role::ROLE_USER, "experiment", array("index", "get"));

        // povoleni akci operatorovi
        $acl->allow(MP_Role::ROLE_OPERATOR, "experiment", array("post"));
        $acl->allow(MP_Role::ROLE_OPERATOR, "experiment", array("put", "get"), new MP_Acl_Assert_Experiment());
        
        // povoleni akci adminovi
        $acl->allow(MP_Role::ROLE_ADMIN);
    }

    protected function _initViews() {
        // inicializace pohledu
        $this->bootstrap("view");
        $view = $this->getResource("view");

        // nacteni ACL
        $acl = Zend_Controller_Front::getInstance()->getPlugin("MP_Controller_Plugin_Acl")->getAcl();

        // nacteni konfigurace navigace
        $config = new Zend_Config_Xml(sprintf("%s/resources/navigation.xml", APPLICATION_PATH), "nav");
        $navigation = new Zend_Navigation($config);

        // nacteni a nastaveni helperu
        $helper = $view->navigation();
        $helper->setAcl($acl);

        $user = Zend_Auth::getInstance()->getIdentity();
        $helper->setRole($user ? $user : MP_Controller_Plugin_Acl::ROLE_DEFAULT);

        $helper->setContainer($navigation);
    }

    protected function _initTranslations() {
        
    }

    protected function _initHead() {
        $title = new Zend_View_Helper_HeadTitle();
        $title->setSeparator(" - ");
        $title->headTitle("MicroPic");

        $styles = new Zend_View_Helper_HeadLink();
        $styles->appendStylesheet("/css/styles.css");
    }

}
