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

				echo $this->Html->css(['bootstrap.min', 'bastrap7', 'animate', 'frontend']);
				echo $this->fetch('css');
			?>

	</head>

	<body>

		<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-PWH48NP');</script>
		<!-- End Google Tag Manager -->

		<!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PWH48NP"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->

		<!-- CONTENT -->
			<?php echo $this->fetch('content'); ?>

		<!-- SCRIPTS -->
			<?php
				echo $this->Html->script(['libs/jquery.min', 'libs/bootstrap.min', 'libs/handlebars', 'main']);
				echo $this->fetch('script');
			?>

	</body>

</html>