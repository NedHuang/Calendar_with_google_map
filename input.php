<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <title>Form Input</title>
	    <link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<?php
		 	session_start();
			if(!isset($_SESSION["name"])){
				header("Location: ./login.php");
				exit();
			}
			else {
				$name = $_SESSION["name"];
			}
		 ?>
		<div>
			<h1>Calendar Input</h1>
				<p>Welcome <?php echo $name; ?></p>
		    <nav>
					<input type="button" onclick="location.href='./login.php';" value="Log Out"/>
					<input type="button" onclick="location.href='./calendar.php';" value="My Calendar" />
					<input type="button" onclick="location.href='./input.php';" value="Form Input" />
					<input type="button" onclick="location.href='./admin.php';" value="Admin" />
		    </nav>
		</div>
		<br>
<?php
	if ($_POST['submit'] == "Submit"){
		$eventname = $_POST['eventname'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		$location = $_POST['location'];
		$day = $_POST['day'];
		$json_data;
		$object;
		$myfile = fopen($name.".txt", "a") or die("unable to openfile");
		chmod($name.".txt", 0666);

		if(empty ($eventname)){
			echo "<p style = 'color: blue;'> Please provide a value for Event Name</p>";
		}
		if(empty ($starttime)){
			echo "<p style = 'color: blue;'> Please provide a value for Start Time </p>";
		}
		if(empty ($endtime)){
			echo "<p style = 'color: blue;'> Please provide a value for End Time</p>";
		}
		if(empty ($location)){
			echo "<p style = 'color: blue;'> Please provide a value for Location</p>";
		}
		if(!( (empty($eventname)) ||
					(empty($starttime)) ||
					(empty($endtime)) ||
					(empty($location)) ||
					(empty($day)))){
			$json_data = array(
												"eventname" => $eventname,
												"starttime" => $starttime,
												"endtime"=> $endtime,
												"location" => $location,
												"day" => $day,
											);
			$object = json_encode($json_data);//json representation of the event
			fwrite($myfile, $object."\n");
			fclose($myfile);
			header("Location: ./calendar.php");
		}
	}
	if($_POST['reset'] == "Reset"){
		$myfile = fopen($name.".txt", "w") or die("unable to openfile");
		fclose($myfile);
		chmod($name.".txt", 0666);
		header("Location: ./calendar.php");
	}
?>
		<br>
		<div>
		    <form action="input.php" method="post">
			    <table>
			    	<tr>
			    		<td class="l"><p>Event Name:</p></td>
			    		<td class="l"><input type="text" name="eventname"></td>
			    	</tr>
			    	<tr>
			    		<td class="l"><p>Start Time:</p></td>
			    		<td class="l"><input type="time" name="starttime"></td>
			    	</tr>
			    	<tr>
			    		<td class="l"><p>End Time:</p></td>
			    		<td class="l"><input type="time" name="endtime"></td>
			    	</tr>
			    	<tr>
			    		<td class="l"><p>Location:</p></td>
			    		<td class="l"><input type="text" name="location"></td>
					</tr>
			    	<tr>
				    	<td class="l"><p>Day of the Week:</p></td>
				    	<td class="l">
					    	<select name="day">
					    		<option value="Monday" > Mon</option>
					    		<option value="Tuesday"> Tue</option>
					    		<option value="Wednesday"> Wed</option>
					    		<option value="Thursday"> Thu</option>
					    		<option value="Friday"> Fri</option>
					    	</select>
					    </td>
			    	</tr>
			    </table>
          <input type="submit" name="submit" value = "Submit">
          <input type="submit" name="reset" value = "Reset">
		    </form>
		    <footer>This page has been tested in Chrome, Internet Explorer and Microsoft Edge.</footer>
		</div>
	</body>
</html>
