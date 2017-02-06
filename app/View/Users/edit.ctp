<?php
	$template = array(
		'model' => 'User',
		'title' => 'usuario',
		'id'  	=> 'user_id',
	);

	echo $this->element('templates/edit', array('template' => $template));
?>