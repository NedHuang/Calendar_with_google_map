<?php

	class accountDB{
		private $con;

		public function __construct() {
			$this->con=new mysqli('egon.cs.umn.edu','C4131F16U35',3447,'C4131F16U35',3307);
			if ($this->con->connect_error){
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
		}

		public function getusers()
		{
			$query= "SELECT * FROM tbl_accounts";
			$result = mysqli_query($this->con,$query);
			$test=mysqli_fetch_assoc($result);
			$users = array();
			while ($user = mysqli_fetch_assoc($result)) {
				array_push($users, $user);
			}
			return $users;
		}

		public function getuserbyid($id)
		{
			$query="SELECT * FROM tbl_accounts where acc_id='".$id."'";
			$result = mysqli_query($this->con,$query);
			$user = mysqli_fetch_assoc($result);
			return $user;
		}

		public function getuserbylogin($login)
		{
			$query="SELECT * FROM tbl_accounts where acc_login='".$login."'";
			$result = mysqli_query($this->con,$query);
			$user = mysqli_fetch_assoc($result);
			return $user;
		}

		public function uniquelogin($login)
		{
			$query="SELECT * FROM tbl_accounts WHERE acc_login='".$login."'";
			$result = mysqli_query($this->con, $query);
			if (mysqli_num_rows($result) != 0) {
				return false;
			}
			return true;
		}

		public function update($id,$name,$login,$password)
		{
			$query="UPDATE tbl_accounts SET acc_name='".$name."', acc_login='".$login."', acc_password='".sha1($password)."' WHERE acc_id='".$id."'";
			mysqli_query($this->con, $query);
		}

		public function del($id) {
			$query="DELETE FROM tbl_accounts WHERE acc_id='".$id."'";
			mysqli_query($this->con, $query);
			return true;
		}

		public function add($name,$login,$password) {
			$query = "INSERT INTO tbl_accounts (acc_name, acc_login, acc_password) VALUES ('".$name."', '".$login."', '".sha1($password)."');";
			mysqli_query($this->con, $query);
		}
	}
?>
