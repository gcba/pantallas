<?php
	$template = array(
		'model' => 'Content',
		'title' => 'contenido',
		'id'  	=> 'contenido_id',
	);

	echo $this->element('templates/edit', array('template' => $template));
?>