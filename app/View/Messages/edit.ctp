<?php
	$template = array(
		'model' => 'Message',
		'title' => 'mensaje',
		'id'  	=> 'mensaje_id',
	);

	echo $this->element('templates/edit', array('template' => $template));
?>