<?php
include_once './database_HW8F16.php';
session_start();
extract($_POST);
error_reporting(E_ALL);
ini_set('display_errors','1');
$usernameError = "";
$passwordError = "";
if(isset($_POST["submit"])){
  $conn=new mysqli($db_servername,$db_username,$db_password,$db_name,$db_port);
  if ($conn->connect_error){
    die("connect Error: ".mysqli_connect_error());
  }
  else{
      if(empty($_POST["username"])){
        $usernameError = "<span style = 'color :red;'> Please enter a valid valur for User Login field.</span><br>";
      }
      if(empty($_POST["password"])){
        $passwordError = "<span style = 'color :red;'> Please enter a valid valur for Password field.</span><br>";
      }
      if(!(empty($_POST["username"]) || empty($_POST["password"]))){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM tbl_accounts WHERE acc_login = '".$username."'";
        //$result = mysqli_query($conn, $sql);
        $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        if($result == false){
          $usernameError = "<span style = 'color :red;'> User Does not exist. Please check the login details and try again. </span> <br>";
        }
        else{
          if($result["acc_password"] != sha1($password)){
            $passwordError = "<span style='color:red;'>"."Password is incorrect: Please check the password and try again."."</span><br>";
          }
          else{
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            $_SESSION["name"] = $result["acc_name"];

            header("Location: ./calendar.php");
            exit();
          }
        }
      }
  }
}
/*
include_once "database_HW8F16.php";
$username = $_POST["username"];
$password = $_POST["password"];
if(isset($_POST["submit"])){
  session_start();
  if(empty ($username)){
    echo "<p style = 'color: red;'> Please Enter Username</p>";
  }
  if(empty ($password)){
    echo "<p style = 'color: red;'> Please Enter Password</p>";
  }

  $conn=new mysqli($db_servername,$db_username,$db_password,$db_name,$db_port);
  //$conn= mysqli_connect('egon.cs.umn.edu','C4131F16U35','3447','C4131F16U35','3307');

  // connect to db,
  if (mysqli_connect_errno()){//report the error
    die("Connection failed: " . $conn->connect_error);
  }


  //get da
  $qury = "SELECT * FROM tbl_accounts WHERE acc_login='".$username."'";
  //feedback an mysqli_result object

  $feedback = mysqli_query($conn, $query);
}

  //check if returns nothing
  if(mysqli_num_rows($feedback) == 0){
    $_SESSION['username_Invalid'] = "Usename is incorrect. Please check and try again";
    echo '<span style="color:red;">'.$_SESSION['usernameEr'].'</span><br>';
  }


  //turn the feedbackinto an array and check if the password fits
  $feedbackarray = mysqli_fetch_assoc($feedback);
  if(sha1($password)!= $feedbackarray[$acc_password]){
    $_SESSION['password_Invalid'] = "password is incorrect. Please check and try again";
    header("Location: ./login.php");
    exit();
  }

  $_SESSION['username'] = $username;
  echo $username;
  $_SESSION['password'] = $password;
  header("Location: ./calendar.php");
  exit();
  */
?>
<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <div id = "login">
      <h2> Login Page </h2>
      <?php
      echo $usernameError;
      echo $passwordError;
      ?>
      <p> please enter your user's login name and password. Both values are case senstive. </p>
      <form  method="post">
        <table>
          <tr>
            <td>Login:</td>
            <td><input type="text" name="username"></td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input type="password" name="password"></td>
          </tr>
          <tr>
  					<td><input type="Submit" name="submit" value="Submit"></td>
  				</tr>
        </table>
      </form>
  </div>
  </body>

</html>
