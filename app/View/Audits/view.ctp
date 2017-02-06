<?php
	$this->set('title_for_layout', 'Detalle del log');
?>

<!-- AUDITS-VIEW -->
	<div id="audits-view" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Detalle de log</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-6 col-sm-12 col-xs-12">

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
													<?php echo h($audit['Audit']['id']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- CREADO -->
											<tr>
												<td>
													<strong><?php echo 'Fecha de creación'; ?></strong>
												</td>
												<td>
													<?php echo h($audit['Audit']['created']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- AUTOR -->
											<tr>
												<td>
													<strong><?php echo 'Autor'; ?></strong>
												</td>
												<td>
													<?php
														if($audit['User']['user'])
														{
															// Compruebo los permisos
															if( AppController::hasPermissions( AuthComponent::user('Permissions'), 'users', 'view' ) )
															{
																echo $this->Html->link(
																		$audit['User']['user'],
																		array(
																			'controller' => 'users',
																			'action' 	 => 'view',
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
													&nbsp;
												</td>
											</tr>

										<!-- EVENTO -->
											<tr>
												<td>
													<strong><?php echo 'Evento'; ?></strong>
												</td>
												<td>
													<?php echo h($audit['Audit']['event']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- MODELO -->
											<tr>
												<td>
													<strong><?php echo 'Modelo'; ?></strong>
												</td>
												<td>
													<?php echo h($audit['Audit']['model']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- ENTIDAD -->
											<tr>
												<td>
													<strong><?php echo 'Entidad'; ?></strong>
												</td>
												<td>
													<?php echo h($audit['Audit']['entity_id']); ?>
													&nbsp;
												</td>
											</tr>

										<!-- DESCRIPCIÓN -->
											<tr>
												<td>
													<strong><?php echo 'Descripción'; ?></strong>
												</td>
												<td>
													<?php
														if($audit['Audit']['description'])
															echo h($audit['Audit']['description']);
														else
															echo '-';
													?>
													&nbsp;
												</td>
											</tr>

										<!-- JSON OBJECT -->
											<tr>
												<td>
													<strong><?php echo 'JSON Object'; ?></strong>
												</td>
												<td>
													<?php $json = $audit['Audit']['json_object']; ?>

													<textarea class="json-textarea" disabled><?php echo h($json); ?></textarea>
													&nbsp;
												</td>
											</tr>

									</table>

							</div>
						</div>

				</div>

		</div>

		<?php if (!empty($audit['AuditDelta'])) { ?>
			<div class="panel panel-default">

				<!-- PANEL HEADER -->
					<div class="panel-heading">
						<h3>Propiedades modificadas</h3>
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
													<th><?php echo 'Propiedad'; ?></th>
													<th><?php echo 'Valor antiguo'; ?></th>
													<th><?php echo 'Valor nuevo'; ?></th>
												</tr>

											<!-- CAMPOS -->
												<?php
													foreach ($audit['AuditDelta'] as $auditDelta):
												?>

													<tr>

														<!-- PROPIEDAD -->
															<td>
																<?php echo h($auditDelta['property_name']); ?>
																&nbsp;
															</td>

														<!-- VALOR ANTIGUO -->
															<td>
																<?php echo h($auditDelta['old_value']); ?>
																&nbsp;
															</td>

														<!-- VALOR NUEVO -->
															<td>
																<?php echo h($auditDelta['new_value']); ?>
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