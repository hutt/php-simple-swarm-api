<?php
require("functions.php");
if(@$_GET['fetch'] !== ''){
	//get arguments
	switch($_GET['fetch']){
		case 'user':
			$data = getData('user');
			break;

		case 'checkins':
			$data = getData('checkins');
			break;
	}

	// Read out n checkins if count is defined. Otherwise fetch the last one.
	$count = (isset($_GET['count']) ? $_GET['count'] : 1);

	// work with the data

	//decode from json to php object
	$data_php = json_decode($data);

	//how many checkins?
	if($_GET['fetch'] == "checkins"){
		for ($i=0; $i < $count; $i++) { 
			$swarmData[$i] = $data_php[$i];
		}
		//Encode to JSON
		$return = json_encode($swarmData);
	}else{
		//get first object.
		$return = $data;
	}

	// Return data
	header("HTTP/1.1 200 OK");
	header('Content-Type: application/json');
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header('Life: 1 falsches.');

	echo $return;
}
?>