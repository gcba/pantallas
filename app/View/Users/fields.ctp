<script type="text/javascript">
	var ACTION_TYPE = "<?php echo $this->request->params['action'] ?>";
</script>

<?php $this->Html->script('users', array('inline' => false)); ?>

<?php
	$login = ($this->request->params['action'] == 'login') ? true : false;
?>


<!-- EMAIL -->
	<div class="form-group">
		<?php echo $this->Form->label('mail', 'Correo electrónico'); ?>
		<?php echo $this->Form->input('mail', array('class' => 'form-control', 'type' => 'email')); ?>
	</div>

<!-- CONTRASEÑA -->
	<div class="form-group">
		<?php echo $this->Form->label('password', 'Contraseña'); ?>
		<?php echo $this->Form->input('password', array('class' => 'form-control', 'type' => 'password')); ?>
	</div>


<?php if(!$login) { ?>

	<!-- SEPARADOR -->
		<div class="separador"></div>

	<!-- USUARIO -->
		<div class="form-group">
			<?php echo $this->Form->label('user', 'Nombre'); ?>
			<?php echo $this->Form->input('user', array('class' => 'form-control')); ?>
		</div>

	<!-- ROL -->
		<div class="form-group">
			<?php echo $this->Form->label('role', 'Rol'); ?>
			<?php echo $this->Form->select(
				'role',
				$roles,
				array('class' => 'form-control')
			); ?>
			<?php
				if( array_key_exists('role', $this->validationErrors['User']) && count($this->validationErrors['User']['role']) > 0 )
				{
					echo '<div class="error-message">' . $this->validationErrors['User']['role'][0] . '</div>';
				}
			?>
		</div>

	<!-- TAGS -->
		<div class="form-group" id="UserTagGroup">
			<?php echo $this->Form->label('tags', 'Tags'); ?>
			<?php echo $this->Chosen->select(
				'Tag',
				$tags,
				array(
					'data-placeholder' => 'Seleccione los tags...',
					'data-no_results_text' => 'No hay coincidencias para',
					'multiple' => true,
					'class' => 'form-control'
				) 
			);?>
			<?php
				if( array_key_exists('Tag', $this->validationErrors['User']) && count($this->validationErrors['User']['Tag']) > 0 )
				{
					echo '<div class="error-message">' . $this->validationErrors['User']['Tag'][0] . '</div>';
				}
			?>
		</div>
		
<?php } ?>