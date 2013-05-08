<?php
namespace UrlFromObject\View\Helper;

use Zend\View\Helper\AbstractHelper;
use UrlFromObject\Service\UrlProvider;
use Zend\View\Helper\Url;

class UrlFromObjectHelper extends AbstractHelper
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
        return $this->getUrlHelper()->__invoke(
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
        return $this->getView()->plugin('url');
    }

}
