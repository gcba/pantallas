<?php
	$this->set('title_for_layout', 'Usuarios');
?>

<!-- USERS-INDEX -->
	<div id="users-index" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Usuarios</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-12 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								<?php 
									// AGREGAR
										if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'users', 'add' ) )
										{
											echo $this->Html->link(
												$this->Html->tag(
													'span',
													'',
													array(
														'class' => 'glyphicon glyphicon-plus'
													)
												) . ' Nuevo usuario',
												array(
													'action' => 'add'
												),
												array(
													'class' => 'btn btn-large btn-primary',
													'escape' => false
												)
											);
										}
								?>
							</div>
						</div>

					<!-- TABLA -->
						<div class="table-responsive">
							<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
								
								<!-- HEADER -->
									<tr>
										<th class="id"><?php echo $this->Paginator->sort('user_id', 'ID'); ?></th>
										<th><?php echo $this->Paginator->sort('user', 'Nombre'); ?></th>
										<th><?php echo $this->Paginator->sort('mail', 'Correo electrónico'); ?></th>
										<th><?php echo $this->Paginator->sort('role', 'Rol'); ?></th>
										<th><?php echo $this->Paginator->sort('tags', 'Tags'); ?></th>
										<th class="actions"><?php echo 'Acciones'; ?></th>
									</tr>


								<!-- CAMPOS -->
									<?php
										foreach ($users as $user):
									?>

										<tr>

											<!-- ID -->
												<td>
													<?php echo h($user['User']['user_id']); ?>
												</td>

											<!-- NOMBRE -->
												<td>
													<?php echo h($user['User']['user']); ?>
												</td>

											<!-- CORREO ELECTRÓNICO -->
												<td>
													<?php echo h($user['User']['mail']); ?>
												</td>

											<!-- ROL -->
												<td>
													<?php echo h(User::getRoleName($user['User']['role'])); ?>
												</td>

											<!-- TAGS -->
												<td>
													<?php 
														$t = '';

														foreach ($user['Tag'] as $key => $value)
															$t .= '<span class="label label-info">' . $value['nombre'] . '</span>&nbsp;';

														echo rtrim($t, ", ");
													?>
												</td>

											<!-- ACCIONES -->
												<td class="actions text-center">
													<?php

														// VER
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'users', 'view' ) )
															{
																echo $this->Html->link(
																	$this->Html->tag(
																		'span',
																		'',
																		array(
																			'class' => 'glyphicon glyphicon-eye-open'
																		)
																	),
																	array(
																		'action' => 'view',
																		$user['User']['user_id']
																	),
																	array(
																		'class' => 'btn btn-info btn-xs',
																		'escape' => false
																	)
																);
																echo '&nbsp;';
															}

														// EDITAR
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'users', 'edit' ) )
															{
																echo $this->Html->link(
																	$this->Html->tag(
																		'span',
																		'',
																		array(
																			'class' => 'glyphicon glyphicon-pencil'
																		)
																	),
																	array(
																		'action' => 'edit',
																		$user['User']['user_id']
																	),
																	array(
																		'class' => 'btn btn-warning btn-xs',
																		'escape' => false
																	)
																);
																echo '&nbsp;';
															}

														// BORRAR
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'users', 'delete' ) )
															{
																echo $this->Form->postLink(
																	$this->Html->tag(
																		'span',
																		'',
																		array(
																			'class' => 'glyphicon glyphicon-remove'
																		)
																	),
																	array(
																		'action' => 'delete',
																		$user['User']['user_id']
																	),
																	array(
																		'class' => 'btn btn-danger btn-xs',
																		'escape' => false
																	),
																	__('Are you sure you want to delete # %s?', $user['User']['user_id'])
																);
																echo '&nbsp;';
															}
															
													?>
												</td>

										</tr>

									<?php
										endforeach;
									?>

							</table>
						</div>


					<!-- PAGINATOR -->
						<?php echo $this->element('resources/paginator'); ?>


				</div>

		</div>
	</div>