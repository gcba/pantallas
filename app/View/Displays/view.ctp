<script type="text/javascript">
	var ACTION_TYPE = "<?php echo $this->request->params['action'] ?>";
</script>

<?php
	$this->Html->script('//servicios.usig.buenosaires.gob.ar/usig-js/3.1/usig.AutoCompleterFull.min.js', array('inline' => false));
	$this->Html->script('//servicios.usig.buenosaires.gob.ar/usig-js/3.1/usig.MapaEstatico.min.js', array('inline' => false));
	$this->Html->script('//servicios.usig.buenosaires.gob.ar/usig-js/3.1/usig.MapaInteractivo.min.js', array('inline' => false));
	$this->Html->script('displays', array('inline' => false));
?>

<?php
	$this->set('title_for_layout', 'Detalle de la pantalla');
?>

<!-- DISPLAYS-VIEW -->
	<div id="displays-view" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Detalle de pantalla</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-6 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								
								<?php
									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'displays', 'play' ) )
									{
										// EDITAR
										echo $this->Html->link(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-play')
											) . ' Reproducir',
											array(
												'controller' => 'displays',
												'action' 	 => 'play',
												$display['Display']['pantalla_id'],
											),
											array(
												'class'  => 'btn btn-large btn-success',
												'escape' => false,
												'target' => '_blank',
											)
										);
									}

									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'displays', 'edit' ) )
									{
										// EDITAR
										echo $this->Html->link(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-pencil')
											) . ' Editar',
											array(
												'controller' => 'displays',
												'action' 	 => 'edit',
												$display['Display']['pantalla_id'],
											),
											array(
												'class'  => 'btn btn-large btn-warning',
												'escape' => false,
											)
										);
									}

									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'displays', 'delete' ) )
									{
										// BORRAR
										echo $this->Form->postLink(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-remove')
											) . ' Borrar',
											array(
												'controller' => 'displays',
												'action' 	 => 'delete',
												$display['Display']['pantalla_id'],
											),
											array(
												'class'  => 'btn btn-large btn-danger',
												'escape' => false,
											),
											__('Are you sure you want to delete # %s?', $display['Display']['pantalla_id'])
										);
									}
								?>

							</div>
						</div>
					
					<!-- MAPA -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div id="map-container"></div>
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
													<?php echo h($display['Display']['pantalla_id']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- NOMBRE -->
											<tr>
												<td>
													<strong><?php echo 'Nombre'; ?></strong>
												</td>
												<td>
													<?php echo h($display['Display']['nombre']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- DIRECCIÓN -->
											<tr>
												<td>
													<strong><?php echo 'Dirección'; ?></strong>
												</td>
												<td>
													<?php echo h($display['Display']['direccion']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- LATITUD -->
											<tr>
												<td>
													<strong><?php echo 'Latitud'; ?></strong>
												</td>
												<td id="lat-value">
													<?php echo h($display['Display']['lat']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- LONGITUD -->
											<tr>
												<td>
													<strong><?php echo 'Longitud'; ?></strong>
												</td>
												<td id="lng-value">
													<?php echo h($display['Display']['lng']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- COMUNA -->
											<tr>
												<td>
													<strong><?php echo 'Comuna'; ?></strong>
												</td>
												<td>
													<?php echo h($display['Display']['comuna']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- BARRIO -->
											<tr>
												<td>
													<strong><?php echo 'Barrio'; ?></strong>
												</td>
												<td>
													<?php echo h($display['Display']['barrio']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- IP -->
											<tr>
												<td>
													<strong><?php echo 'IP'; ?></strong>
												</td>
												<td>
													<?php echo h($display['Display']['ip_actual']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- ORIGEN -->
											<tr>
												<td>
													<strong><?php echo 'Orientación'; ?></strong>
												</td>
												<td>
													<?php echo h($display['Display']['orientacion']); ?>
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
														$t = '';

														foreach ($display['Tag'] as $key => $value)
															$t .= '<span class="label label-info">' . $value['nombre'] . '</span>&nbsp;';

														echo rtrim($t, ', ');
													?>
												</td>
											</tr>

										<!-- ÚLTIMA CONSULTA -->
											<tr>
												<td>
													<strong><?php echo 'Última consulta'; ?></strong>
												</td>
												<td>
													<?php echo h($display['Display']['fecha_ultima_consulta']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- ÚLTIMA MODIFICACIÓN -->
											<tr>
												<td>
													<strong><?php echo 'Última modificación'; ?></strong>
												</td>
												<td>
													<?php echo h($display['Display']['fecha_ultima_modificacion']); ?>
													&nbsp;
												</td>
											</tr>

									</table>

							</div>
						</div>

				</div>

		</div>

		<?php if (!empty($display['Content'])) { ?>
			<div class="panel panel-default">

				<!-- PANEL HEADER -->
					<div class="panel-heading">
						<h3>Contenidos de la pantalla</h3>
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
													<th><?php echo 'Nombre'; ?></th>
													<th><?php echo 'Origen'; ?></th>
													<th><?php echo 'Acciones'; ?></th>
												</tr>

											<!-- CAMPOS -->
												<?php
													foreach ($display['Content'] as $contenido):
												?>

													<tr>

														<!-- NOMBRE -->
															<td>
																<?php echo h($contenido['nombre']); ?>
																&nbsp;
															</td>

														<!-- FILTRO -->
															<td>
																<?php
																	// Compruebo los permisos
																	if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'origins', 'view' ) )
																	{
																		echo $this->Html->link(
																			$contenido['Origin']['nombre'],
																			array(
																				'controller' => 'origins',
																				'action' 	 => 'view',
																				$contenido['origen_id'],
																			)
																		);
																	}
																	else
																	{
																		echo $contenido['origin'];
																	}
																?>
																&nbsp;
															</td>

														<!-- ACCIONES -->
															<td class="actions text-center">
																<?php
																	// Compruebo los permisos
																	if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'contents', 'view' ) )
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
																				'controller' => 'contents',
																				'action' 	 => 'view',
																				$contenido['contenido_id'],
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