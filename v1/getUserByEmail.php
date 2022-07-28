<?php

require_once '../includes/DbOperations.php';
$response = array();
$keys = array('name','email','photoUrl','phoneNo','address');
if($_SERVER['REQUEST_METHOD']=='POST'){  
    $db = new DbOperations();
	$user = $db->getUserByEmail($_POST['tableName'],$_POST['email']);
	if($user!=null){
		foreach($keys as $key){
			if(isset($user[$key])){
				$response[$key]=$user[$key];	
			}
		}
	}
}else{
	$response['error'] = true;
	$response['message']="Invalid Request";	
}
echo json_encode($response);