<?php
	$template = array(
		'model' => 'Display',
		'title' => 'pantalla',
		'id'  	=> 'pantalla_id',
	);

	echo $this->element('templates/edit', array('template' => $template));
?>