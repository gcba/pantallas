<?php

App::uses('AppController', 'Controller');

/**
 * Contents Controller
 *
 * @property Content $Content
 */
class ContentsController extends AppController
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
		$this->Content->recursive = 0;
		$this->set('contents', $this->paginate());
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
		// Si el contenido NO existe
			if ( !$this->Content->exists($id) ) {
				throw new NotFoundException(__('Contenido no encontrado.'));
			}
		
		// Seteo el recursive en 1 porque necesito saber las pantallas y origenes relacionados
			$this->Content->recursive = 1;

		// Consulta del contenido actual
			$content = $this->Content->find('first', array(
				'conditions' => array(
					'Content.' . $this->Content->primaryKey => $id
				)
			));

		// Seteo el contenido para usarlo en la vista
			$this->set( compact('content') );
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
				$this->Content->create();

				// Si guarda el contenido con éxito
				if ( $this->Content->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('El contenido fue guardado correctamente!'), 'flash/success');
					$this->redirect( array('action' => 'index') );
				}
				else {
					// Error
					$this->Session->setFlash(__('Por favor, comprueba que los campos estén correctos.'), 'flash/error');
				}
			}

		// Listo los nombres de los orígenes y sus configuraciones correspondientes
			$origins = $this->Content->Origin->find('list', array(
				'fields' => array(
					'Origin.origen_id',
					'Origin.nombre'
				),
				'order' => array(
					'Origin.nombre ASC'
				)
			));
			$originSettings = $this->Content->Origin->find('list', array(
				'fields' => array(
					'Origin.origen_id', 
					'Origin.settings'
				),
				'order' => array(
					'Origin.nombre ASC'
				)
			));

		// Seteo las variables en la vista
			$this->set( compact('origins', 'originSettings') );
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
		// Si el contenido NO existe
			if ( !$this->Content->exists($id) ) {
				throw new NotFoundException(__('Contenido no encontrado.'));
			}

		// Si estoy haciendo una POST request o PUT request
			if ( $this->request->is('post') || $this->request->is('put') )
			{
				// Si guarda el contenido con éxito
				if ( $this->Content->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('El contenido fue guardado correctamente!'), 'flash/success');
					$this->redirect( array('action' => 'index') );
				}
				else {
					// Error
					$this->Session->setFlash(__('Por favor, comprueba que los campos estén correctos.'), 'flash/error');
				}
			}
		
		// Seteo el recursive en 0 porque no necesito nada mas que el contenido y el origen
			$this->Content->recursive = 0;

		// Consulta del contenido actual
			$this->request->data = $this->Content->find('first', array(
				'conditions' => array(
					'Content.' . $this->Content->primaryKey => $id
				)
			));

		// Listo los nombres de los orígenes y sus configuraciones correspondientes
			$origins = $this->Content->Origin->find('list', array(
				'fields' => array(
					'Origin.origen_id',
					'Origin.nombre'
				),
				'order' => array(
					'Origin.nombre ASC'
				)
			));
			$originSettings = $this->Content->Origin->find('list', array(
				'fields' => array(
					'Origin.origen_id', 
					'Origin.settings'
				),
				'order' => array(
					'Origin.nombre ASC'
				)
			));

		// Seteo las variables en la vista
			$this->set( compact('origins', 'originSettings') );
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
		// Si el contenido NO existe
			if ( !$this->Content->exists($id) ) {
				throw new NotFoundException(__('Contenido no encontrado.'));
			}
		// O sino seteo el ID del contenido
			else {
				$this->Content->id = $id;
			}

		// Si estoy haciendo una POST request o DELETE request
			if ( $this->request->is('post') || $this->request->is('delete') )
			{
				// Si borra el contenido con éxito
				if ( $this->Content->delete() ) {
					// Success
					$this->Session->setFlash(__('El contenido fue borrado con éxito!'), 'flash/success');
				}
				else {
					// Error
					$this->Session->setFlash(__('Ocurrió un problema al borrar el contenido, intente nuevamente.'), 'flash/error');
				}

				// Redirecciono al index del controlador
				$this->redirect( array('action' => 'index') );
			}
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
		// Si el contenido NO existe
			if ( !$this->Content->exists($id) ) {
				throw new NotFoundException(__('Contenido no encontrado.'));
			}


		// Consulta del contenido actual
			$this->Content->recursive = 1;

			$content = $this->Content->find('first', array(
				'conditions' => array(
					'Content.' . $this->Content->primaryKey => $id
				)
			));


		// Variables auxiliares
			$modules  			= array();
			$includes 			= array();
			$origin 			= $content['Origin'];
			$content 			= $content['Content'];
			$content['Origin'] 	= $origin;


		// Parseo el contenido
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


		// Seteo las variables en la vista
			$this->set( compact('modules', 'includes', 'content') );


		// Seteo el layout
			$this->layout = 'play';
	}


	/**
	 * json method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function json( $id = null )
	{
		// Si el contenido NO existe
			if ( !$this->Content->exists($id) ) {
				throw new NotFoundException(__('Contenido no encontrado.'));
			}
		
		// Seteo el recursive en 0, no necesito nada más que el contenido	
			$this->Content->recursive = -1;
		
		// Consulta del contenido actual
			$content = $this->Content->find('first', array(
				'fields' 	 => array('local_data'),
				'conditions' => array('Content.' . $this->Content->primaryKey => $id),
			));
		
		// Seteo la data del contenido para usarla en la vista
			$this->set('data', ($content['Content']['local_data'] != '') ? $content['Content']['local_data'] : '{}' );

		// Seteo el layout
			$this->layout = 'ajax';
	}

}
