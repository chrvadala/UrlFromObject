<?php
/**
 * UrlFromObject (http://www.workoutweb.it/)
 *
 */

namespace UrlFromObject;

class Module
{
    public function getConfig()
    {
        return include_once __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ ,
                ),
            ),
        );
    }

}
