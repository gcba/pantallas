<?php
	$template = array(
		'model' => 'User',
		'title' => 'Nuevo usuario',
	);

	echo $this->element('templates/add', array('template' => $template));
?>