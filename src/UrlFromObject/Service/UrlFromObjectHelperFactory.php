<?php
namespace UrlFromObject\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use UrlFromObject\View\Helper\UrlFromObjectHelper;

class UrlFromObjectHelperFactory implements FactoryInterface{

	public function createService(ServiceLocatorInterface $serviceLocator) {

	    $urlProvider = $serviceLocator->getServiceLocator()->get('UrlFromObject\Service\UrlProvider');

	    $helper = new UrlFromObjectHelper();
	    $helper->setUrlProvider($urlProvider);
	    return $helper;
	}


}

?>