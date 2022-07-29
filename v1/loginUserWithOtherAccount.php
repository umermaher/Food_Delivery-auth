<?php

require_once '../includes/DbOperations.php';

$response = array();
$keys = array('name','email','photoUrl','phoneNo','address');
if($_SERVER['REQUEST_METHOD']=='POST'){
	$db=new DbOperations();
		if($db->isUserExist('tbl_user_other_accounts',$_POST['email'])){
			$user = $db->getUserByEmail('tbl_user_other_accounts',$_POST['email']);
    			if($user!=null){
					foreach($keys as $key){
						if(isset($user[$key])){
							$response[$key]=$user[$key];	
						}
					}
				}
		}else{
			$result= $db->createUserWithOtherAccount(
		            $_POST['name'],
                    $_POST['email'],
					$_POST['photoUrl'], 			
					$_POST['phoneNo'],
					$_POST['address']
					);
	        if($result!=null){
				foreach($keys as $key){
					if(isset($result[$key])){
						$response[$key]=$result[$key];	
					}
				}
			}
		}
}else{
	$response['error'] = true;
	$response['message']="Invalid Request";	
}
echo json_encode($response);