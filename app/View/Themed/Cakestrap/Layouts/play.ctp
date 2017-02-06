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


		<!-- Preloader -->
			<div id="preloader">

				<div class="display-table">
					<div class="display-table-cell text-center">
						<img class="logo pulse animated" src="/img/logo-vba-original.svg" alt="Vamos Buenos Aires">
					</div>
				</div>

			</div>
		<!-- End Preloader -->

		<!-- Touch Overlay -->
			<div id="touch-overlay"></div>
		<!-- End Touch Overlay -->

		<!-- Footer -->
			<div id="footer">
				<div class="container-fluid">

					<!-- TIMER -->
						<div class="timer-wrapper">
							<div id="timer"></div>
						</div>

					<!-- LOGO & FECHA Y HORA -->
					<div class="footer-wrapper">
						
						<!-- LOGO -->
							<div class="col-xs-3 col-sm-3 col-md-3 logo-wrapper">

								<div class="display-table">
									<div class="display-table-cell">
										<img class="logo" src="/img/logo-vba-blanco.svg" alt="Vamos Buenos Aires">
									</div>
								</div>

							</div>

						<!-- FECHA Y HORA -->
							<div class="col-xs-9 col-sm-9 col-md-9 date-time-wrapper">
								
								<div class="display-table date-time">
									<div class="display-table-cell">
								
										<!-- DÍA COMPLETO -->
											<div class="date-wrapper">
												<span class="date">

													<!-- NOMBRE DEL DÍA -->
														<span class="date-name"></span>

													<!-- NÚMERO DEL DÍA -->
														<span class="date-number"></span>

													<!-- DE -->
														<span>de</span>

													<!-- NOMBRE DEL MES -->
														<span class="date-month"></span>

													<!-- DE -->
														<span>de</span>

													<!-- NÚMERO DEL AÑO -->
														<span class="date-year"></span>

												</span>
											</div>

										<!-- HORA COMPLETA -->
											<div class="time-wrapper">
												<span class="time">

													<!-- HORA -->
														<span class="date-hours">00</span>

													<!-- SEPARADOR -->
														<span>:</span>

													<!-- MINUTOS -->
														<span class="date-minutes">00</span>

													<!-- ÍCONO DEL RELOJ -->
														<span class="glyphicon glyphicon-time"></span>

												</span>
											</div>

									</div>
								</div>

							</div>

					</div>

				</div>
			</div>
		<!-- End footer -->

		<!-- Offline -->
			<div id="offline" class="container-fluid">

				<!-- CENTRADOR -->
					<div class="display-table">
						<div class="display-table-cell">
						
							<!-- CONTENIDO -->
								<div class="contenido row">

									<div class="col-xs-6 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 text-center">
										<img class="error-img" src="/img/error-503.png" alt="Error 503">
									</div>

									<div class="col-xs-6 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 text-center">

										<h1 class="titulo">Pantalla fuera de servicio</h1>

										<p class="descripcion">En este momento, esta pantalla está fuera de servicio por problemas técnicos.<br/>
										Estamos trabajando para solucionarlo.<br/><br/>
										¡Gracias por tu paciencia!</p>
									</div>

								</div>

							<!-- SHORTCUTS -->
								<div class="shortcuts row">

									<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
										<div class="row">
											
											<a class="col-xs-6 col-sm-6 col-md-3 shortcut" href="tel:103">
												<h3><span class="glyphicon glyphicon-earphone"></span>103</h3>
												<p>Emergencias</p>
											</a>
											<a class="col-xs-6 col-sm-6 col-md-3 shortcut" href="tel:107">
												<h3><span class="glyphicon glyphicon-earphone"></span>107</h3>
												<p>SAME</p>
											</a>
											<a class="col-xs-6 col-sm-6 col-md-3 shortcut" href="tel:108">
												<h3><span class="glyphicon glyphicon-earphone"></span>108</h3>
												<p>Línea social</p>
											</a>
											<a class="col-xs-6 col-sm-6 col-md-3 shortcut" href="tel:147">
												<h3><span class="glyphicon glyphicon-earphone"></span>147</h3>
												<p>Atención Ciudadana</p>
											</a>

										</div>
									</div>

								</div>


						</div>
					</div>

			</div>
		<!-- End Offline -->


		<!-- Main Content -->
			<div id="main-content">

				<?php echo $this->fetch('content'); ?>

				<?php
					// CARGO LOS CONTAINERS
						foreach ($modules as $module)
						{
							echo '<!-- ' . strtoupper($module['name']) . ' -->';
							echo '<div class="content-container content-type-' . $module['type'] . '" id="content-container-' . $module['contenido_id'] . '" style="display: none;"></div>';
						}

				?>

				<!-- Módulos -->
					<div id="modules"></div>
				<!-- End Módulos -->

				<!-- Templates -->
					<div id="templates">
						<?php
							// CARGO LOS TEMPLATES
							foreach ($includes as $slug)
							{
								$folder 		= DS . 'files' . DS . 'modules' . DS . $slug . DS;
								$relative_path 	= '.' . $folder;
								$scripts 		= 'scripts';
								$styles 		= 'styles';
								$template 		= 'template';

								// Si existe la carpeta
									if(file_exists($relative_path))
									{

										// INCLUDES DE LOS SCRIPTS
											$file = $relative_path . $scripts . '.js' ;

											if( file_exists($file) ) {
												echo $this->Html->script($folder . $scripts, array('inline' => false)); 
											}


										// INCLUDES DE LOS CSS
											$file = $relative_path . $styles . '.css' ;

											if( file_exists($file) ) {
												echo $this->Html->css($folder . $styles); 
												// echo $this->Html->css($folder . $styles, null, array('inline' => false));
											}


										// INCLUDE DE LOS TEMPLATES DE CADA TIPO
											$file = $relative_path . $template . '.html' ;

											if( file_exists($file) )
											{
												echo '<script id="template_' . $slug . '" type="text/x-handlebars-template">';
												include ($file);
												echo '</script>';
											}

									}
								// Sino tiro error
									else
									{
										echo "<script>console.error('No se encontró la carpeta del módulo \'" . $slug . "\'');</script>";
									}
							}
						?>
					</div>
				<!-- End Templates -->

				<!-- Window On Load -->
					<script type="text/javascript">
						window.onload = function()
						{
							// Inicia el plugin
								PlayerMain.init();

							// Seteo la pantalla
								<?php if( isset($display) ): ?>
									PlayerMain.setDisplay( <?php echo json_encode($display); ?> );
								<?php endif; ?>

							// Seteo la lista de módulos
								<?php if( isset($modules) ): ?>
									PlayerMain.setModulesList( <?php echo json_encode($modules); ?> );
								<?php endif; ?>

							// Inicia el PlayerMain
								PlayerMain.ready();
						}
					</script>
				<!-- End Window On Load -->

			</div>
		<!-- End Main Content -->


		<!-- Scripts -->
			<?php
				echo $this->Html->script(['libs/jquery.min', 'libs/bootstrap.min', 'libs/handlebars', 'players/playerBase', 'players/playerMain', 'main']);
				echo $this->fetch('script');
			?>
		<!-- End Scripts -->

	</body>

</html>