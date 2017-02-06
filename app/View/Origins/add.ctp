<?php
	$template = array(
		'model' => 'Origin',
		'title' => 'Nuevo origen',
	);

	echo $this->element('templates/add', array('template' => $template));
?>