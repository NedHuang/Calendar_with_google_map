<!DOCTYPE html>
<html>
<body>
<div>
<?php
	session_start();
	session_unset();
	header("Location: ./login.php");
?>
</div>
</body>
</html>
