<?php
namespace UrlFromObject\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use UrlFromObject\Controller\Plugin\UrlFromObject;
class UrlFromObjectPluginFactory implements FactoryInterface{

	public function createService(ServiceLocatorInterface $serviceLocator) {


	    $urlProvider = $serviceLocator->getServiceLocator()->get('UrlFromObject\Service\UrlProvider');

		$plugin = new UrlFromObject();
		$plugin->setUrlProvider($urlProvider);
		return $plugin;

	}


}

?>