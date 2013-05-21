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
        return array(
            'url-from-object' => array()
        );
    }

    public function getServiceConfig()
    {
    	return array(
    		'factories' => array(
    			'UrlFromObject\Service\UrlProvider' => function($sm) {
    			    $config = $sm->get('Config');
    			    $urlProvider = new \UrlFromObject\Service\UrlProvider($config['url-from-object']);
    			    return $urlProvider;
    			}
    		)
    	);
    }

    public function getViewHelperConfig()
    {
    	return array(
    		'factories' => array(
                'urlFromObject' => function($sm) {
                    $locator = $sm->getServiceLocator();
                    $urlProvider = $locator->get('UrlFromObject\Service\UrlProvider');

                    $helper = new \UrlFromObject\View\Helper\UrlFromObjectHelper();
                    $helper->setUrlProvider($urlProvider);
                    return $helper;
    	        },
    	    ),
    	);
    }

    public function getControllerPluginConfig()
    {
    	return array(
    		'factories' => array(
    			'urlFromObject' => function($sm) {
    			    $locator = $sm->getServiceLocator();
    				$urlProvider = $locator->get('UrlFromObject\Service\UrlProvider');

    				$helper = new \UrlFromObject\Controller\Plugin\UrlFromObject();
    				$helper->setUrlProvider($urlProvider);
    				return $helper;
    			},
    		),
    	);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

}
