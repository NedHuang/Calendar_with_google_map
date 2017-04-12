<!DOCTYPE html>
<html lang="en-US">
<body>
<div id="error">
	<?php echo $msg; ?>
	</div>
	<h1>Login Page</h1>
	<form method="post" action="login.php">
		<p>
			<label> Login:
				<input name="login" type="text" >
			</label>
			<br>
			<label> Password:
				<input name="password" type="password">
			</label>
			<br>
		</p>
		<p>
			<input type="submit" name="Submit" value="Submit">
		</p>
	</form>
</body>
</html>
