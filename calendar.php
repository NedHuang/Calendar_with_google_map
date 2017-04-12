<!DOCTYPE html>
<html>
  	<head>
   		<meta charset="UTF-8">
		<title>My Calendar</title>
	    <link rel="stylesheet" type="text/css" href="style.css">
      <?php session_start();
      if (!isset($_SESSION['name'])){
        header("Location: ./login.php");
        exit();
      }
      else{
        $name = $_SESSION['name'];
      }
       ?>
    <script type="text/javascript"
      src = "https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDSAH6LCyvJUo7bS7C9Hx7fW-hrK7N8yZE">
	  </script>
    <script type="text/javascript">
	  var map;
	  var service;
      var infowindow;
	  var keller = new google.maps.LatLng(44.9745476,-93.23223189999999);

      function initMap() {

		map = new google.maps.Map(document.getElementById('map'), {
          center : keller,
          zoom: 17
        });
        infowindow = new google.maps.InfoWindow();
		service = new google.maps.places.PlacesService(map);
		var locations = document.getElementsByClassName('location');
    // array of all locations
        for(var i = 0; i < locations.length; i++) {
          mark(locations[i].innerHTML);
        }
      }
	  google.maps.event.addDomListener(window, 'load', initMap);
	  function mark(location){
		var request = {
            location: keller,
            radius: '1000',
            query:location
        };
		service.textSearch(request, callback);
	  }
      function callback(results, status) {
         if(status == google.maps.places.PlacesServiceStatus.OK) {
           /* just take top result */
           var place = results[0];
           createMarker(results[0]);
         }
      }
      function createMarker(place) {
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location,
          title: place.name
        });
        var infowindow = new google.maps.InfoWindow({
            content: '<div><strong>' + place.name + '</strong><br>' +
                  'Address: ' + place.formatted_address + '</div>'
        });
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map,marker);
        });
      }
    </script>
  	</head>
  	<body initMap()>
	  	<div>
	    	<h1>My Calendar</h1>
        <p>Welcome <?php echo $name; ?></p>
		    <nav>
          <input type="button" onclick="location = './login.php';" value="Log Out"/>
    			<input type="button" onclick="location ='./calendar.php';" value="My Calendar" />
    			<input type="button" onclick="location ='./input.php';" value="Form Input" />
    			<input type="button" onclick="location ='./admin.php';" value="Admin" />
		    </nav>
		  </div>
		  <br>
      <?php
        $temp;
        $eventlist  = array(
          "Monday" => array(),
          "Tuesday" => array(),
          "Wednesday" => array(),
          "Thursday" => array(),
          "Friday" => array());
          //echo count($eventlist["Monday"]);
        //2-d array of eventlist, sorted by day
        $myfile = fopen($name.".txt", "r");
        $delimiter = "\n";
        $events = fread($myfile, filesize($name.".txt"));
        $allevents = explode($delimiter, $events);
        if( $allevents[count($allevents) -1] == ""){
          unset($allevents[count($allevents)-1]);
        }
        foreach ($allevents as $event){
          $temp = json_decode($event,true);
          array_push($eventlist[$temp["day"]],$temp);
        }
         foreach ($eventlist as $key => $eventofday) {
           usort($eventlist[$key], function($a, $b) { return $a["starttime"] > $b["starttime"];});
         }
         echo "<div id ='calendar_table'>";
         echo "<table>";

         foreach($eventlist as $eventofday){
           if(count($eventofday)!= 0){
             echo "<tr>";
             echo "<td>";
             echo $eventofday[0]["day"];
             echo "</td>";
             foreach($eventofday as $event){
               echo "<td>";
               echo $event["eventname"];
               echo "<br>";
               echo $event["starttime"];
               echo "--";
               echo $event["endtime"];
               echo "<br><span class='location'>";// class is location for location of event
               echo $event["location"];
               echo "</span>";
             }
             echo "</tr>";
           }
         }
         echo "</table>";
         echo "</div>";
       ?>
      <input type="text" id="location_box">
      <button id="load_marks">Search</button>
       </form>
        <br>
       <div id="map"></div>
  	</body>
</html>
