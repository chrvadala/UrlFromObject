<?php
namespace UrlFromObject\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use UrlFromObject\Service\UrlProvider;

class UrlFromObject extends AbstractPlugin
{

 /**
     *
     * @var UrlProvider
     */
    protected $urlProvider;

    /**
     *
     * @param string $page
     * @param unknown $object
     */
    public function __invoke($page, $object)
    {
        $config = $this->getUrlProvider()->generateUrlConfig($page, $object);
        return $this->getUrlHelper()->fromRoute(
            $config['route'],
            $config['params'],
            $config['options']
        );
    }

    /**
     * @return UrlProvider
     */
    public function getUrlProvider()
    {
        return $this->urlProvider;
    }

    /**
     *
     * @param UrlProvider $urlProvider
     */
    public function setUrlProvider(UrlProvider $urlProvider)
    {
        $this->urlProvider = $urlProvider;
    }

    /**
     * @return Url
     */
    public function getUrlHelper()
    {
        return $this->getController()->plugin('url');
    }

}
