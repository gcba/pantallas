<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public $theme = 'Cakestrap';

	public static $allow = array(
		'contents' 	=> array('play', 'json'),
		'displays' 	=> array('play'),
		'users' 	=> array('login', 'logout'),
	);

	public $permissions = array(
		'INSTALADOR' => array(
						// 'alerts' 		=> array('index', 'view'),
						'audits' 		=> array('index', 'view'),
						'displays' 		=> array('index', 'map', 'view'),
						'home'	 		=> array('index'),
						'users' 		=> array('index', 'view'),
					),
		'EDITOR' => array(
						// 'alerts' 		=> array('index', 'view'),
						'audits' 		=> array('index', 'view'),
						'contents' 		=> array('add', 'edit', 'index', 'view'),
						'displays' 		=> array('edit', 'index', 'map', 'view'),
						'home'	 		=> array('index'),
						// 'origins' 		=> array('add', 'edit', 'index', 'view'),
						'users' 		=> array('index', 'view'),
					),
		'ADMIN' => array(
						// 'alerts' 		=> array('add', 'edit', 'index', 'view'),
						'audits' 		=> array('index', 'view'),
						'contents' 		=> array('add', 'edit', /*'delete',*/ 'index', 'view'),
						'displays' 		=> array('add', 'edit', /*'delete',*/ 'index', 'map', 'view'),
						'home'	 		=> array('index'),
						// 'messages' 		=> array('add', 'edit', 'index', 'view'),
						'origins' 		=> array('add', 'edit', 'index', 'view'), // y delete??
						'tags' 			=> array('index', 'view'),
						'users' 		=> array('add', 'edit', 'index', 'view'), // Sólo puede hacer add de roles menores
					),
	);

	public $components = array(
		'RequestHandler',
		'Session',
		'Auth' => array(
			'loginRedirect' => array(
				'controller' => 'home',
				'action' 	 => 'index',
			),
			'logoutRedirect' => array(
				'controller' => 'users',
				'action' 	 => 'login',
			),
			'autoRedirect' => false,
			'authenticate' => array( 
				'Form' => array(
					'fields' => array(
						'username' => 'mail',
						'password' => 'password',
					),
				),
			),
			'authorize' => array('Controller'),
		),
	);

	public $uses 	= array('Alert', 'Content', 'Display', 'Message', 'User');
	public $helpers = array('Breadcrumb');
	// public $helpers = array('Auth');

	/*
	 * 
	 */
	function beforeFilter()
	{
		// Permito las acciones públicas de ese controlador
			$this->Auth->allow( AppController::getAllowList( $this->request->params['controller'] ) );


		// Mensajes
			// Pido que me devuelva todas los mensajes activos
			$activeMessages = $this->Message->find('all', array(
				'conditions' => array(
					'Message.activo' => true
				)
			));

			// Y las envio a la vista
			$this->set('activeMessages', $activeMessages);


		// Alertas
			// Pido que me devuelva todas las alertas activas
			$activeAlerts = $this->Alert->find('all', array(
				'conditions' => array(
					'Alert.activo' => true
				)
			));

			// Y las envio a la vista
			$this->set('activeAlerts', $activeAlerts);


		// Usuarios
			// Obtengo el usuario logeado
			$user = $this->Auth->user();

			// Si existe
			if($user)
			{
				// Obtengo la data
				$userData = $this->User->find('first', array(
					'conditions' => array(
						'User.'  . $this->User->primaryKey => $this->Auth->User('user_id')
					),
				));

				// Si existe en la base de datos
				if( count($userData) > 0 )
				{
					// Seteo los tags y permisos
					$user['Tag'] 		 = $userData['Tag'];
					$user['Permissions'] = (!User::isRoot() ? $this->permissions[$user['role']] : null);

					// Los guardo en la sesión
					$this->Session->write('Auth.User', $user);
				}
				// Sino lo deslogeo
				else
				{
					$this->redirect( $this->Auth->logout() );
				}

			}
	}

	/*
	 * 
	 */
	function beforeRender()
	{
		if($this->name == 'CakeError') {
			$this->layout = 'ajax';
		}
	}

	/*
	 * Función encargada de comprobar si el usuario está autorizado para realizar dichas acciones
	 */
	function isAuthorized($user)
	{
		// Si tiene permisos
		if( self::hasPermissions($user['Permissions'], $this->request->params['controller'], $this->request->params['action']) ) {
			return true;
		}

		// Por defecto no podes ingresar a ningun lado
		$this->Session->setFlash('Usted no tiene permisos para realizar esta acción.', 'flash/info', array(), 'permisos');
		$this->redirect(
			array(
				'controller' => 'home',
				'action' 	 => 'index',
			)
		);

		return false;
	}

	/*
	 * Función encargada de comprobar si el usuario tiene permisos para un determinado controlador y accion
	 */
	public static function hasPermissions( $permissions, $controller, $action )
	{
		// Si el controlador o la accion no estan definidos
		if( !isset($controller) || !isset($action) ) {
			return false;
		}

		// Si es root tiene ACCESO TOTAL
		if( User::isRoot() ) {
			return true;
		}

		// Si está permitido acceder a esa acción públicamente
		if( self::isAllow($controller, $action) ) {
			return true;
		}

		// Si los permisos existen y es un array
		if( isset($permissions) && is_array($permissions) )
		{

			// Si el usuario tiene acceso a ese controlador
			if( isset($permissions[$controller]) )
			{

				// Si la accion está en la lista de permisos de ese controlador
				if( in_array( $action, $permissions[$controller] ) )
				{
					// Si tiene permisos
					return true;
				}

			}

		}

		// Por defecto no tiene permisos
		return false;
	}

	/*
	 * Función encargada de comprobar si está permitida una determinada accion de un determinado controlador
	 */
	public static function isAllow( $controller, $action )
	{
		// Si el controler existe y es un string
		if( isset($controller) && is_string($controller) )
		{

			// Si el guest tiene acceso a ese controlador
			if( isset(self::$allow[$controller]) )
			{

				// Si la accion está en la lista de permisos de ese controlador
				if( in_array($action, self::$allow[$controller]) )
				{
					// Está permitido
					return true;
				}

			}

		}

		// Por defecto no está permitido
		return false;
	}

	/*
	 * Función encargada de comprobar si el usuario tiene permisos para un determinado controlador y accion
	 */
	public static function getAllowList( $controller )
	{
		$allow = array();

		// Si el controler existe y es un string
		if( isset($controller) && is_string($controller) )
		{

			// Si el guest tiene acceso a ese controlador
			if( isset(self::$allow[$controller]) )
			{

				// Seteo los permitidos de ese controlador
				$allow = self::$allow[$controller];

			}

		}

		// Por defecto devuelvo un array vacío
		return $allow;
	}

	public static function array_search_multiple( $array = array(), $searchKey = "" )
	{
		$index = 0;

		foreach($array as $key => $value)
		{
			if($searchKey == $key) {
				return $index;
			}

			$index++;
		}

		return -1;
	}
}
