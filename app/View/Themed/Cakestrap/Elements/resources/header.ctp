<header id="header" class="navbar navbar-primary navbar-top">
	<div class="container">
		<div class="row">

			<!-- LOGO -->
				<div class="col-md-6 col-sm-6 col-xs-6">
					<?php
						// Muestro el logo
							echo $this->Html->link(
								'Buenos Aires Ciudad',
								array(
									'controller' => 'home',
									'action' 	 => 'index',
								),
								array(
									'class' => 'navbar-brand bac-header',
								)
							);
					?>
				</div>

			<!-- LOGOUT -->
				<div class="col-md-6 col-sm-6 col-xs-6">

					<?php
						$opciones = array();
						$opciones['controller'] = 'users';

						// Si está logeado
							if ( AuthComponent::user('user_id') )
							{
								$opciones['title']  = AuthComponent::user('user') . ' | Cerrar sesión';
								$opciones['action'] = 'logout';
							}
						// O sino
							else
							{
								$opciones['title']  = 'Iniciar sesión';
								$opciones['action'] = 'login';
							}

						// Muestro el botón
							echo $this->Html->link(
								$opciones['title'],
								array(
									'controller' => $opciones['controller'],
									'action' 	 => $opciones['action'],
								),
								array(
									'id'  	 => $opciones['action'],
									'class'  => 'pull-right',
									'escape' => false,
								)
							);
					?>
					
				</div>

		</div>
	</div>
</header>