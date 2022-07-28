<?php

require_once '../includes/DbOperations.php';
$response = array();
$keys = array('name','email','photoUrl','phoneNo','address');
if($_SERVER['REQUEST_METHOD']=='POST'){  
    $db = new DbOperations();
	if($db->loginUser($_POST['email'], $_POST['password'])){
			$response['error'] = false;
		    $response['message']="Login successful";
	}else{
		if($db->isUserExist('tbl_user',$_POST['email'])){
			$response['error'] = true;
		    $response['message']="Invalid password!";
		}else{
			$response['error'] = true;
		    $response['message']="Invalid credentials!";
		}
	}
}else{
	$response['error'] = true;
	$response['message']="Invalid Request";	
}
echo json_encode($response);