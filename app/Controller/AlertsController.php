<?php

App::uses('AppController', 'Controller');

/**
 * Alerts Controller
 *
 * @property Alert $Alert
 */
class AlertsController extends AppController
{

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->Alert->recursive = 0;
		$this->set('alerts', $this->paginate());
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
		// Si la alerta NO existe
			if ( !$this->Alert->exists($id) ) {
				throw new NotFoundException(__('Alerta no encontrada.'));
			}

		// Consulta de la alerta actual
			$alert = $this->Alert->find('first', array(
				'conditions' => array(
					'Alert.' . $this->Alert->primaryKey => $id
				)
			));

		// Seteo la alerta en la vista
			$this->set( compact('alert') );
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
				$this->Alert->create();

				// Si guarda la alerta con éxito
				if ( $this->Alert->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('La alerta fue guardada correctamente!'), 'flash/success');
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
		// Si la alerta NO existe
			if ( !$this->Alert->exists($id) ) {
				throw new NotFoundException(__('Alerta no encontrada.'));
			}

		// Si estoy haciendo una POST request o PUT request
			if ( $this->request->is('post') || $this->request->is('put') )
			{
				// Si guarda la alerta con éxito
				if ( $this->Alert->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('La alerta fue guardada correctamente!'), 'flash/success');
					$this->redirect( array('action' => 'index') );
				}
				else
				{
					// Error
					$this->Session->setFlash(__('Por favor, comprueba que los campos estén correctos.'), 'flash/error');
				}
			}
		
		// Consulta de la alerta actual
			$this->request->data = $this->Alert->find('first', array(
				'conditions' => array(
					'Alert.' . $this->Alert->primaryKey => $id
				)
			));
	}


	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @throws MethodNotAllowedException
	 * @param string $id
	 * @return void
	 */
	public function delete( $id = null )
	{
		// Si la alerta NO existe
			if ( !$this->Alert->exists($id) ) {
				throw new NotFoundException(__('Alerta no encontrada.'));
			}
			else {
				$this->Alert->id = $id;
			}

		// Si estoy haciendo una POST request o DELETE request
			if ( $this->request->is('post') || $this->request->is('delete') )
			{
				// Si borra la alerta con éxito
				if ( $this->Alert->delete() ){
					// Success
					$this->Session->setFlash(__('La alerta fue borrada con éxito!'), 'flash/success');
				}
				else {
					// Error
					$this->Session->setFlash(__('Ocurrió un problema al borrar la alerta, intente nuevamente.'), 'flash/error');
				}

				// Redirecciono al index del controlador
				$this->redirect( array('action' => 'index') );
			}
	}

}
