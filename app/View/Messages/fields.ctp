<!-- TÍTULO -->
	<div class="form-group">
		<?php echo $this->Form->label('titulo', 'Título'); ?>
		<?php echo $this->Form->input('titulo', array('class' => 'form-control')); ?>
	</div>

<!-- MENSAJE -->
	<div class="form-group">
		<?php echo $this->Form->label('mensaje', 'Mensaje'); ?>
		<?php echo $this->Form->input('mensaje', array('class' => 'form-control')); ?>
	</div>

<!-- ACTIVO -->
	<div class="checkbox">
		<label>
			<?php echo $this->Form->checkbox('activo'); ?>
			Activo
		</label>
	</div>