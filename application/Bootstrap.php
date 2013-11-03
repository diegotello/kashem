<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initRouting() {
        $config = new Zend_Config_Ini(
                APPLICATION_PATH . "/configs/routes.ini", APPLICATION_ENV
        );
        $router = new Zend_Controller_Router_Rewrite();
        $router->addConfig($config, "routes");
        Zend_Controller_Front::getInstance()->setRouter($router);
    }

    protected function _initLoadAclConfig() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/acl.ini', APPLICATION_ENV);
        Zend_Registry::set('acl', $config);
    }

    protected function _initAclControllerPlugin() {
        $this->bootstrap('frontcontroller');
        $this->bootstrap('loadAclConfig');

        $front = Zend_Controller_Front::getInstance();
        $acl = new Kashem_Acl();
        $aclPlugin = new Kashem_AuthPlugin($acl);
        $front->registerPlugin($aclPlugin);
    }

}

