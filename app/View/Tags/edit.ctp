<?php
	$template = array(
		'model' => 'Tag',
		'title' => 'tag',
		'id'  	=> 'tag_id',
	);

	echo $this->element('templates/edit', array('template' => $template));
?>