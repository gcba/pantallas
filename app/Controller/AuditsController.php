<?php

App::uses('AppController', 'Controller');

/**
 * Audits Controller
 *
 * @property Audit $Audit
 */
class AuditsController extends AppController
{

	public $components = array(
		'Paginator' => array(
			'Audit' => array(
				'limit' => 20,
				'order' => array('created' => 'desc'),
			)
		)
	);

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->Audit->recursive = 0;
		$this->set('audits', $this->paginate());
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
		// Si el log NO existe
			if ( !$this->Audit->exists($id) ) {
				throw new NotFoundException(__('Log no encontrado.'));
			}

		// Consulta del log actual
			$audit = $this->Audit->find('first', array(
				'conditions' => array(
					'Audit.' . $this->Audit->primaryKey => $id
				)
			));

		// Seteo el log para usarlo en la vista
			$this->set('audit', $audit);
	}

}
