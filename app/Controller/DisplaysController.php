<?php

App::uses('AppController', 'Controller');
App::uses('Email', 'Email');

/**
 * Displays Controller
 *
 * @property Display $Display
 */
class DisplaysController extends AppController
{
	
	/**
	 * beforeFilter method
	 *
	 * @return void
	 */
	public function beforeFilter()
	{
		// Cargo el helper del Chosen
			$this->helpers[] = 'Chosen.Chosen';

		// Llamo a la función padre
			parent::beforeFilter();
	}


	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->Display->recursive = 1;
		$this->set('displays', $this->paginate());
	}


	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view( $id = null )
	{
		// Si la pantalla NO existe
			if ( !$this->Display->exists($id) ) {
				throw new NotFoundException(__('Pantalla no encontrada.'));
			}

		// Seteo el recursive en 2 para obtener hasta el Origen
			$this->Display->recursive = 2;
		
		// Consulta de la pantalla actual
			$display = $this->Display->find('first', array(
				'conditions' => array(
					'Display.' . $this->Display->primaryKey => $id
				)
			));
	
		// Seteo la pantalla para usarla en la vista
			$this->set( compact('display') );
	}


	/**
	 * add method
	 *
	 * @return void
	 */
	public function add()
	{
		// Si estoy haciendo una POST request
			if ( $this->request->is('post') )
			{
				$this->Display->create();

				// Si guarda la pantalla con éxito
				if ( $this->Display->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('La pantalla fue guardada correctamente!'), 'flash/success');
					$this->redirect( array('controller' => 'pantallas', 'action' => 'index') );
				}
				else {
					// Error
					$this->Session->setFlash(__('Por favor, comprueba que los campos estén correctos.'), 'flash/error');
				}
			}
		
		// Seteo el recursive en 1 porque no necesito nada mas que la pantalla, el contenido y los tags
			$this->Display->recursive = 1;

		// Listo los contenidos y los tags en la vista
			$content = $this->Display->Content->find('list', array(
				'order' => array(
					'Content.nombre ASC'
				)
			));
			$tags = $this->Display->Tag->find('list', array(
				'order' => array(
					'Tag.nombre ASC'
				)
			));

		// Seteo las variables en la vista
			$this->set( compact('content', 'tags') );
	}


	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit( $id = null )
	{
		// Si la pantalla NO existe
			if ( !$this->Display->exists($id) ) {
				throw new NotFoundException(__('Pantalla no encontrada.'));
			}

		// Si estoy haciendo una POST request o PUT request
			if ( $this->request->is('post') || $this->request->is('put') )
			{
				// Si guarda la pantalla con éxito
				if ( $this->Display->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('La pantalla fue guardada correctamente!'), 'flash/success');
					$this->redirect( array('action' => 'index') );
				}
				else {
					// Error
					$this->Session->setFlash(__('Por favor, comprueba que los campos estén correctos.'), 'flash/error');
				}
			}
		
		// Seteo el recursive en 1 porque no necesito nada mas que la pantalla, el contenido y los tags
			$this->Display->recursive = 1;

		// Consulta de la pantalla actual
			$this->request->data = $this->Display->find('first', array(
				'conditions' => array(
					'Display.' . $this->Display->primaryKey => $id
				)
			));

		// Listo los contenidos y los tags en la vista
			$content = $this->Display->Content->find('list', array(
				'order' => array(
					'Content.nombre ASC'
				)
			));
			$tags = $this->Display->Tag->find('list', array(
				'order' => array(
					'Tag.nombre ASC'
				)
			));

		// Seteo las variables en la vista
			$this->set( compact('content', 'tags') );
	}


	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete( $id = null )
	{
	
		// Si la pantalla NO existe
		if ( !$this->Display->exists($id) ) {
			throw new NotFoundException(__('Pantalla no encontrada.'));
		}
		else {
			$this->Display->id = $id;
		}

		// Si estoy haciendo una POST request o DELETE request
			if ( $this->request->is('post') || $this->request->is('delete') )
			{
				// Si borra la pantalla con éxito
				if ( $this->Display->delete() ) {
					// Success
					$this->Session->setFlash(__('La pantalla fue borrada con éxito!'), 'flash/success');
				}
				else {
					// Error
					$this->Session->setFlash(__('Ocurrió un problema al borrar la pantalla, intente nuevamente.'), 'flash/error');
				}

				// Redirecciono al index del controlador
				$this->redirect( array('action' => 'index') );
			}
	}


	/**
	 * mapa method
	 *
	 * @return void
	 */
	public function map()
	{
		$this->Display->recursive = 0;
		$this->set('display', $this->Display->getAvailableDisplays());
	}


	/**
	 * play method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function play( $id = null )
	{
		// Si la pantalla NO existe
			if ( !$this->Display->exists($id) ) {
				throw new NotFoundException(__('Pantalla no encontrada'));
			}


		// Consulta de la pantalla
			$this->Display->recursive = 2;

			// Consulta de la pantalla actual
				$display = $this->Display->find('first', array(
					'conditions' => array(
						'Display.' . $this->Display->primaryKey => $id
					)
				));


		// Variables auxiliares
			$modules  	= array();
			$includes 	= array();
			$contents 	= $display['Content'];
			$display 	= $display['Display'];

			// Defino la variable de mail
				$email = new Email();


		// Si NO estoy logeado
			if ( !AuthComponent::user('user_id') )
			{
				// Seteo la fecha de última consulta
					$display['fecha_ultima_consulta'] = date('Y-n-j H:i:s.u');

				// Le seteo la IP actual
					if ( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
						$display['ip_actual'] = "{$_SERVER['HTTP_X_FORWARDED_FOR']}";
					}
					else {
						$display['ip_actual'] = "{$_SERVER['REMOTE_ADDR']}";
					}

				// Si la pantalla DEBE enviar una alerta
					if ( $display['envio_alerta'] == 1 )
					{
						// Le remuevo el flag
						$display['envio_alerta'] = 0;
						
						// Envío un mail diciendo que la pantalla está operativa
						$email->sendDisplayBackOnlineReport($display);
					}

				// Actualizo la pantalla 
					$this->Display->save( $display );
			}


		// Parseo de módulos e includes

			// ALERTAS
				// // Le seteo la condición de que me devuelva sólo las alertas activas
				// 	$alerts = $this->Alert->find('all', array(
				// 		'conditions' => array(
				// 			'Alert.activo' => true
				// 		)
				// 	));

				// // Si hay al menos una alerta
				// 	if( count($alerts) > 0 )
				// 	{
				// 		foreach ($alerts as $alert)
				// 		{
				// 			$alert = $alert['Alert'];

				// 			$modules['alert-' . $alert['alerta_id']] = array(
				// 				'type' 		=> 'Alerta',
				// 				'metadata'	=> $alert,
				// 			);
				// 		}

				// 		// Cargo el include de alerta
				// 		$includes[] = 'Alerta';
				// 	}

			// MENSAJES
				// // Le seteo la condición de que me devuelva sólo los mensajes activos
				// 	$messages = $this->Message->find('all', array(
				// 		'conditions' => array(
				// 			'Message.activo'  => true
				// 		)
				// 	));

				// // Si hay al menos un mensaje
				// 	if( count($messages) > 0 )
				// 	{
				// 		foreach ($messages as $message)
				// 		{
				// 			$message = $message['Message'];

				// 			$modules['message-' . $message['mensaje_id']] = array(
				// 				'type' 		=> 'Mensaje',
				// 				'metadata'	=> $message,
				// 			);
				// 		}

				// 		// Cargo el include de mensaje
				// 		$includes[] = 'Mensaje';
				// 	}

			// CONTENIDOS

				// Si hay al menos un contenido
					if( count($contents) > 0 )
					{
						foreach ($contents as $content)
						{
							$modules[] = array(
								'contenido_id' 		=> $content['contenido_id'],
								'type' 				=> $content['Origin']['slug'],
								'name' 				=> $content['nombre'],
								'settings' 			=> $content['settings'],
								'origin' 			=> array(
									'settings' 	=> $content['Origin']['settings'],
									'usa_cron' 	=> $content['Origin']['usa_cron']
								)
							);

							$includes[] = $content['Origin']['slug'];
						}
					}
				// O sino
					else
					{
						// Puede pasar, aunque no debería, que no haya contenidos.
						// Esto significa de que tengo que avisar que se está reproduciendo una pantalla con sólo el Home y en el caso de haber Alertas y Mensajes, también.
						// Entonces envío un EMAIL con los datos de la pantalla para notificar.
							$email->sendDisplayWithoutContentReport($display);
					}

			// INCLUDES
				$includes = array_unique($includes);


		// Seteo las variables en la vista
			$this->set( compact('modules', 'includes', 'display') );


		// Seteo el layout
			$this->layout = 'play';
	}

}
