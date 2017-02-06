<?php
	$this->set('title_for_layout', 'Detalle del mensaje');
?>

<!-- MESSAGES-VIEW -->
	<div id="messages-view" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Detalle de mensaje</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-6 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 main-actions">
								
								<?php
									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'messages', 'edit' ) )
									{
										// EDITAR
										echo $this->Html->link(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-pencil')
											) . ' Editar',
											array(
												'controller' => 'messages',
												'action' 	 => 'edit',
												$message['Message']['mensaje_id'],
											),
											array(
												'class'  => 'btn btn-large btn-warning',
												'escape' => false,
											)
										);
									}

									// Compruebo los permisos
									if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'messages', 'delete' ) )
									{
										// BORRAR
										echo $this->Form->postLink(
											$this->Html->tag(
												'span',
												'',
												array('class' => 'glyphicon glyphicon-remove')
											) . ' Borrar',
											array(
												'controller' => 'messages',
												'action' 	 => 'delete',
												$message['Message']['mensaje_id'],
											),
											array(
												'class'  => 'btn btn-large btn-danger',
												'escape' => false,
											),
											__('Are you sure you want to delete # %s?', $message['Message']['mensaje_id'])
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
													<?php echo h($message['Message']['mensaje_id']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- TÍTULO -->
											<tr>
												<td>
													<strong><?php echo 'Título'; ?></strong>
												</td>
												<td>
													<?php echo h($message['Message']['titulo']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- MENSAJE -->
											<tr>
												<td>
													<strong><?php echo 'Mensaje'; ?></strong>
												</td>
												<td>
													<?php echo h($message['Message']['mensaje']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- ACTIVO -->
											<tr>
												<td>
													<strong><?php echo 'Activo'; ?></strong>
												</td>
												<td>
													<?php
														if($message['Message']['activo'])
															echo 'SI';
														else
															echo 'NO';
													?>
													&nbsp;
												</td>
											</tr>

									</table>

							</div>
						</div>

				</div>

		</div>
	</div>