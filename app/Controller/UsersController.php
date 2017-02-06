<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController
{

	public $paginate = array(
		'User' => array(
			'limit' => 20/*,
			'order' => array('user_id' => 'asc'),*/
		)
	);
	

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

		// Lógica del primer ingreso
			if($this->action == 'login' && !$this->request->is('post'))
			{
				$users = $this->User->find('count');

				// Si no hay usuarios, lo mando al first
				if( $users == 0 ) {
					$this->Auth->allow('first');

					$this->redirect( array('action' => 'first') );
				}
			}

			if( $this->action == 'first')
			{
				$users = $this->User->find('count');
				
				// Si no hay usuarios, permito que acceda al first
				if( $users == 0 ) {
					$this->Auth->allow('first');
				}
			}
	}
	

	/**
	 * login method
	 *
	 * @return void
	 */
	public function login()
	{
		// Si estoy haciendo una POST request
		if ( $this->request->is('post') )
		{
			// Primero valido el captcha
				$post = array(
					'secret' 	=> '6LcnoQgUAAAAAAurZFEG3J1d-C2nI13THjM9aQ0m',
					'response' 	=> $this->request->data('g-recaptcha-response')
				);

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				curl_setopt($ch, CURLOPT_USERAGENT, "{$_SERVER['SERVER_NAME']}");
				curl_setopt($ch, CURLOPT_HEADER, false); // Don’t return the header, just the html
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response 		= curl_exec($ch);
				curl_close($ch);

			// Parseo el JSON
				$responseParsed = json_decode($response, true);
				
			// Si es válido
				if($responseParsed['success'])
				{
					// Si puede logear
					if ( $this->Auth->login() )
					{
						$user 				= $this->Auth->user();
						$user['last_login'] = date(DATE_ATOM);

						$this->User->save($user);
						$this->redirect( $this->Auth->redirect() ); // Redirecciono al lugar por default
					}
					// Sino le muestro un error
					else {
						$this->Session->setFlash(__('El usuario y/o contraseña ingresados son incorrectos.'), 'flash/error');
					}
				}
				// Sino le muestro un error
				else {
					$this->Session->setFlash(__('El captcha es inválido.'), 'flash/error');
				}
		}
		else
		{
			// Si el usuario está logeado
			if ( $this->Auth->User('user') ) {
				$this->redirect( $this->Auth->redirect() ); // Redirecciono al lugar por default
			}
		}
	}


	/**
	 * logout method
	 *
	 * @return void
	 */
	public function logout()
	{
		// Deslogea y redirige nuevamente al /login
			$this->redirect( $this->Auth->logout() );
	}


	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->User->recursive = 1;
		$this->set('users', $this->paginate());
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
		// Si el usuario NO existe
			if ( !$this->User->exists($id) ) {
				throw new NotFoundException(__('Usuario no encontrado.'));
			}

		// Consulta del usuario actual
			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.' . $this->User->primaryKey => $id
				)
			));
	
		// Seteo el usuario para usarlo en la vista
			$this->set( compact('user') );
	}


	/**
	 * first method
	 * se ejecuta con el primer login (no testeado)
	 *
	 * @return void
	 */
	public function first()
	{
		// Si estoy haciendo una POST request
			if ($this->request->is('post'))
			{
				$this->User->create();

				// Si guarda el usuario con éxito
				if ( $this->User->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('El usuario fue guardado correctamente!'), 'flash/success');
					$this->redirect( array('action' => 'login') );
				}
				else {
					// Error
					$this->Session->setFlash(__('El usuario no pudo ser guardado, intente nuevamente.'), 'flash/error');
				}
			}

		// Listo los tags en la vista
			$tags  = $this->User->Tag->find('list', array(
				'order' => array(
					'Tag.nombre ASC'
				)
			));
			$roles = User::getRoles();

		// Seteo las variables en la vista
			$this->set( compact('tags', 'roles') );

		// Renderiza la vista add
			$this->render('add');
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
				$this->User->create();

				// Si guarda el usuario con éxito
				if ( $this->User->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('El usuario fue guardado correctamente!'), 'flash/success');
					$this->redirect( array('action' => 'index') );
				}
				else {
					// Error
					$this->Session->setFlash(__('Por favor, comprueba que los campos estén correctos.'), 'flash/error');
				}
			}

		// Listo los tags en la vista
			$tags  = $this->User->Tag->find('list', array(
				'order' => array(
					'Tag.nombre ASC'
				)
			));
			$roles = User::getAvailableRoles( User::getRole(), null );

		// Seteo las variables en la vista
			$this->set( compact('tags', 'roles') );
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
		// Si el usuario NO existe
			if ( !$this->User->exists($id) ) {
				throw new NotFoundException(__('Usuario no encontrado.'));
			}

		// Si estoy haciendo una POST request o PUT request
			if ( $this->request->is('post') || $this->request->is('put') )
			{
				// Si guarda el usuario con éxito
				if ( $this->User->save($this->request->data) ) {
					// Success
					$this->Session->setFlash(__('El usuario fue guardado correctamente!'), 'flash/success');
					$this->redirect( array('action' => 'index') );
				}
				else {
					// Error
					$this->Session->setFlash(__('Por favor, comprueba que los campos estén correctos.'), 'flash/error');
				}
			}

		// Consulta del usuario actual
			$this->request->data = $this->User->find('first', array(
				'conditions' => array(
					'User.' . $this->User->primaryKey => $id
				)
			));

		// Listo los tags en la lista
			$tags  = $this->User->Tag->find('list', array(
				'order' => array(
					'Tag.nombre ASC'
				)
			));
			$roles = User::getAvailableRoles( User::getRole(), User::getRoleNormalized($this->request->data['User']['role']) );
		
		// Seteo las variables en la vista
			$this->set( compact('tags', 'roles') );
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
		// Si el usuario NO existe
			if ( !$this->User->exists($id) ) {
				throw new NotFoundException(__('Usuario no encontrado.'));
			}
			else {
				$this->User->id = $id;
			}

		// Si estoy haciendo una POST request o DELETE request
			if ( $this->request->is('post') || $this->request->is('delete') )
			{
				// Si borra el usuario con éxito
				if ( $this->User->delete() ) {
					// Success
					$this->Session->setFlash(__('El usuario fue borrado con éxito!'), 'flash/success');
				}
				else {
					// Error
					$this->Session->setFlash(__('Ocurrió un problema al borrar el usuario, intente nuevamente.'), 'flash/error');
				}

				// Redirecciono al index del controlador
				$this->redirect( array('action' => 'index') );
			}
	}
}