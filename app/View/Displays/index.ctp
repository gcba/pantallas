<?php
	$this->set('title_for_layout', 'Pantallas');
?>

<!-- DISPLAYS-INDEX -->
	<div id="displays-index" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Pantallas</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-12 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								<?php
									// AGREGAR
										if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'displays', 'add' ) )
										{
											echo $this->Html->link(
												$this->Html->tag(
													'span',
													'',
													array(
														'class' => 'glyphicon glyphicon-plus'
													)
												) . ' Nueva pantalla',
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
								<?php
									// MAPA
										if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'displays', 'map' ) )
										{
											echo $this->Html->link(
												$this->Html->tag(
													'span',
													'',
													array(
														'class' => 'glyphicon glyphicon-globe'
													)
												) . ' Ver mapa',
												array(
													'action' => 'map'
												),
												array(
													'class' => 'btn btn-large btn-default',
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
										<th class="id"><?php echo $this->Paginator->sort('pantalla_id', 'ID'); ?></th>
										<th><?php echo $this->Paginator->sort('nombre', 'Nombre'); ?></th>
										<th><?php echo $this->Paginator->sort('ip_actual', 'IP'); ?></th>
										<th><?php echo $this->Paginator->sort('tags', 'Tags'); ?></th>
										<th><?php echo $this->Paginator->sort('fecha_ultima_consulta', 'Última consulta'); ?></th>
										<th><?php echo $this->Paginator->sort('fecha_ultima_modificacion', 'Última modificación'); ?></th>
										<th class="actions"><?php echo 'Acciones'; ?></th>
									</tr>


								<!-- CAMPOS -->
									<?php foreach ($displays as $pantalla): ?>

										<tr>

											<!-- ID -->
												<td>
													<?php echo h($pantalla['Display']['pantalla_id']); ?>
												</td>

											<!-- NOMBRE -->
												<td>
													<?php
														if( $pantalla['Display']['envio_alerta'] == '1' )
															echo '<span class="label label-danger">' . h($pantalla['Display']['nombre']) . '</span>';
														else
															echo h($pantalla['Display']['nombre']);
													?>
												</td>

											<!-- IP -->
												<td>
													<?php 
														if( $pantalla['Display']['ip_actual'] == '' )
															echo '<span class="label label-danger">IP no definida</span>';
														else
															echo h($pantalla['Display']['ip_actual']);
													?>
												</td>

											<!-- TAGS -->
												<td>
													<?php 
														$t = '';

														foreach ($pantalla['Tag'] as $key => $value)
															$t .= '<span class="label label-info">' . $value['nombre'] . '</span>&nbsp;';
															// $t .= $value['nombre'];

														echo rtrim($t, ', ');
													?>
												</td>

											<!-- FECHA ÚLTIMA CONSULTA -->
												<td>
													<?php 
														if( $pantalla['Display']['fecha_ultima_consulta'] == '' )
															echo '<span class="label label-danger">Nunca consultada</span>';
														else
															echo h($pantalla['Display']['fecha_ultima_consulta']); 
													?>
												</td>

											<!-- FECHA ÚLTIMA MODIFICACIÓN -->
												<td>
													<?php 
														if( $pantalla['Display']['fecha_ultima_modificacion'] == '' )
															echo '-';
														else
															echo h($pantalla['Display']['fecha_ultima_modificacion']); 
													?>
												</td>

											<!-- ACCIONES -->
												<td class="actions text-center">
													<?php

														// REPRODUCIR
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'displays', 'play' ) )
															{
																echo $this->Html->link(
																	$this->Html->tag(
																		'span',
																		'',
																		array(
																			'class' => 'glyphicon glyphicon-play'
																		)
																	),
																	array(
																		'action' => 'play',
																		$pantalla['Display']['pantalla_id']
																	),
																	array(
																		'class' => 'btn btn-success btn-xs',
																		'title' => 'Reproducir',
																		'escape' => false,
																		'target' => '_blank'
																	)
																);
																echo '&nbsp;';
															}

														// VER
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'displays', 'view' ) )
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
																		$pantalla['Display']['pantalla_id']
																	),
																	array(
																		'class' => 'btn btn-info btn-xs',
																		'title' => 'Ver',
																		'escape' => false
																	)
																);
																echo '&nbsp;';
															}

														// EDITAR
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'displays', 'edit' ) )
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
																		$pantalla['Display']['pantalla_id']
																	),
																	array(
																		'class' => 'btn btn-warning btn-xs',
																		'title' => 'Editar',
																		'escape' => false
																	)
																);
																echo '&nbsp;';
															}

														// BORRAR
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'displays', 'delete' ) )
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
																		$pantalla['Display']['pantalla_id']
																	),
																	array(
																		'class' => 'btn btn-danger btn-xs',
																		'title' => 'Borrar',
																		'escape' => false
																	),
																	__('Are you sure you want to delete # %s?', $pantalla['Display']['pantalla_id'])
																);
																echo '&nbsp;';
															}
															
													?>
												</td>

										</tr>

									<?php endforeach; ?>

							</table>
						</div>


					<!-- PAGINATOR -->
						<?php echo $this->element('resources/paginator'); ?>


				</div>

		</div>
	</div>