<?php

function edit($data)
{
	$out="";
	$out.="<form method='post' action='admin.php'>";
	$out.="<tr>";
	$out.="<td><input type='text' name='id' value='".$data['acc_id']."' readonly></td>";
	$out.="<td><input type='text' name='Name' value='".$data['acc_name']."'></td>";
	$out.="<td><input type='text' name='Login' value='".$data['acc_login']."'></td>";
	$out.="<td><input type='password' name='Newpassword'></td>";
	$out.="<td><input type='submit' name='action' value='update'>";
	$out.="<input type='submit' name='action' value='cancel'></form></td></tr>";
	return $out;
}

function show($data)
{
	$out="";
	$out.="<form method='post' action='admin.php'><tr>";
	$out.="<td><input type='text' name='id' value='".$data['acc_id']."' readonly/></td>"."<td>".$data['acc_name']."</td>"."<td>".$data['acc_login']."</td><td></td>";
	$out.="<td><input type='submit' name='action' value='edit'>";
	$out.="<input type='submit' name='action' value='delete'></form></td></tr>";
	return $out;
}

function append($output)
{
	$out="";
	foreach ($output as $o)
	{
		$out.=$o;
	}
	return $out;
}
session_start();
if (!isset($_SESSION['name']))
{
	header("Location: ./login.php");
	exit();
}
else
{
	include "./models/account.php";
	$name=$_SESSION['name'];
	if (!isset($db))
	{
		$db = new accountDB();
	}

	if (isset($_SESSION['output']))
	{
		$output=$_SESSION['output'];
	}

	$table="";
	$msg="";
	if(isset($_POST['id']))
	{
		$id=$_POST['id'];
	}
	else
	{
		$id=0;
	}
	if (isset($_POST['action']))
		$action=$_POST['action'];
	else
		$action="start";
	//echo $action;
	switch($action)
	{
		case "start":
			$users=$db->getusers();
			foreach ($users as $user)
			{
				$output[$user['acc_id']]=show($user);
			}
			break;
		case "cancel":
			$output[$id]=show($db->getuserbyid($id));
			break;
		case "delete":
			if ($db->del($id)) $msg="Account Deleted Successfully";
			else $msg="Failed to Delete";
			unset($output[$id]);
			break;
		case "update":
			$name=$_POST['Name'];
			$login=$_POST['Login'];
			$password=$_POST['Newpassword'];

			if ($db->uniquelogin($login))
			{
				$db->update($id,$name,$login,$password);
				$msg="Account Updated Successfully";
			}
			else
			{
				$msg="Failed to Update";
			}
			$output[$id]=show($db->getuserbyid($id));
			break;
		case "edit":
			$output[$id]=edit($db->getuserbyid($id));
			break;
		case "add":
			$name=$_POST['Name'];
			$login=$_POST['Login'];
			$password=$_POST['Password'];
			if ($db->uniquelogin($login))
			{
				$db->add($name,$login,$password);
				$msg="Account Added Successfully";
				$user=$db->getuserbylogin($login);
				$output[$user['acc_id']]=show($user);
			}
			else
			{
				$msg="Failed to Add";
			}
			break;
	}
	$out=append($output);

	$_SESSION['output']=$output;

	//echo $msg;
	//echo $out;
	//echo "test";
	include './views/users_view.php';
}
?>
