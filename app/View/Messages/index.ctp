<?php
	$this->set('title_for_layout', 'Mensajes');
?>

<!-- MESSAGES-INDEX -->
	<div id="messages-index" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Mensajes</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-12 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								<?php
									// AGREGAR
										if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'messages', 'add' ) )
										{
											echo $this->Html->link(
												$this->Html->tag(
													'span',
													'',
													array(
														'class' => 'glyphicon glyphicon-plus'
													)
												) . ' Nuevo mensaje',
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
										<th class="id"><?php echo $this->Paginator->sort('mensaje_id', 'ID'); ?></th>
										<th><?php echo $this->Paginator->sort('titulo', 'Título'); ?></th>
										<th><?php echo $this->Paginator->sort('mensaje', 'Mensaje'); ?></th>
										<th><?php echo $this->Paginator->sort('activo', 'Activo'); ?></th>
										<th class="actions"><?php echo 'Acciones'; ?></th>
									</tr>


								<!-- CAMPOS -->
									<?php foreach ($messages as $message): ?>

										<tr>

											<!-- ID -->
												<td>
													<?php echo h($message['Message']['mensaje_id']); ?>
												</td>

											<!-- TÍTULO -->
												<td>
													<?php echo h($message['Message']['titulo']); ?>
												</td>

											<!-- MENSAJE -->
												<td>
													<?php echo h($message['Message']['mensaje']); ?>
												</td>

											<!-- ACTIVO -->
												<td>
													<?php
														if($message['Message']['activo'])
															echo 'SI';
														else
															echo 'NO';
													?>
												</td>

											<!-- ACCIONES -->
												<td class="actions text-center">
													<?php

														// VER
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'messages', 'view' ) )
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
																		$message['Message']['mensaje_id']
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
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'messages', 'edit' ) )
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
																		$message['Message']['mensaje_id']
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
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'messages', 'delete' ) )
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
																		$message['Message']['mensaje_id']
																	),
																	array(
																		'class' => 'btn btn-danger btn-xs',
																		'title' => 'Borrar',
																		'escape' => false
																	),
																	__('Are you sure you want to delete # %s?', $message['Message']['mensaje_id'])
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