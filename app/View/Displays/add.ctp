<?php
	$template = array(
		'model' => 'Display',
		'title' => 'Nueva pantalla',
	);

	echo $this->element('templates/add', array('template' => $template));
?>