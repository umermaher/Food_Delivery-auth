<?php

require_once '../includes/DbOperations.php';
$response = array();
if($_SERVER['REQUEST_METHOD']=='POST'){
	
	$db=new DbOperations();
	if($db->isUserExist($_POST['email'])){
		$response['error'] = true;
		$response['message']="User with this email already exist!";
	}else{
		$response['error'] = false;
		$response['message']="New User";
	}
	
}else{
	$response['error'] = true;
	$response['message']="Invalid Request";
}
echo json_encode($response);