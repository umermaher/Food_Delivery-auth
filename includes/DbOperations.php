<?php
    class DbOperations{
		private $con;
		function __construct(){
			require_once dirname(__FILE__).'/DbConnect.php';
			$db = new DbConnect();
			
			$this->con=$db->connect(); 
		}
		
		/**CRUD -> C -> Create**/
		public function createUser($name,$email,$photourl,$phoneno,$address,$pass){
			if($this->isUserExist('tbl_user',$email)){
				return 0;
			}
			$password=md5($pass);
			$stmt = $this->con->prepare("INSERT INTO `tbl_user` (`id`, `name`, `email`, `photoUrl`, `phoneNo`, `address`,
			`password`) VALUES (NULL, ?, ?, ?, ?, ?, ?);");
			
			$stmt->bind_param("ssssss",$name,$email,$photourl,$phoneno,$address,$password);
		    if($stmt->execute()){
				return 1;
			}else{
				return 2;
			}
		}
		
		public function loginUser($email,$pass){
			$password = md5($pass);
			$stmt = $this->con->prepare("select id from `tbl_user` where email=? AND password=?;");
			$stmt->bind_param("ss",$email,$password);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows()>0;
		}
		
		public function getUserByEmail($tableName,$email){
			$stmt = $this->con->prepare("Select name,email,photoUrl,phoneNo,address from $tableName where email=?;");
			$stmt->bind_param("s",$email);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}
		//facebook and google
		public function createUserWithOtherAccount($name,$email,$photourl,$phoneno,$address){
			$stmt=$this->con->prepare("INSERT INTO `tbl_user_other_accounts` (`id`, `name`, `email`, `photoUrl`, `phoneNo`, `address`) VALUES (NULL, ?, ?, ?, ?, ?);");
			$stmt->bind_param("sssss",$name,$email,$photourl,$phoneno,$address);
			if($stmt->execute()){
				return $this->getUserByEmail('tbl_user_other_accounts',$email);
			}else{
				return null;
			}
		}
		
		public function isEmailWithPasswordExist($email,$phoneNo){
			$stmt=$this->con->prepare("select id from tbl_user where email=? AND phoneNo=?;");
			$stmt->bind_param("ss",$email,$phoneNo);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows()>0;
		}
		
		public function changePassword($email,$pass){
			$password=md5($pass);
			$stmt=$this->con->prepare("UPDATE `tbl_user` SET password = ? WHERE email=?;");
			$stmt->bind_param("ss",$password,$email);
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}
		
		public function isUserExist($tableName,$email){
			$stmt = $this->con->prepare("Select id from $tableName where email=?;");
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows()>0;
		}
	}