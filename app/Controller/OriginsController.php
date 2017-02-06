<?php

App::uses('AppController', 'Controller');

/**
 * Origins Controller
 *
 * @property Origin $Origin
 */
class OriginsController extends AppController
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
		$this->Origin->recursive = 0;
		$this->set('origins', $this->paginate());
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
		// Si el origen NO existe
			if ( !$this->Origin->exists($id) ) {
				throw new NotFoundException(__('Origen no encontrado.'));
			}

		// Consulta del origen actual
			$origin = $this->Origin->find('first', array(
				'conditions' => array(
					'Origin.' . $this->Origin->primaryKey => $id
				)
			));

		// Seteo el origen en la vista
			$this->set( compact('origin') );
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
				$this->Origin->create();

				// Si guarda el origen con éxito
				if ( $this->Origin->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('El origen fue guardado correctamente!'), 'flash/success');
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
		// Si el origen NO existe
			if ( !$this->Origin->exists($id) ) {
				throw new NotFoundException(__('Origen no encontrado.'));
			}

		// Si estoy haciendo una POST request o PUT request
			if ( $this->request->is('post') || $this->request->is('put') )
			{
				// Si guarda el origen con éxito
				if ( $this->Origin->save($this->request->data) )
				{
					// Success
					$this->Session->setFlash(__('El origen fue guardado correctamente!'), 'flash/success');
					$this->redirect( array('action' => 'index') );
				}
				else {
					// Error
					$this->Session->setFlash(__('Por favor, comprueba que los campos estén correctos.'), 'flash/error');
				}
			}
		
		// Consulta del origen actual
			$this->request->data = $this->Origin->find('first', array(
				'conditions' => array(
					'Origin.' . $this->Origin->primaryKey => $id
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
		// Si el origen NO existe
		if ( !$this->Origin->exists($id) ) {
			throw new NotFoundException(__('Origen no encontrado.'));
		}
		else {
			$this->Origin->id = $id;
		}

		// Si estoy haciendo una POST request o DELETE request
			if ( $this->request->is('post') || $this->request->is('delete') )
			{
				try {
					// Si borra el contenido con éxito
					$this->Origin->delete();

					// Success
					$this->Session->setFlash(__('El origen fue borrado con éxito!'), 'flash/success');
				}
				catch (Exception $e) {
					// Error
					$this->Session->setFlash(__('Ocurrió un problema al borrar el origen. Verificá que no esté siendo utilizado por un contenido ingresando en el detalle del origen!'), 'flash/error');
				}
				
				// Redirecciono al index del controlador
				$this->redirect( array('action' => 'index') );
			}
	}

}
