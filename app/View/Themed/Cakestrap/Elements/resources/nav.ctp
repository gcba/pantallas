<nav class="navbar navbar-default" role="navigation">
	<div class="container">

		<!-- MOBILE NAVBAR -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
					<span class="sr-only">Cambiar navegación</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- <a class="navbar-brand" href="#" title="Gobierno Electrónico">Gestión Digital</a> -->
			</div>

		<!-- NAVBAR -->
			<div class="collapse navbar-collapse" id="main-nav">
				<ul class="nav navbar-nav navbar-left">
					
					<?php
						$action 		= 'index';
						$controllers 	= Configure::read('Navbar');

						foreach($controllers as $controller)
						{
							$selected = ($controller == $this->request->params['controller'] ? 'selected' : '');

							// Si tiene permisos
								if( AppController::hasPermissions( AuthComponent::user('Permissions'), $controller, $action ) )
								{
									$badge = '';

									if( $controller == 'messages' && count($activeMessages) > 0 ) {
										$badge = ' <span class="badge">' . count($activeMessages) . '</span>';
									}
									else if( $controller == 'alerts' && count($activeAlerts) > 0 ) {
										$badge = ' <span class="badge">' . count($activeAlerts) . '</span>';
									}

									echo '<li class="' . $selected . '">'
											. $this->Html->link(
												ucfirst(Configure::read('Dictionary')[$controller]['plural']) . $badge,
												array(
													'controller' => $controller,
													'action' 	 => $action,
												),
												array(
													'escape' => false,
												)
											) .
										 '</li>';
								}
						}
					?>

				</ul>
			</div>

	</div>
</nav>