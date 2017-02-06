<?php
	/**
	 *
	 * PHP 5
	 *
	 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
	 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 *
	 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
	 * @link          http://cakephp.org CakePHP(tm) Project
	 * @package       Cake.View.Layouts
	 * @since         CakePHP(tm) v 0.10.0.1076
	 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
	 */

	$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>

<!DOCTYPE html>
<html lang="es">

	<head>

		<!-- CHARSET -->
			<?php echo $this->Html->charset(); ?>

		<!-- TÍTULO -->
			<title>
				<?php echo $title_for_layout . ' | ' . Configure::read('Environment')['name']; ?>
			</title>

		<!-- CSS -->
			<?php
				echo $this->Html->meta(null, null, array(
					'name' 		=> 'viewport',
					'content' 	=> 'width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no',
					'inline' 	=> false
				));
				echo $this->Html->meta('icon');
				echo $this->fetch('meta');
				
				echo $this->Html->css(['bootstrap.min', 'bastrap7', 'backend']);
				echo $this->fetch('css');
			?>

			<style>
				.error-message {
					position: relative;
					top: 2px;
					left: 1px;

					font-weight: bold;
					font-size: small;
					color: #f72f2a;
				}
			</style>

	</head>

	<body>
			
		<!-- HEADER -->
			<?php echo $this->element('resources/header'); ?>

		<!-- NAV -->
			<?php 
				// Si está logeado le muestro la nav
				if( AuthComponent::user('user_id') ) {
					echo $this->element('resources/nav');
				}
			?>
		
		<!-- CONTENT -->
			<div id="content" class="container">

				<!-- FLASH -->
					<?php
						// Muestro siempre los mensajes flash
						echo $this->Session->flash();
					?>

				<!-- PERMISOS -->
					<?php
						// Si está logeado y hay un error de permisos
						if( AuthComponent::user('user_id') && $this->Session->check('Message.permisos') ) {
							echo $this->Session->flash('permisos');
						}
					?>

				<!-- BREADCRUMB -->
					<?php 
						// Si está logeado le muestro el breadcrumb
						if( AuthComponent::user('user_id') ) {
							echo $this->Breadcrumb->create($this->request->params['controller'], $this->request->params['action'], $this->request->params['pass']);
						}
					?>

				<!-- CONTENIDO -->
					<?php echo $this->fetch('content'); ?>

			</div>

		<!-- FOOTER -->
			<?php echo $this->element('resources/footer'); ?>

		<!-- SCRIPTS -->
			<?php
				echo $this->Html->script(['libs/jquery.min', 'libs/bootstrap.min', 'libs/handlebars', 'main']);
				echo $this->fetch('script');
			?>
		
	</body>

</html>