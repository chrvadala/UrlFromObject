<?php

return array(
	'url-from-object' => array(),

    'service_manager' => array(
        'factories' => array(
        	'UrlFromObject\Service\UrlProvider' => 'UrlFromObject\Service\UrlProviderFactory',
        ),
    ),

    'view_helpers' => array(
        'factories' => array(
        	'urlFromObject' => 'UrlFromObject\Service\UrlFromObjectHelperFactory',
        ),
    ),

    'controller_plugins' => array(
        'factories' => array(
        	'urlFromObject' => 'UrlFromObject\Service\UrlFromObjectPluginFactory',
        ),
    ),
);