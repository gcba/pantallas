<?php
	$this->set('title_for_layout', 'Logs');
?>

<!-- AUDITS-INDEX -->
	<div id="audits-index" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Logs</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-12 col-sm-12 col-xs-12">

					<!-- TABLA -->
						<div class="table-responsive">
							<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
								
								<!-- HEADER -->
									<tr>
										<th><?php echo $this->Paginator->sort('created', 'Fecha de creación'); ?></th>
										<th><?php echo $this->Paginator->sort('event', 'Evento'); ?></th>
										<th><?php echo $this->Paginator->sort('model', 'Modelo'); ?></th>
										<th><?php echo $this->Paginator->sort('entity_id', 'Entidad'); ?></th>
										<th><?php echo $this->Paginator->sort('source', 'Autor'); ?></th>
										<th class="actions"><?php echo 'Acciones'; ?></th>
									</tr>


								<!-- CAMPOS -->
									<?php
										foreach ($audits as $audit):
									?>

										<tr>

											<!-- CREADO -->
												<td>
													<?php echo h($audit['Audit']['created']); ?>
												</td>

											<!-- EVENTO -->
												<td>
													<?php echo h($audit['Audit']['event']); ?>
												</td>

											<!-- MODELO -->
												<td>
													<?php echo h($audit['Audit']['model']); ?>
												</td>

											<!-- ENTIDAD -->
												<td>
													<?php echo h($audit['Audit']['entity_id']); ?>
												</td>

											<!-- AUTOR -->
												<td>
													<?php
														if($audit['User']['user'])
														{
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'users', 'view' ) )
															{
																echo $this->Html->link(
																		$audit['User']['user'],
																		array(
																				'controller' => 'users',
																				'action' => 'view',
																				$audit['User']['user_id']
																			)
																	);
															}
															else
															{
																echo h($audit['User']['user']);
															}
														}
														else
														{
															echo h($audit['Audit']['source_mail']);
														}
													?>
												</td>

											<!-- ACCIONES -->
												<td class="actions text-center">
													<?php

														// VER
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'audits', 'view' ) )
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
																		$audit['Audit']['id']
																	),
																	array(
																		'class'  => 'btn btn-info btn-xs',
																		'title'  => 'Ver',
																		'escape' => false 
																	)
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