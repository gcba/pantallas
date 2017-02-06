<script type="text/javascript">
	var ACTION_TYPE		= "<?php echo $this->request->params['action'] ?>";
	var ORIGIN_SETTINGS = <?php echo json_encode($originSettings) ?>;
</script>

<?php $this->Html->script('contents', array('inline' => false)); ?>

<!-- NOMBRE -->
	<div class="form-group">
		<?php echo $this->Form->label('nombre', 'Nombre'); ?>
		<?php echo $this->Form->input('nombre', array('class' => 'form-control')); ?>
	</div>

<!-- DESCRIPCIÓN -->
	<div class="form-group">
		<?php echo $this->Form->label('descripcion', 'Descripción'); ?>
		<?php echo $this->Form->input('descripcion', array('class' => 'form-control')); ?>
	</div>


<!-- SEPARADOR -->
	<div class="separador"></div>


<!-- ORIGEN -->
	<div class="form-group" id="OriginGroup">
		<?php echo $this->Form->label('origen_id', 'Origen'); ?>
		<?php echo $this->Form->select('origen_id', $origins, array('class' => 'form-control')); ?>
		<?php
			if( array_key_exists('origen_id', $this->validationErrors['Content']) && count($this->validationErrors['Content']['origen_id']) > 0 )
			{
				echo '<div class="error-message">' . $this->validationErrors['Content']['origen_id'][0] . '</div>';
			}
		?>
	</div>

<!-- SETTINGS -->
	<div class="form-group" id="SettingsFields"></div>

<!-- HIDDEN -->
		<?php echo $this->Form->hidden('settings', array('id' => 'ContentSettings')); ?>