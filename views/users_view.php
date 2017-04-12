<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Admin Page</title>
	<link href="style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div id="user">
		<p>Welcome <?php echo $name; ?></p>

	</div>
	<div class="nav_bar">
		<nav>
			<input type="button" onclick="location.href='./login.php';" value="Log Out"/>
			<input type="button" onclick="location.href='./calendar.php';" value="My Calendar" />
			<input type="button" onclick="location.href='./input.php';" value="Form Input" />
			<input type="button" onclick="location.href='./admin.php';" value="Admin" />
			<p>This page is protected from the public, and you can see a list of all users defined in the database.</p>
		</nav>
	</div>
	<br>

	<div>
		<h1>List of Users</h1>
		<p color="red"><?php echo $msg; ?></p>
		<table style ="margin-left: auto; margin-right: auto; width: 70%" >
			<tr>
				<td>ID</td>
				<td>Name</td>
				<td>Login</td>
				<td>New Password</td>
				<td>Action</td>
			</tr>
				<?php echo $out; ?>

		</table>
	</div>
	<div >
		<h2>Add New User</h2>
		<form action="./admin.php" method="post">
			<label >Name: <input type="text" name="Name"></label>
			<label >Login: <input type="text" name="Login"></label>
			<label >Password: <input type="password" name="Password"></label>
			<input type="submit" name="action" value="add">
		</form>
	</div>
</body>
</html>
