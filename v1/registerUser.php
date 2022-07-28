<?php

require_once '../includes/DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
//	if(
//	    isset($_POST['name']) and
	//	    isset($_POST['email']) and
		//        isset($_POST['photourl']) and
		  //          isset($_POST['phoneno']) and
		    //            isset($_POST['address']) and
		      //              isset($POST['password'] )
	//){
		//operate the data further
		$db=new DbOperations();
		$result= $db->createUser(
		            $_POST['name'],
                    $_POST['email'],
					$_POST['photoUrl'], 			
					$_POST['phoneNo'],
					$_POST['address'],
					$_POST['password']
					);
		
		if($result==0){
			$response['error'] = true;
			$response['message']="User with this email already exist!";
		}
		elseif($result==1){
			   $response['error'] = false;
			   $response['message'] = "User registered successfully";
		}elseif($result==2){
			   $response['error'] = true;
			   $response['message'] = "Some error occurred please try again";	   
		   }
	//}else{
		//$response['error']=true;
		//$response['message']="Required fields are missing";

	
	
}else{
	$response['error'] = true;
	$response['message']="Invalid Request";
}	
echo json_encode($response);