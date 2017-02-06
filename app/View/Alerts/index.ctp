<?php
	$this->set('title_for_layout', 'Alertas');
?>

<!-- ALERTS-INDEX -->
	<div id="alerts-index" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Alertas</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-12 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								<?php
									// AGREGAR
										if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'alerts', 'add' ) )
										{
											echo $this->Html->link(
												$this->Html->tag(
													'span',
													'',
													array(
														'class' => 'glyphicon glyphicon-plus'
													)
												) . ' Nueva alerta',
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
										<th class="id"><?php echo $this->Paginator->sort('alerta_id', 'ID'); ?></th>
										<th><?php echo $this->Paginator->sort('titulo', 'Título'); ?></th>
										<th><?php echo $this->Paginator->sort('subtitulo', 'Subtítulo'); ?></th>
										<th><?php echo $this->Paginator->sort('activo', 'Activa'); ?></th>
										<th><?php echo $this->Paginator->sort('fecha_desde', 'Desde'); ?></th>
										<th><?php echo $this->Paginator->sort('fecha_hasta', 'Hasta'); ?></th>
										<th><?php echo $this->Paginator->sort('icono', 'Ícono'); ?></th>
										<th><?php echo $this->Paginator->sort('color', 'Color'); ?></th>
										<th class="actions"><?php echo 'Acciones'; ?></th>
									</tr>


								<!-- CAMPOS -->
									<?php foreach ($alerts as $alert): ?>

										<tr>

											<!-- ID -->
												<td>
													<?php echo h($alert['Alert']['alerta_id']); ?>
												</td>

											<!-- TÍTULO -->
												<td>
													<?php echo h($alert['Alert']['titulo']); ?>
												</td>

											<!-- SUBTÍTULO -->
												<td>
													<?php echo h($alert['Alert']['subtitulo']); ?>
												</td>

											<!-- ACTIVO -->
												<td>
													<?php
														if($alert['Alert']['activo'])
															echo 'SI';
														else
															echo 'NO';
													?>
												</td>

											<!-- DESDE -->
												<td>
													<?php
														if($alert['Alert']['fecha_desde'])
															echo h($alert['Alert']['fecha_desde']);
														else
															echo '-';
													?>
												</td>

											<!-- HASTA -->
												<td>
													<?php
														if($alert['Alert']['fecha_hasta'])
															echo h($alert['Alert']['fecha_hasta']);
														else
															echo '-';
													?>
												</td>

											<!-- ÍCONO -->
												<td>
													<?php echo h($alert['Alert']['icono']); ?>
												</td>

											<!-- COLOR -->
												<td>
													<?php echo h($alert['Alert']['color']); ?>
												</td>

											<!-- ACCIONES -->
												<td class="actions text-center">
													<?php

														// VER
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'alerts', 'view' ) )
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
																		$alert['Alert']['alerta_id']
																	),
																	array( 'class' => 'btn btn-info btn-xs', 'title' => 'Ver', 'escape' => false )
																);
																echo '&nbsp;';
															}

														// EDITAR
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'alerts', 'edit' ) )
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
																		$alert['Alert']['alerta_id']
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
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'alerts', 'delete' ) )
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
																		$alert['Alert']['alerta_id']
																	),
																	array(
																		'class' => 'btn btn-danger btn-xs',
																		'title' => 'Borrar',
																		'escape' => false
																	),
																	__('Are you sure you want to delete # %s?', $alert['Alert']['alerta_id'])
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