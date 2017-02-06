<?php
	$template = array(
		'model' => 'Origin',
		'title' => 'origen',
		'id'  	=> 'origen_id',
	);

	echo $this->element('templates/edit', array('template' => $template));
?>