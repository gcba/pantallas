<?php
	$this->set('title_for_layout', 'Orígenes');
?>

<!-- ORIGINS-INDEX -->
	<div id="origins-index" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Orígenes</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-12 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								<?php
									// AGREGAR
										if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'origins', 'add' ) )
										{
											echo $this->Html->link(
												$this->Html->tag(
													'span',
													'',
													array(
														'class' => 'glyphicon glyphicon-plus'
													)
												) . ' Nuevo origen',
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
										<th class="id"><?php echo $this->Paginator->sort('origen_id', 'ID'); ?></th>
										<th><?php echo $this->Paginator->sort('nombre', 'Nombre'); ?></th>
										<th><?php echo $this->Paginator->sort('descripcion', 'Descripción'); ?></th>
										<th><?php echo $this->Paginator->sort('usa_cron', 'CRON'); ?></th>
										<th><?php echo $this->Paginator->sort('fecha_ultima_actualizacion', 'Última actualización'); ?></th>
										<th><?php echo $this->Paginator->sort('fecha_ultima_modificacion', 'Última modificación'); ?></th>
										<th class="actions"><?php echo 'Acciones'; ?></th>
									</tr>


								<!-- CAMPOS -->
									<?php foreach ($origins as $origin): ?>

										<tr>

											<!-- ID -->
												<td>
													<?php echo h($origin['Origin']['origen_id']); ?>
												</td>

											<!-- NOMBRE -->
												<td>
													<?php echo h($origin['Origin']['nombre']); ?>
												</td>

											<!-- DESCRIPCIÓN -->
												<td>
													<?php echo h($origin['Origin']['descripcion']); ?>
												</td>

											<!-- CRON -->
												<td>
													<?php
														if($origin['Origin']['usa_cron'])
															echo 'SI';
														else
															echo 'NO';
													?>
												</td>

											<!-- ÚLTIMA ACTUALIZACIÓN -->
												<td>
													<?php
														if($origin['Origin']['fecha_ultima_actualizacion'])
															echo h($origin['Origin']['fecha_ultima_actualizacion']);
														else
															echo '-';
													?>
												</td>

											<!-- ÚLTIMA MODIFICACIÓN -->
												<td>
													<?php
														if($origin['Origin']['fecha_ultima_modificacion'])
															echo h($origin['Origin']['fecha_ultima_modificacion']);
														else
															echo '-';
													?>
												</td>

											<!-- ACCIONES -->
												<td class="actions text-center">
													<?php

														// VER
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'origins', 'view' ) )
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
																		$origin['Origin']['origen_id']
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
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'origins', 'edit' ) )
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
																		$origin['Origin']['origen_id']
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
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'origins', 'delete' ) )
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
																		$origin['Origin']['origen_id']
																	),
																	array(
																		'class' => 'btn btn-danger btn-xs',
																		'title' => 'Borrar',
																		'escape' => false
																	),
																	__('Are you sure you want to delete # %s?', $origin['Origin']['origen_id'])
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