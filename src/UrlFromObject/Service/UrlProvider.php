<?php
namespace UrlFromObject\Service;

use UrlFromObject\Service\Exception;

class UrlProvider
{

    /**
     *
     * @var array
     */
    protected $config;

    /**
     *
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    /**
     *
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     *
     * @param string $classname
     */
    public function getConfig($classname = null)
    {
        if(is_null($classname)){
            return $this->config;
        }

        if(! isset($this->config[$classname])){
            throw new Exception\NotFoundException(sprintf(
                'La class %s non è stata configurata',
                $classname
            ));
        }

        return $this->config[$classname];
    }

    /**
     *
     * @param string $page
     * @param mixed $object
     * @param array $options
     * @return array
     */
    public function generateUrlConfig($page, $object, array $options = array())
    {

        $classname = get_class($object);

        $classConfig = $this->getConfig($classname);

        if(is_string($classConfig)){
            $classConfig = $this->getConfig($classConfig);
        }

        if(! isset($classConfig[$page])){
        	throw new Exception\NotFoundException(sprintf(
    			'La pagina %s della classe %s non è stata configurata',
    	        $page,
    			$classname
        	));
        }

        $generator = $classConfig[$page];

        if(is_callable($generator)) {
            $urlConfig = $generator($object, $options);
        }

        if(is_array($generator)){
            $urlConfig = $generator;
        }

        if(! is_array($urlConfig)){
        	throw new Exception\MalformedGeneratorException(sprintf(
        		'Il generatore di configurazione della pagina %s della classe %s ha restituito una configurazione errata.
                 Si sta ritornando un array?',
        			$page,
        			$classname
        	));
        }

        if(! isset($urlConfig['route'])){
            throw new Exception\MalformedGeneratorException(sprintf(
                'Il generatore di configurazione della pagina %s della classe %s ha restituito una configurazione errata.
                E\' presente la chiave route nell\'array di ritorno?',
                $page,
                $classname
            ));
        }

        if(! isset($urlConfig['params'])){
            $urlConfig['params'] = array();
        }

        if(! isset($urlConfig['options'])){
            $urlConfig['options'] = array();
        }

        return $urlConfig;
    }
}

