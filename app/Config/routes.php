<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */

	// El '/' redirecciona al login
		Router::redirect ('/', '/login');

	// Home
		Router::connect('/inicio/*',  array('controller' => 'home', 'action' => 'index' ));
		Router::redirect('/home/:action/*', '/inicio/*');
		Router::redirect('/inicio/*', array('controller' => 'home', 'action' => 'index'));

	// Settings
		Router::connect('/configuraciones/*',  array('controller' => 'settings', 'action' => 'index' ));
		Router::redirect('/settings/:action/*', '/configuraciones/*');
		Router::redirect('/configuraciones/*', array('controller' => 'settings', 'action' => 'index'));
		
	// URLs prioritarias
		// Login & Logout
		Router::connect('/login',  array('controller' => 'users', 'action' => 'login' ));
		Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
		// Map
			Router::connect ('/pantallas/mapa', array('controller' => 'displays', 'action' => 'map') );
			Router::redirect('/pantallas/map', '/pantallas/mapa');
		// Play
			Router::connect ('/play/*', array('controller' => 'displays', 'action' => 'play') );
			Router::redirect('/pantallas/play/', '/play');

	// Reescribo las URL generales
		// Alerts
			Router::connect('/alertas/:action/*', array('controller' => 'alerts') );
			Router::redirect('/alerts/:action/*', '/alertas/:action/*');
			Router::redirect('/alertas/*', array('controller' => 'alerts', 'action' => 'index'));
		// Audits
			Router::connect('/logs/:action/*', array('controller' => 'audits') );
			Router::redirect('/audits/:action/*', '/logs/:action/*');
			Router::redirect('/logs/*', array('controller' => 'audits', 'action' => 'index'));
		// Contents
			Router::connect('/contenidos/:action/*', array('controller' => 'contents') );
			Router::redirect('/contents/:action/*', '/contenidos/:action/*');
			Router::redirect('/contenidos/*', array('controller' => 'contents', 'action' => 'index'));
		// Displays
			Router::connect ('/pantallas/:action/*', array('controller' => 'displays') );
			Router::redirect('/displays/:action/*', '/pantallas/:action/*');
			Router::redirect('/pantallas/*', array('controller' => 'displays', 'action' => 'index'));
		// Messages
			Router::connect('/mensajes/:action/*', array('controller' => 'messages') );
			Router::redirect('/messages/:action/*', '/mensajes/:action/*');
			Router::redirect('/mensajes/*', array('controller' => 'messages', 'action' => 'index'));
		// Origins
			Router::connect('/origenes/:action/*', array('controller' => 'origins') );
			Router::redirect('/origins/:action/*', '/origenes/:action/*');
			Router::redirect('/origenes/*', array('controller' => 'origins', 'action' => 'index'));
		// Tags
			Router::connect('/tags/:action/*', array('controller' => 'tags') );
			Router::redirect('/tags/:action/*', '/tags/:action/*');
			Router::redirect('/tags/*', array('controller' => 'tags', 'action' => 'index'));
		// Usuarios
			Router::connect('/usuarios/:action/*', array('controller' => 'users') );
			Router::redirect('/users/:action/*', '/usuarios/:action/*');
			Router::redirect('/usuarios/*', array('controller' => 'users', 'action' => 'index'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display') );

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
