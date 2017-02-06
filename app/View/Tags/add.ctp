<?php
	$template = array(
		'model' => 'Tag',
		'title' => 'Nuevo tag',
	);

	echo $this->element('templates/add', array('template' => $template));
?>