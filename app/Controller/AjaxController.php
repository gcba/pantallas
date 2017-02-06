<?php

App::uses('AppController', 'Controller');

/**
 * Ajax Controller
 *
 * @property Ajax $Ajax
 */
class AjaxController extends AppController
{

	public function beforeFilter()
	{
		// Funciones habilitadas
			$this->Auth->allow(
				'refresh',
				'forceRefreshDetection',
				'estadoSubte',
				'noEncontrado',
				'RSS'
			);

		// Variables del controlador
			$this->queryParameters = $this->request->query;

		// Llamo al padre
			parent::beforeFilter();

		// Renderizo la vista
			$this->layout 	= 'ajax';
			$this->view 	= 'ajax_resp';
	}


	/**
	 * refresh method
	 *
	 * @return void
	 */
	public function refresh()
	{
		// Creo un array con la data
			$data = array(
				'requireRefresh' => true
			);

		// Seteo la data en la vista
			$this->set('data', $data);
	}


	/**
	 * forceRefreshDetection method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function forceRefreshDetection()
	{
		// Obtengo la URL envíada por parámetro
			$id 	= $this->queryParameters['id'];
			$type 	= $this->queryParameters['type'];

		// Creo un array con la data
			$lastModification = null;
			$data = array(
				'requireRefresh' => false
			);

		// Si el ID no es nulo
			if( $id != null )
			{
				// Según el tipo
					switch($type)
					{
						case 'display':
							// Obtengo la pantalla actual
								$this->Display->recursive = 0;

							// Si existe
								if ($this->Display->exists($id))
								{
									$display = $this->Display->find('first', array(
										'fields' => array(
											'fecha_ultima_modificacion'
										),
										'conditions' => array(
											'Display.' . $this->Display->primaryKey => $id
										)
									));

									$lastModification = new DateTime($display['Display']['fecha_ultima_modificacion']);
								}
						break;

						case 'content';
							// Obtengo el contenido actual
								$this->Content->recursive = 0;

							// Si existe
								if ($this->Content->exists($id))
								{
									$content = $this->Content->find('first', array(
										'fields' => array(
											'fecha_ultima_modificacion'
										),
										'conditions' => array(
											'Content.' . $this->Content->primaryKey => $id
										)
									));

									$lastModification = new DateTime($content['Content']['fecha_ultima_modificacion']);
								}
						break;
					}

				// Si hay una fecha de modificación
					if( $lastModification != null )
					{
						// Hago la diferencia entre la última modificación y el tiempo actual
							$now 	= new DateTime();
							$diff 	= $now->diff($lastModification);

							// Parseo los datos a segundos
								$years		= $diff->y;
								$months		= $diff->m;
								$days		= $diff->d;
								$hours 		= $diff->h;
								$minutes 	= $diff->i;
								$seconds 	= $diff->s;
								$totalSec 	= $seconds + ($minutes * 60) + ($hours * 3600) + ($days * 86400) + ($months * 2629743) + ($years * 31556926);
								$totalMin 	= $totalSec / 60;
								// $total = $seconds + ($minutes * 60) + ($hours * 60 * 60) + ($days * 24 * 60 * 60) + ($months * 30 * 24 * 60 * 60) + ($years * 365 * 30 * 24 * 60 * 60);

								// Y si la diferencia de tiempo es menor a 1 minuto, pido un refresh
								// Como chequea esta función cada 1 minuto, el totalMin tiene que ser menor a 1, sino refrescaría más de 1 vez.
									if( $totalMin <= 1 ) {
										$data['requireRefresh'] = true;
									}
					}
			}

		// Seteo la data en la vista
			$this->set('data', $data);
	}


	/**
	 * estadoSubte method
	 *
	 * @return void
	 */
	public function estadoSubte()
	{
		// Obtengo la URL envíada por parámetro
			$data 	= array();
			$url 	= $this->queryParameters['webservice'];

		// Si la URL no es nula
			if( $url )
			{
				// Obtengo la data
					$data = simplexml_load_file($url);
			}

		// Seteo la data en la vista
			$this->set('data', $data);
	}


	/**
	 * noEncontrado method
	 *
	 * @return void
	 */
	public function noEncontrado()
	{
		// Obtengo la URL envíada por parámetro
			$data 	= array();
			$url 	= $this->queryParameters['webservice'];

		// Si la URL no es nula
			if( $url )
			{
				// Obtengo la data y la mezclo
					$data = json_decode(file_get_contents($url), true);
					shuffle($data['data']);
			}

		// Seteo la data en la vista
			$this->set('data', $data);
	}



	/**
	 * RSS method
	 *
	 * @return void
	 */
	public function RSS()
	{
		// Obtengo la URL envíada por parámetro
			$data 	= array();
			$url 	= $this->queryParameters['url'];

		// Si la URL no es nula
			if( $url )
			{
				// Obtengo la data
					$data = simplexml_load_file($url);
			}

		// Seteo la data en la vista
			$this->set('data', $data);
	}

}
