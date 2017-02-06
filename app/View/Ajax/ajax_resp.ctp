<?php 
if(isset($cb)){
	echo $cb .'(';	
}?>

<?php echo json_encode($data); ?>

<?php 
if(isset($cb)){
	echo ')';	
}?>