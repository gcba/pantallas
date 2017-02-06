<?php
	$this->set('title_for_layout', 'Detalle de alerta');
?>

<!-- ALERTS-VIEW -->
	<div id="alerts-view" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Detalle de alerta</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-6 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								
								<?php
									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'alerts', 'edit' ) )
									{
										// EDITAR
										echo $this->Html->link(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-pencil')
											) . ' Editar',
											array(
												'controller' => 'alerts',
												'action' 	 => 'edit',
												$alert['Alert']['alerta_id'],
											),
											array(
												'class'  => 'btn btn-large btn-warning',
												'escape' => false,
											)
										);
									}

									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'alerts', 'delete' ) )
									{
										// BORRAR
										echo $this->Form->postLink(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-remove')
											) . ' Borrar',
											array(
												'controller' => 'alerts',
												'action' 	 => 'delete',
												$alert['Alert']['alerta_id'],
											),
											array(
												'class'  => 'btn btn-large btn-danger',
												'escape' => false,
											),
											__('Are you sure you want to delete # %s?', $alert['Alert']['alerta_id'])
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
													<?php echo h($alert['Alert']['alerta_id']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- TÍTULO -->
											<tr>
												<td>
													<strong><?php echo 'Título'; ?></strong>
												</td>
												<td>
													<?php echo h($alert['Alert']['titulo']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- SUBTÍTULO -->
											<tr>
												<td>
													<strong><?php echo 'Subtítulo'; ?></strong>
												</td>
												<td>
													<?php echo h($alert['Alert']['subtitulo']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- ACTIVO -->
											<tr>
												<td>
													<strong><?php echo 'Activa'; ?></strong>
												</td>
												<td>
													<?php
														if($alert['Alert']['activo'])
															echo 'SI';
														else
															echo 'NO';
													?>
													&nbsp;
												</td>
											</tr>

										<!-- DESDE -->
											<tr>
												<td>
													<strong><?php echo 'Desde'; ?></strong>
												</td>
												<td>
													<?php
														if($alert['Alert']['fecha_desde'])
															echo h($alert['Alert']['fecha_desde']);
														else
															echo '-';
													?>
													&nbsp;
												</td>
											</tr>

										<!-- HASTA -->
											<tr>
												<td>
													<strong><?php echo 'Hasta'; ?></strong>
												</td>
												<td>
													<?php
														if($alert['Alert']['fecha_hasta'])
															echo h($alert['Alert']['fecha_hasta']);
														else
															echo '-';
													?>
													&nbsp;
												</td>
											</tr>

										<!-- ÍCONO -->
											<tr>
												<td>
													<strong><?php echo 'Ícono'; ?></strong>
												</td>
												<td>
													<?php echo h($alert['Alert']['icono']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- COLOR -->
											<tr>
												<td>
													<strong><?php echo 'Color'; ?></strong>
												</td>
												<td>
													<?php echo h($alert['Alert']['color']); ?>
													&nbsp;
												</td>
											</tr>

									</table>

							</div>
						</div>

				</div>

		</div>
	</div>