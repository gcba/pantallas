<?php
	$this->set('title_for_layout', 'Detalle del usuario');
?>

<!-- USERS-VIEW -->
	<div id="users-view" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Detalle de usuarios</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-6 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								
								<?php
									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'users', 'edit' ) )
									{
										$show = true;

										if( User::isRoleRoot($user['User']['role']) )
										{
											if( !User::isRoot() )
											{
												$show = false;
											}
										}

										if($show)
										{
											// EDITAR
											echo $this->Html->link(
												$this->Html->tag(
													'span',
													'',
													array('class' => 'glyphicon glyphicon-pencil')
												) . ' Editar',
												array(
													'controller' => 'users',
													'action' 	 => 'edit',
													$user['User']['user_id'],
												),
												array(
													'class'  => 'btn btn-large btn-warning',
													'escape' => false,
												)
											);
										}
									}

									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'users', 'delete' ) )
									{
										$show = true;

										if( User::isRoleRoot($user['User']['role']) )
										{
											if( !User::isRoot() )
											{
												$show = false;
											}
										}

										if($show)
										{
											// BORRAR
											echo $this->Form->postLink(
												$this->Html->tag(
													'span',
													'',
													array('class' => 'glyphicon glyphicon-remove')
												) . ' Borrar',
												array(
													'controller' => 'users',
													'action' 	 => 'delete',
													$user['User']['user_id'],
												),
												array(
													'class'  => 'btn btn-large btn-danger',
													'escape' => false,
												),
												__('Are you sure you want to delete # %s?', $user['User']['user_id'])
											);
										}
									}
								?>

							</div>
						</div>

					<!-- TABLA -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">

								<!-- CAMPOS -->
									<table class="table table-striped table-bordered">

										<!-- ID -->
											<tr>
												<td>
													<strong><?php echo 'ID'; ?></strong>
												</td>
												<td>
													<?php echo h($user['User']['user_id']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- NOMBRE -->
											<tr>
												<td>
													<strong><?php echo 'Nombre'; ?></strong>
												</td>
												<td>
													<?php echo h($user['User']['user']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- EMAIL -->
											<tr>
												<td>
													<strong><?php echo 'Correo electrónico'; ?></strong>
												</td>
												<td>
													<?php echo h($user['User']['mail']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- ROL -->
											<tr>
												<td>
													<strong><?php echo 'Rol'; ?></strong>
												</td>
												<td>
													<?php echo h( User::getRoleName($user['User']['role']) ); ?>
													&nbsp;
												</td>
											</tr>

										<!-- ÚLTIMA CONEXIÓN -->
											<tr>
												<td>
													<strong><?php echo 'Última conexión'; ?></strong>
												</td>
												<td>
													<?php echo h($user['User']['last_login']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- TAGS -->
											<tr>
												<td>
													<strong><?php echo 'Tags'; ?></strong>
												</td>
												<td>
													<?php
														echo Tag::getList($user['Tag']);
													?>
													&nbsp;
												</td>
											</tr>

									</table>

							</div>
						</div>

				</div>

		</div>
	</div>