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

    protected $loadedGenerators = array();

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
    public function getConfig()
    {
        return $this->config;
    }

    /**
     *
     * @param string $classname
     * @param string $page
     * @throws Exception\NotFoundException
     * @throws Exception\MalformedGeneratorException
     * @return array('class'=> '...', 'method'=> '...')
     */
    public function getGeneratorConfig($classname, $page)
    {
        if(! isset($this->config[$classname])){
        	throw new Exception\NotFoundException(sprintf(
    			'La classe %s non è stata configurata',
    			$classname
        	));
        }

        //supporto agli alias dell'intera classe
        if(is_string($this->config[$classname])){
        	return $this->getGeneratorConfig($this->config[$classname], $page);
        }

        if(! isset($this->config[$classname][$page])){
        	throw new Exception\NotFoundException(sprintf(
    			'La pagina %s della classe %s non è stata configurata',
    			$page,
    			$classname
        	));
        }

        if(     !isset($this->config[$classname][$page]['class'])
            ||  !isset($this->config[$classname][$page]['method'])){
        	throw new Exception\MalformedGeneratorException(sprintf(
        			'La configurazione della pagina %s della classe %s non contiene le chiavi class e method.',
        			$page,
        			$classname
        	));
        }

        return $this->config[$classname][$page];
    }

    public function getGenerator($generatorClassname)
    {
        if(!isset($this->loadedGenerators[$generatorClassname])){
        	$this->loadedGenerators[$generatorClassname] = new $generatorClassname();
        }

        return $this->loadedGenerators[$generatorClassname];
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

        $generatorConfig = $this->getGeneratorConfig($classname, $page);
        $generator = $this->getGenerator($generatorConfig['class']);

        if(! method_exists($generator, $generatorConfig['method'])){
            throw new Exception\MalformedGeneratorException(sprintf(
            		'All\'interno della classe %s non esiste il metodo %s.',
            		$classname,
                    $generatorConfig['method']
            ));
        }

        $urlConfig = $generator->{$generatorConfig['method']}($object, $options);

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

