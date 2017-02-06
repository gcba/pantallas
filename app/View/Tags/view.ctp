<?php
	$this->set('title_for_layout', 'Detalle del tag');
?>

<!-- TAGS-VIEW -->
	<div id="tags-view" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Detalle de tag</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-6 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								
								<?php
									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'tags', 'edit' ) )
									{
										// EDITAR
										echo $this->Html->link(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-pencil')
											) . ' Editar',
											array(
												'controller' => 'tags',
												'action' 	 => 'edit',
												$tag['Tag']['tag_id'],
											),
											array(
												'class'  => 'btn btn-large btn-warning',
												'escape' => false,
											)
										);
									}

									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'tags', 'delete' ) )
									{
										// BORRAR
										echo $this->Form->postLink(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-remove')
											) . ' Borrar',
											array(
												'controller' => 'tags',
												'action' 	 => 'delete',
												$tag['Tag']['tag_id'],
											),
											array(
												'class'  => 'btn btn-large btn-danger',
												'escape' => false,
											),
											__('Are you sure you want to delete # %s?', $tag['Tag']['tag_id'])
										);
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
													<?php echo h($tag['Tag']['tag_id']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- NOMBRE -->
											<tr>
												<td>
													<strong><?php echo 'Nombre'; ?></strong>
												</td>
												<td>
													<?php echo h($tag['Tag']['nombre']); ?>
													&nbsp;
												</td>
											</tr>

									</table>

							</div>
						</div>

				</div>

		</div>

		<?php if (!empty($tag['Display'])) { ?>
			<div class="panel panel-default">

				<!-- PANEL HEADER -->
					<div class="panel-heading">
						<h3>Pantallas que usan este tag</h3>
					</div>

				<!-- PANEL BODY -->
					<div class="panel-body col-md-6 col-sm-12 col-xs-12">

						<!-- TABLA -->
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">

									<!-- CAMPOS -->
										<table class="table table-striped table-bordered">

											<!-- HEADER -->
												<tr>
													<th><?php echo 'ID'; ?></th>
													<th><?php echo 'Nombre'; ?></th>
													<th><?php echo 'Acciones'; ?></th>
												</tr>

											<!-- CAMPOS -->
												<?php
													foreach ($tag['Display'] as $pantalla):
												?>

													<tr>

														<!-- ID -->
															<td>
																<?php echo h($pantalla['pantalla_id']); ?>
																&nbsp;
															</td>

														<!-- NOMBRE -->
															<td>
																<?php echo h($pantalla['nombre']); ?>
																&nbsp;
															</td>

														<!-- ACCIONES -->
															<td class="actions text-center">
																<?php 
																	// Compruebo los permisos
																	if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'displays', 'view' ) )
																	{
																		echo $this->Html->link(
																			$this->Html->tag(
																				'span',
																				'',
																				array(
																					'class' => 'glyphicon glyphicon-eye-open',
																				)
																			),
																			array(
																				'controller' => 'displays',
																				'action' 	 => 'view',
																				$pantalla['pantalla_id'],
																			),
																			array(
																				'class'  => 'btn btn-info btn-xs',
																				'title'  => 'Ver',
																				'escape' => false,
																			)
																		);
																	}
																?>
																&nbsp;
															</td>
													</tr>

												<?php
													endforeach;
												?>

										</table>

								</div>
							</div>

					</div>
	
			</div>
		<?php } ?>

		<?php if (!empty($tag['User'])) { ?>
			<div class="panel panel-default">

				<!-- PANEL HEADER -->
					<div class="panel-heading">
						<h3>Usuarios que usan este tag</h3>
					</div>

				<!-- PANEL BODY -->
					<div class="panel-body col-md-6 col-sm-12 col-xs-12">

						<!-- TABLA -->
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">

									<!-- CAMPOS -->
										<table class="table table-striped table-bordered">

											<!-- HEADER -->
												<tr>
													<th><?php echo 'ID'; ?></th>
													<th><?php echo 'Nombre'; ?></th>
													<th><?php echo 'Acciones'; ?></th>
												</tr>

											<!-- CAMPOS -->
												<?php
													foreach ($tag['User'] as $user):
												?>

													<tr>

														<!-- ID -->
															<td>
																<?php echo h($user['user_id']); ?>
																&nbsp;
															</td>

														<!-- NOMBRE -->
															<td>
																<?php echo h($user['user']); ?>
																&nbsp;
															</td>

														<!-- ACCIONES -->
															<td class="actions text-center">
																<?php 
																	// Compruebo los permisos
																	if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'users', 'view' ) )
																	{
																		echo $this->Html->link(
																			$this->Html->tag(
																				'span',
																				'',
																				array(
																					'class' => 'glyphicon glyphicon-eye-open',
																				)
																			),
																			array(
																				'controller' => 'users',
																				'action' 	 => 'view',
																				$user['user_id'],
																			),
																			array(
																				'class'  => 'btn btn-info btn-xs',
																				'title'  => 'Ver',
																				'escape' => false,
																			)
																		);
																	}
																?>
																&nbsp;
															</td>
													</tr>

												<?php
													endforeach;
												?>

										</table>

								</div>
							</div>

					</div>
	
			</div>
		<?php } ?>
	</div>