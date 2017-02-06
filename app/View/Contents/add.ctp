<?php
	$template = array(
		'model' => 'Content',
		'title' => 'Nuevo contenido',
	);

	echo $this->element('templates/add', array('template' => $template));
?>