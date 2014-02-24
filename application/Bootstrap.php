<?php

require_once APPLICATION_PATH . '/controllers/MetaController.php';

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initIncludes() {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace("MP_");

        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new MP_Controller_Plugin_Acl());
        $front->registerPlugin(new MP_Controller_Plugin_Layout());
        
        
        define("TMP_PATH", APPLICATION_PATH . "/../tmp");
        define("IMAGE_PREVIEW_PUBLIC", "/previews");
        define("IMAGE_PREVIEW_PATH", APPLICATION_PATH . "/../public" . IMAGE_PREVIEW_PUBLIC);
    }

    protected function _initRoutes() {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        $router->addRoute(
                "my-account", new Zend_Controller_Router_Route("/my-account", array(
            "module" => "default",
            "controller" => "user",
            "action" => "get"
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
                "get-user", new Zend_Controller_Router_Route("/user/:login", array(
            "module" => "default",
            "controller" => "user",
            "action" => "getother"
                ))
        );
        
        $router->addRoute(
                "put-user", new Zend_Controller_Router_Route("/user/:login/edit", array(
            "module" => "default",
            "controller" => "user",
            "action" => "putother"
                ))
        );

        $router->addRoute(
                "users", new Zend_Controller_Router_Route("/users", array(
            "module" => "default",
            "controller" => "user",
            "action" => "index"
                ))
        );
        
        $router->addRoute(
                "post-user", new Zend_Controller_Router_Route("/new-user", array(
            "module" => "default",
            "controller" => "user",
            "action" => "post"
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
                "edit-experiment", new Zend_Controller_Router_Route("/experiment/:experiment_id/edit", array(
            "module" => "default",
            "controller" => "experiment",
            "action" => "put"
                ))
        );

        $router->addRoute(
                "get-experiment", new Zend_Controller_Router_Route("/experiment/:experiment_id/overview", array(
            "module" => "default",
            "controller" => "experiment",
            "action" => "get"
                ))
        );

        $router->addRoute(
                "post-collection", new Zend_Controller_Router_Route("/serie/:serie_id/new-collection", array(
            "module" => "default",
            "controller" => "collection",
            "action" => "post"
                ))
        );

        $router->addRoute(
                "put-collection", new MP_Controller_Router_Route("/serie/:serie_id/collection/:collection_id/edit", array(
            "module" => "default",
            "controller" => "collection",
            "action" => "put"
                ))
        );

        $router->addRoute(
                "get-collection", new Zend_Controller_Router_Route("/serie/:serie_id/collection/:collection_id", array(
            "module" => "default",
            "controller" => "collection",
            "action" => "get"
                ))
        );

        $router->addRoute(
                "groups", new Zend_Controller_Router_Route("/groups", array(
            "module" => "default",
            "controller" => "group",
            "action" => "index"
                ))
        );

        $router->addRoute(
                "group-put", new Zend_Controller_Router_Route("/group/:group_id/edit", array(
            "module" => "default",
            "controller" => "group",
            "action" => "put"
                ))
        );

        $router->addRoute(
                "group-get", new Zend_Controller_Router_Route("/group/:group_id", array(
            "module" => "default",
            "controller" => "group",
            "action" => "get"
                ))
        );
        
        $router->addRoute(
                "frame-download", new Zend_Controller_Router_Route("/experiment/:experiment_id/frame/:frame_id/download.tiff", array(
                    "module" => "default",
                    "controller" => "frame",
                    "action" => "download"
                ))
                );
        
        $router->addRoute(
                "frame-get", new Zend_Controller_Router_Route("/serie/:serie_id/frame/:frame_id/detail", array(
                    "module" => "default",
                    "controller" => "frame",
                    "action" => "get"
                ))
                );
        
        $router->addRoute(
                "frame-put", new Zend_Controller_Router_Route("/experiment/:experiment_id/frame/:frame_id/edit", array(
                    "module" => "default",
                    "controller" => "frame",
                    "action" => "put"
                ))
                );
        
        $router->addRoute(
                "sample-get", new Zend_Controller_Router_Route("/experiment/:experiment_id/sample/:sample_id/get", array(
                    "module" => "default",
                    "controller" => "sample",
                    "action" => "get"
                ))
                );
        
        $router->addRoute(
                "sample-put", new Zend_Controller_Router_Route("/experiment/:experiment_id/sample/:sample_id/edit", array(
                    "module" => "default",
                    "controller" => "sample",
                    "action" => "put"
                ))
                );
        
        $router->addRoute(
                "serie-get", new Zend_Controller_Router_Route("/experiment/:experiment_id/sample/:sample_id/serie/:serie_id/get", array(
                    "module" => "default",
                    "controller" => "serie",
                    "action" => "get"
                ))
                );
        
        $router->addRoute(
                "serie-put", new Zend_Controller_Router_Route("/experiment/:experiment_id/sample/:sample_id/serie/:serie_id/edit", array(
                    "module" => "default",
                    "controller" => "serie",
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
        $acl->addResource(new Zend_Acl_Resource("group"));
        $acl->addResource(new Zend_Acl_Resource("frame"));
        $acl->addResource(new Zend_Acl_Resource("sample"));
        $acl->addResource(new Zend_Acl_Resource("serie"));

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

        // pripojeni stylu
        $styles = new Zend_View_Helper_HeadLink();
        $styles->appendStylesheet("/css/styles.css");
        $styles->appendStylesheet("/css/start/jquery-ui-1.10.4.custom.min.css");
        
        // pripojeni javascriptu
        $scripts = new Zend_View_Helper_HeadScript();
        $scripts->appendFile("/js/third/jquery-2.1.0.min.js", "text/javascript");
        $scripts->appendFile("/js/third/jquery-ui-1.10.4.custom.min.js", "text/javascript");
        $scripts->appendFile("/js/extensions.js", "text/javascript");
        $scripts->appendFile("/js/application.js", "text/javascript");
    }

}
