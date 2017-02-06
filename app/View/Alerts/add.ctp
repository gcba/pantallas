<?php
	$template = array(
		'model' => 'Alert',
		'title' => 'Nueva alerta',
	);

	echo $this->element('templates/add', array('template' => $template));
?>