<?php

App::uses('AppHelper', 'View/Helper');

class BreadcrumbHelper extends AppHelper
{
	public $helpers = array('Html');

	public function create( $controller, $action, $parameters )
	{
		$breadcrumb = '';

		// Home
			$breadcrumb .= $this->Html->link(
				'Inicio',
				array(
					'controller' => 'home',
					'action'     => 'index'
				),
				array(
					'class' => 'item'
				)
			);

		// Controller
			if( $controller != 'home' )
			{
				$breadcrumb .= ' > ' . $this->Html->link(
					ucfirst( Configure::read('Dictionary')[$controller]['plural'] ),
					array(
						'controller' => $controller,
						'action' 	 => 'index'
					),
					array(
						'class' => 'item'
					)
				);

				// Action
					if( $action != 'index' )
					{
						$id = '';

						if( count($parameters) > 0 ) {
							$id = $parameters[0];
						}

						$breadcrumb .= ' > ' . $this->Html->link(
							ucfirst( Configure::read('Dictionary')[$action]['singular'] ),
							array(
								'controller' 	=> $controller,
								'action' 		=> $action,
								$id
							),
							array(
								'class' => 'item'
							)
						);
					}
			}

		return $this->Html->div(
			'',
			$breadcrumb,
			array(
				'id' => 'breadcrumb'
			)
		);
	}

}