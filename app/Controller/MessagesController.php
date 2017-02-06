<?php

App::uses('AppController', 'Controller');

/**
 * Messages Controller
 *
 * @property Message $Message
 */
class MessagesController extends AppController
{

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->Message->recursive = 0;
		$this->set('messages', $this->paginate());
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
		// Si el mensaje NO existe
			if ( !$this->Message->exists($id) ) {
				throw new NotFoundException(__('Mensaje no encontrado.'));
			}

		// Consulta del mensaje actual
			$message = $this->Message->find('first', array(
				'conditions' => array(
					'Message.' . $this->Message->primaryKey => $id
				)
			));

		// Seteo el mensaje en la vista
			$this->set( compact('message') );
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
				$this->Message->create();

				// Si guarda el mensaje con éxito
				if ( $this->Message->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('El mensaje fue guardado correctamente!'), 'flash/success');
					$this->redirect( array('action' => 'index') );
				}
				else {
					// Error
					$this->Session->setFlash(__('Por favor, comprueba que los campos estén correctos.'), 'flash/error');
				}
			}
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
		// Si el mensaje NO existe
			if ( !$this->Message->exists($id) ) {
				throw new NotFoundException(__('Mensaje no encontrado.'));
			}

		// Si estoy haciendo una POST request o PUT request
			if ( $this->request->is('post') || $this->request->is('put') )
			{
				// Si guarda el mensaje con éxito
				if ( $this->Message->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('El mensaje fue guardado correctamente!'), 'flash/success');
					$this->redirect( array('action' => 'index') );
				}
				else {
					// Error
					$this->Session->setFlash(__('Por favor, comprueba que los campos estén correctos.'), 'flash/error');
				}
			}
		
		// Consulta del mensaje actual
			$this->request->data = $this->Message->find('first', array(
				'conditions' => array(
					'Message.' . $this->Message->primaryKey => $id
				)
			));
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
		// Si el mensaje NO existe
			if ( !$this->Message->exists($id) ) {
				throw new NotFoundException(__('Mensaje no encontrado.'));
			}
			else {
				$this->Message->id = $id;
			}

		// Si estoy haciendo una POST request o DELETE request
			if ( $this->request->is('post') || $this->request->is('delete') )
			{
				// Si borra el mensaje con éxito
				if ( $this->Message->delete() ) {
					// Success
					$this->Session->setFlash(__('El mensaje fue borrado con éxito!'), 'flash/success');
				}
				else {
					// Error
					$this->Session->setFlash(__('Ocurrió un problema al borrar el mensaje, intente nuevamente.'), 'flash/error');
				}

				// Redirecciono al index del controlador
				$this->redirect( array('action' => 'index') );
			}
	}

}
