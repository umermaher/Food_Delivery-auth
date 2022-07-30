<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	$db=new DbOperations();
	if($db->changePassword($_POST['email'], $_POST['password'])){
		$response['error'] = false;
		$response['message']="Changed Successfully";
	}else{
		$response['error'] = true;
		$response['message']="Some error occurred please try again!";
	}
}else{
	$response['error'] = true;
	$response['message']="Invalid Request";
}
echo json_encode($response);