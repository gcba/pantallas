<?php
	$template = array(
		'model' => 'Alert',
		'title' => 'alerta',
		'id'  	=> 'alerta_id',
	);

	echo $this->element('templates/edit', array('template' => $template));
?>