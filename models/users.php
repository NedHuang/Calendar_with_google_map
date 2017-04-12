<?php
	class userDB
	{
		private $con;

		public function __construct()
		{
			$this->con=new mysqli('egon.cs.umn.edu','C4131F16U35',3447,'C4131F16U35',3307);
			if ($this->con->connect_error){
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
		}

		public function checklogin($login,$password)
		{
			$query="SELECT * FROM tbl_accounts WHERE acc_login='".$login."'";
			$query_result=mysqli_fetch_assoc(mysqli_query($this->con,$query));
			return $query_result;
		}
	}
?>
