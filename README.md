UrlFromObject
=============

Semplice classe per generare gli url a partire da un oggetto.


in view <?php echo $this->urlFromObject('nome-pagina', $object) ?>

in controller <?php $url = $this->urlFromObject('saluti', $this); ?>


Per configurare i generatori di url utilizzare la seguenti sintassi.

'url-from-object' => array(

	/* generator */
	'Application\Model\User' => array(
		'edit-page' => function($object){
			return array(
				'route' => 'application/default',
				'params' => array(
					'controller' => 'user',
					'action' => 'edit',
        		)
        	);
        },

		/*static*/
		'list-page' => array(
			'route' => 'application/default',
			'params' => array(
				'controller' => 'user',
			    'action' => 'index',
			)
        ),

 	 /* alias */
     'Application\Controller\IndexController' => 'Zend\View\Renderer\PhpRenderer',
),
