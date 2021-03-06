<?php
	$controller = $this->request->params['controller'];
	$action 	= $this->request->params['action'];

	$title  	= $template['title'];
	$submit 	= 'Crear';

	$this->set('title_for_layout', $title);
?>

<!-- ADD -->
	<div id="<?php echo $controller . '-' . $action; ?>" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1><?php echo $title; ?></h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-6 col-sm-12 col-xs-12">
					<?php echo $this->Form->create($template['model'], array('inputDefaults' => array('label' => false), 'class' => 'form form-horizontal', 'id' => 'Add' . $template['model'] . 'Form')); ?>

					<!-- CAMPOS -->
						<fieldset>
							<?php include (dirname(__FILE__) . '/../../../../' . $template['model'] . 's/fields.ctp'); ?>
						</fieldset>
					
					<!-- ACCIONES -->
						<div class="row <?php echo $action; ?>-actions">
							<div class="col-md-6 col-sm-6 col-xs-6">

								<!-- ENVIAR -->
									<?php echo $this->Form->button(
										$submit,
										array(
											'type'  => 'submit',
											'class' => 'btn btn-large btn-primary',
										)
									); ?>
								
								<!-- CANCELAR -->
									<?php echo $this->Html->link(
										'Cancelar',
										array(
											'controller' => $controller,
											'action'	 => 'index',
										),
										array(
											'class' => 'btn btn-large btn-default',
										)
									); ?>

							</div>
						</div>
					
					<?php echo $this->Form->end(); ?>
				</div>

		</div>
	</div>