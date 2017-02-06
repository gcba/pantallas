<?php
	$this->set('title_for_layout', 'Inicio');
?>

<!-- HOME-INDEX -->
	<div id="home-index" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Bienvenido/a, <?php echo AuthComponent::user('user'); ?>!</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-12 col-sm-12 col-xs-12">
					
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							Tu rol es <strong><?php echo User::getRoleName( User::getRole() ); ?></strong>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							Tus permisos son los siguientes: <strong><?php echo User::getTagsList(); ?></strong>
						</div>
					</div>

					<div class="bump"></div>

				</div>

		</div>
	</div>