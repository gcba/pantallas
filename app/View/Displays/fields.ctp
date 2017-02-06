<script type="text/javascript">
	var ACTION_TYPE = "<?php echo $this->request->params['action'] ?>";
</script>

<?php
	$this->Html->script('//servicios.usig.buenosaires.gob.ar/usig-js/3.1/usig.AutoCompleterFull.min.js', array('inline' => false));
	$this->Html->script('//servicios.usig.buenosaires.gob.ar/usig-js/3.1/usig.MapaEstatico.min.js', array('inline' => false));
	$this->Html->script('//servicios.usig.buenosaires.gob.ar/usig-js/3.1/usig.MapaInteractivo.min.js', array('inline' => false));
	$this->Html->script('displays', array('inline' => false));
?>

<!-- NOMBRE -->
	<div class="form-group">
		<?php echo $this->Form->label('nombre', 'Nombre'); ?>
		<?php echo $this->Form->input('nombre', array('class' => 'form-control')); ?>
	</div>

<!-- DIRECCION -->
	<div class="form-group">
		<?php echo $this->Form->label('direccion', 'Dirección'); ?>
		<?php echo $this->Form->input('direccion', array('class' => 'form-control')); ?>
	</div>

<!-- MAPA -->
	<div class="form-group">
		<div id="map-container"></div>
	</div>

<!-- OTROS DATOS -->
	<div class="row">
		<div class="form-group col-md-6 col-sm-12 col-xs-12">
			<div class="row">
			
				<!-- LATITUD -->
					<div class="form-group col-md-12 col-sm-12 col-xs-12">
						<?php echo $this->Form->label('lat', 'Latitud'); ?>
						<?php echo $this->Form->input('lat', array('class' => 'form-control', 'readonly' => 'true')); ?>
					</div>

				<!-- LONGITUD -->
					<div class="form-group col-md-12 col-sm-12 col-xs-12">
						<?php echo $this->Form->label('lng', 'Longitud'); ?>
						<?php echo $this->Form->input('lng', array('class' => 'form-control', 'readonly' => 'true')); ?>
					</div>

			</div>
		</div>

		<div class="form-group col-md-6 col-sm-12 col-xs-12">
			<div class="row">

				<!-- BARRIO -->
					<div class="form-group col-md-12 col-sm-12 col-xs-12">
						<?php echo $this->Form->label('barrio', 'Barrio'); ?>
						<?php echo $this->Form->input('barrio', array('class' => 'form-control', 'readonly' => 'true')); ?>
					</div>

				<!-- COMUNA -->
					<div class="form-group col-md-12 col-sm-12 col-xs-12">
						<?php echo $this->Form->label('comuna', 'Comuna'); ?>
						<?php echo $this->Form->input('comuna', array('class' => 'form-control', 'readonly' => 'true')); ?>
					</div>

			</div>
		</div>
	</div>

<!-- ORIENTACIÓN -->
	<div class="form-group">
		<?php echo $this->Form->label('orientacion', 'Orientación'); ?>
		<?php $orientacion = array('VERTICAL' => 'VERTICAL', 'HORIZONTAL' => 'HORIZONTAL'); ?>
		<?php echo $this->Form->input('orientacion', array('class' => 'form-control', 'options' => $orientacion)); ?>
	</div>

<!-- CONTENIDOS -->
	<div class="form-group">
		<?php echo $this->Form->label('contenidos', 'Contenidos'); ?>
		<?php echo $this->Chosen->select(
			'Content',
			$content,
			array(
				'data-placeholder' => 'Seleccione los contenidos...',
				'data-no_results_text' => 'No hay coincidencias para',
				'multiple' => true,
				'class' => 'form-control',
			) 
		); ?>
		<?php
			if( array_key_exists('Content', $this->validationErrors['Display']) && count($this->validationErrors['Display']['Content']) > 0 )
			{
				echo '<div class="error-message">' . $this->validationErrors['Display']['Content'][0] . '</div>';
			}
		?>
	</div>

<!-- TAGS -->
	<div class="form-group">
		<?php echo $this->Form->label('tags', 'Tags'); ?>
		<?php echo $this->Chosen->select(
			'Tag',
			$tags,
			array(
				'data-placeholder' => 'Seleccione los tags...',
				'data-no_results_text' => 'No hay coincidencias para',
				'multiple' => true,
				'class' => 'form-control',
			)
		); ?>
		<?php
			if( array_key_exists('Tag', $this->validationErrors['Display']) && count($this->validationErrors['Display']['Tag']) > 0 )
			{
				echo '<div class="error-message">' . $this->validationErrors['Display']['Tag'][0] . '</div>';
			}
		?>
	</div>

<!-- ENVIO ALERTA -->
	<div class="checkbox">
		<label>
			<?php echo $this->Form->checkbox('envio_alerta'); ?>
			Envío alerta
		</label>
	</div>