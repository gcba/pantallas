<?php
	$this->set('title_for_layout', 'Contenidos');
?>

<!-- CONTENT-INDEX -->
	<div id="content-index" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Contenidos</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-12 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								<?php
									// AGREGAR
										if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'contents', 'add' ) )
										{
											echo $this->Html->link(
												$this->Html->tag(
													'span',
													'',
													array(
														'class' => 'glyphicon glyphicon-plus'
													)
												) . ' Nuevo contenido',
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
										<th class="id"><?php echo $this->Paginator->sort('contenido_id', 'ID'); ?></th>
										<th><?php echo $this->Paginator->sort('nombre', 'Nombre'); ?></th>
										<th><?php echo $this->Paginator->sort('descripcion', 'Descripción'); ?></th>
										<th><?php echo $this->Paginator->sort('origen_id', 'Origen'); ?></th>
										<th><?php echo $this->Paginator->sort('fecha_ultima_modificacion', 'Última modificación'); ?></th>
										<th class="actions"><?php echo 'Acciones'; ?></th>
									</tr>


								<!-- CAMPOS -->
									<?php foreach ($contents as $content): ?>

										<tr>

											<!-- ID -->
												<td>
													<?php echo h($content['Content']['contenido_id']); ?>
												</td>

											<!-- NOMBRE -->
												<td>
													<?php echo h($content['Content']['nombre']); ?>
												</td>

											<!-- DESCRIPCIÓN -->
												<td>
													<?php echo h($content['Content']['descripcion']); ?>
												</td>

											<!-- ORIGEN -->
												<td>
													<?php
														if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'origins', 'view' ) )
														{
															echo $this->Html->link(
																	$content['Origin']['nombre'],
																	array(
																		'controller' => 'origens',
																		'action' => 'view',
																		$content['Origin']['origen_id']
																	)
																);
														}
														else
														{
															echo h($content['Origin']['nombre']);
														}
													?>
												</td>

											<!-- FILTRO -->
												<td>
													<?php
														if( $content['Content']['fecha_ultima_modificacion'] == '' )
															echo '-';
														else
															echo h($content['Content']['fecha_ultima_modificacion']);
													?>
												</td>

											<!-- ACCIONES -->
												<td class="actions text-center">
													<?php

														// PLAY
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'contents', 'play' ) )
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
																		$content['Content']['contenido_id']
																	),
																	array(
																		'class' => 'btn btn-success btn-xs',
																		'title' => 'Reproducir',
																		'escape' => false
																	)
																);
																echo '&nbsp;';
															}

														// VER
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'contents', 'view' ) )
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
																		$content['Content']['contenido_id']
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
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'contents', 'edit' ) )
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
																		$content['Content']['contenido_id']
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
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'contents', 'delete' ) )
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
																		$content['Content']['contenido_id']
																	),
																	array(
																		'class' => 'btn btn-danger btn-xs',
																		'title' => 'Borrar',
																		'escape' => false
																	),
																	__('Are you sure you want to delete # %s?', $content['Content']['contenido_id'])
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