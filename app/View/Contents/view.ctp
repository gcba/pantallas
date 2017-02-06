<script type="text/javascript">
	var ACTION_TYPE = "<?php echo $this->request->params['action'] ?>";
</script>

<?php $this->Html->script('contents', array('inline' => false)); ?>

<?php
	$this->set('title_for_layout', 'Detalle del contenido');
?>

<!-- CONTENTS-VIEW -->
	<div id="contents-view" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Detalle de contenido</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-6 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								
								<?php
									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'contents', 'play' ) )
									{
										// EDITAR
										echo $this->Html->link(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-play')
											) . ' Reproducir',
											array(
												'controller' => 'contents',
												'action' 	 => 'play',
												$content['Content']['contenido_id'],
											),
											array(
												'class'  => 'btn btn-large btn-success',
												'escape' => false,
												'target' => '_blank',
											)
										);
									}

									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'contents', 'edit' ) )
									{
										// EDITAR
										echo $this->Html->link(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-pencil')
											) . ' Editar',
											array(
												'controller' => 'contents',
												'action' 	 => 'edit',
												$content['Content']['contenido_id'],
											),
											array(
												'class'  => 'btn btn-large btn-warning',
												'escape' => false,
											)
										);
									}

									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'contents', 'delete' ) )
									{
										// BORRAR
										echo $this->Form->postLink(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-remove')
											) . ' Borrar',
											array(
												'controller' => 'contents',
												'action' 	 => 'delete',
												$content['Content']['contenido_id'],
											),
											array(
												'class'  => 'btn btn-large btn-danger',
												'escape' => false,
											),
											__('Are you sure you want to delete # %s?', $content['Content']['contenido_id'])
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
													<?php echo h($content['Content']['contenido_id']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- NOMBRE -->
											<tr>
												<td>
													<strong><?php echo 'Nombre'; ?></strong>
												</td>
												<td>
													<?php echo h($content['Content']['nombre']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- DESCRIPCIÓN -->
											<tr>
												<td>
													<strong><?php echo 'Descripción'; ?></strong>
												</td>
												<td>
													<?php echo h($content['Content']['descripcion']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- ORIGEN -->
											<tr>
												<td>
													<strong><?php echo 'Origen'; ?></strong>
												</td>
												<td>
													<?php
														// Compruebo los permisos
														if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'origins', 'view' ) )
														{
															echo $this->Html->link(
																	$content['Origin']['nombre'],
																	array(
																		'controller' => 'origins',
																		'action' 	 => 'view',
																		$content['Origin']['origen_id'],
																	)
																);
														}
														else
														{
															echo h($content['Origin']['nombre']);
														}
													?>
													&nbsp;
												</td>
											</tr>

										<!-- CONFIGURACIÓN -->
											<tr>
												<td>
													<strong><?php echo 'Configuración'; ?></strong>
												</td>
												<td>
													<textarea id="ContentSettings" class="json-textarea"><?php echo h($content['Content']['settings']); ?></textarea>
													&nbsp;
												</td>
											</tr>

									</table>

							</div>
						</div>

				</div>

		</div>

		<?php if (!empty($content['Display'])) { ?>
			<div class="panel panel-default">

				<!-- PANEL HEADER -->
					<div class="panel-heading">
						<h3>Pantallas que usan este contenido</h3>
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
													foreach ($content['Display'] as $pantalla):
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
	</div>