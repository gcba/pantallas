<!-- TÍTULO -->
	<div class="form-group">
		<?php echo $this->Form->label('titulo', 'Título'); ?>
		<?php echo $this->Form->input('titulo', array('class' => 'form-control')); ?>
	</div>

<!-- SUBTÍTULO -->
	<div class="form-group">
		<?php echo $this->Form->label('subtitulo', 'Subtítulo'); ?>
		<?php echo $this->Form->input('subtitulo', array('class' => 'form-control')); ?>
	</div>

<!-- DESDE -->
	<div class="form-group" style="display: none;">
		<?php echo $this->Form->hidden('fecha_desde'); ?>
	</div>

<!-- HASTA -->
	<div class="form-group" style="display: none;">
		<?php echo $this->Form->hidden('fecha_hasta'); ?>
	</div>

<!-- ÍCONO -->
	<div class="form-group">
		<?php echo $this->Form->label('icono', 'Ícono'); ?>
		<?php echo $this->Form->input('icono', array('class' => 'form-control')); ?>
	</div>

<!-- COLOR -->
	<div class="form-group">
		<?php echo $this->Form->label('color', 'Color'); ?>
		<?php echo $this->Form->input('color', array('class' => 'form-control')); ?>
	</div>

<!-- ACTIVO -->
	<div class="checkbox">
		<label>
			<?php echo $this->Form->checkbox('activo'); ?>
			Activa
		</label>
	</div>