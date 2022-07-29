<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db=new DbOperations();
		if($db->isEmailWithPasswordExist($_POST['email'], $_POST['phoneNo'])){
			$response['error'] = false;
		    $response['message']="User exist!";
	}else{
		$response['error'] = true;
	    $response['message']="User with this info does not exist!";
	}
}
else{
	$response['error'] = true;
	$response['message']="Invalid Request";
}
echo json_encode($response);