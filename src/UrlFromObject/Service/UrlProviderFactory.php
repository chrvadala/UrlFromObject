<?php
namespace UrlFromObject\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class UrlProviderFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator) {
	    $config = $serviceLocator->get('Config');
	    $urlProvider = new UrlProvider($config['work-out-web']['url-from-object']);
	    return $urlProvider;
	}



}

?>