<script type="text/javascript">
	var ACTION_TYPE = "<?php echo $this->request->params['action'] ?>";
</script>

<?php
	$this->Html->css('jsoneditor.min', null, array('inline' => false));
	$this->Html->script('libs/jsoneditor.min', array('inline' => false));
	$this->Html->script('origins', array('inline' => false));
?>

<!-- NOMBRE -->
	<div class="form-group">
		<?php echo $this->Form->label('nombre', 'Nombre'); ?>
		<?php echo $this->Form->input('nombre', array('class' => 'form-control')); ?>
	</div>

<!-- SLUG -->
	<div class="form-group">
		<?php echo $this->Form->label('slug', 'Slug'); ?>
		<?php echo $this->Form->input('slug', array('class' => 'form-control')); ?>
		<p>
			<small>
				<span>El <strong>slug</strong> hace referencia al nombre de la carpeta donde va a buscar el origen. Utilizar un nombre con caracteres alfanuméricos, sin símbolos y sin espacios.</span>
			</small>
		</p>
	</div>

<!-- DESCRIPCIÓN -->
	<div class="form-group">
		<?php echo $this->Form->label('descripcion', 'Descripción'); ?>
		<?php echo $this->Form->input('descripcion', array('class' => 'form-control')); ?>
	</div>


<!-- SEPARADOR -->
	<div class="separador"></div>


<!-- CONFIGURACIONES DEL ORIGEN -->
	<div class="form-group">
		<?php echo $this->Form->label('settings', 'Configuraciones del ORIGEN');?>
		<?php echo $this->Form->hidden('settings', array('id' => 'OriginSettings')); ?>
		<div id="OriginSettingsEditor" class="json-textarea"></div>
	</div>
	
<!-- CRON -->
	<div class="checkbox">
		<label>
			<?php echo $this->Form->checkbox('usa_cron'); ?>
			Requiere CRON
		</label>
	</div>