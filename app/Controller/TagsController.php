<?php

App::uses('AppController', 'Controller');

/**
 * Tags Controller
 *
 * @property Tag $Tag
 */
class TagsController extends AppController
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
		$this->Tag->recursive = 0;
		$this->set('tags', $this->paginate());
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
		// Si el tag NO existe
			if ( !$this->Tag->exists($id) ) {
				throw new NotFoundException(__('Tag no encontrado.'));
			}

		// Consulta del tag actual
			$tag = $this->Tag->find('first', array(
				'conditions' => array(
					'Tag.' . $this->Tag->primaryKey => $id
				)
			));
		
		// Seteo el tag en la vista
			$this->set('tag', $tag);
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
				$this->Tag->create();

				// Si guarda el tag con éxito
				if ( $this->Tag->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('El tag fue guardado correctamente!'), 'flash/success');
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
		// Si el tag NO existe
			if ( !$this->Tag->exists($id) ) {
				throw new NotFoundException(__('Tag no encontrado.'));
			}

		// Si estoy haciendo una POST request o PUT request
			if ( $this->request->is('post') || $this->request->is('put') )
			{
				// Si guarda el tag con éxito
				if ($this->Tag->save($this->request->data)) {
					// Success
					$this->Session->setFlash(__('El tag fue guardado correctamente!'), 'flash/success');
					$this->redirect(array('action' => 'index'));
				}
				else {
					// Error
					$this->Session->setFlash(__('Por favor, comprueba que los campos estén correctos.'), 'flash/error');
				}
			}
		
		// Consulta del tag actual
			$this->request->data = $this->Tag->find('first', array(
				'conditions' => array(
					'Tag.' . $this->Tag->primaryKey => $id
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
		// Si el tag NO existe
			if ( !$this->Tag->exists($id) ) {
				throw new NotFoundException(__('Tag no encontrado.'));
			}
			else {
				$this->Tag->id = $id;
			}

		// Si estoy haciendo una POST request o DELETE request
			if ( $this->request->is('post') || $this->request->is('delete') )
			{
				// Si borra el tag con éxito
				if ( $this->Tag->delete() ) {
					// Success
					$this->Session->setFlash(__('El tag fue borrado con éxito!'), 'flash/success');
				}
				else {
					// Error
					$this->Session->setFlash(__('Ocurrió un problema al borrar el tag, intente nuevamente.'), 'flash/error');
				}
			
				// Redirecciono al index del controlador
				$this->redirect( array('action' => 'index') );
			}
	}

}
