<?php
	$template = array(
		'model' => 'Message',
		'title' => 'Nuevo mensaje',
	);

	echo $this->element('templates/add', array('template' => $template));
?>