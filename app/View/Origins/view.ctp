<script type="text/javascript">
	var ACTION_TYPE = "<?php echo $this->request->params['action'] ?>";
</script>

<?php $this->Html->script('origins', array('inline' => false)); ?>

<?php
	$this->set('title_for_layout', 'Detalle del origen');
?>

<!-- ORIGINS-VIEW -->
	<div id="origins-view" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Detalle de origen</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-6 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								
								<?php
									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'origins', 'edit' ) )
									{
										// EDITAR
										echo $this->Html->link(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-pencil')
											) . ' Editar',
											array(
												'controller' => 'origins',
												'action' 	 => 'edit',
												$origin['Origin']['origen_id'],
											),
											array(
												'class'  => 'btn btn-large btn-warning',
												'escape' => false,
											)
										);
									}

									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'origins', 'delete' ) )
									{
										// BORRAR
										echo $this->Form->postLink(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-remove')
											) . ' Borrar',
											array(
												'controller' => 'origins',
												'action' 	 => 'delete',
												$origin['Origin']['origen_id'],
											),
											array(
												'class'  => 'btn btn-large btn-danger',
												'escape' => false,
											),
											__('Are you sure you want to delete # %s?', $origin['Origin']['origen_id'])
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
													<?php echo h($origin['Origin']['origen_id']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- NOMBRE -->
											<tr>
												<td>
													<strong><?php echo 'Nombre'; ?></strong>
												</td>
												<td>
													<?php echo h($origin['Origin']['nombre']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- SLUG -->
											<tr>
												<td>
													<strong><?php echo 'Slug'; ?></strong>
												</td>
												<td>
													<?php echo h($origin['Origin']['slug']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- DESCRIPCIÓN -->
											<tr>
												<td>
													<strong><?php echo 'Descripción'; ?></strong>
												</td>
												<td>
													<?php echo h($origin['Origin']['descripcion']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- CRON -->
											<tr>
												<td>
													<strong><?php echo 'CRON'; ?></strong>
												</td>
												<td>
													<?php
														if($origin['Origin']['usa_cron'])
															echo 'SI';
														else
															echo 'NO';
													?>
													&nbsp;
												</td>
											</tr>

										<!-- ÚLTIMA ACTUALIZACIÓN -->
											<tr>
												<td>
													<strong><?php echo 'Última actualización'; ?></strong>
												</td>
												<td>
													<?php echo h($origin['Origin']['fecha_ultima_actualizacion']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- CONFIGURACIÓN -->
											<tr>
												<td>
													<strong><?php echo 'Configuración'; ?></strong>
												</td>
												<td>
													<textarea id="OriginSettings" class="json-textarea"><?php echo h($origin['Origin']['settings']); ?></textarea>
													&nbsp;
												</td>
											</tr>

									</table>

							</div>
						</div>

				</div>

		</div>

		<?php if (!empty($origin['Content'])) { ?>
			<div class="panel panel-default">

				<!-- PANEL HEADER -->
					<div class="panel-heading">
						<h3>Contenidos que usan este origen</h3>
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
													foreach ($origin['Content'] as $contenido):
												?>

													<tr>

														<!-- ID -->
															<td>
																<?php echo h($contenido['contenido_id']); ?>
																&nbsp;
															</td>

														<!-- NOMBRE -->
															<td>
																<?php echo h($contenido['nombre']); ?>
																&nbsp;
															</td>

														<!-- ACCIONES -->
															<td class="actions text-center">
																<?php
																	// Compruebo los permisos
																	if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'contents', 'view' ) )
																	{
																		// VER
																		echo $this->Html->link(
																			$this->Html->tag(
																				'span',
																				'',
																				array(
																					'class' => 'glyphicon glyphicon-eye-open'
																				)
																			),
																			array(
																				'controller' => 'contents',
																				'action' 	 => 'view',
																				$contenido['contenido_id'],
																			),
																			array(
																				'class' => 'btn btn-info btn-xs',
																				'title' => 'Ver',
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