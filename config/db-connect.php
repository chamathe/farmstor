<?php 

	// connect to the database
	$conn = mysqli_connect('localhost', 'chamath', 'welcome1', 'farmstore');

	// check connection
	if(!$conn){
		echo 'Connection error: '. mysqli_connect_error();
	}

?>