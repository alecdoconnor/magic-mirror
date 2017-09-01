<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
<script src="./keys.js"></script>
<style>
body {
  background-color: #000000;
  color: #ffffff;
  font-family: 'Roboto', sans-serif;
}
#dateTimeContainer {
	position: absolute;
	top: 10px;
	left: 10px;
}
.datetime {
	margin: 0;
	padding: 0;
}
#time {
	font-size: 75px;
}
#date {
	font-size: 45px;
}
#weatherContainer {
	position: fixed;
	top: 10px;
	right: 10px;
	width: 300px;
	text-align: right;
}
#weatherImage {
	float: right;
	padding: 20px;
}
</style>
<script>
var shortWeekDays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
var longWeekDays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
var shortMonths = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"]
var longMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
</script>
<script>
//https://stackoverflow.com/questions/12460378/how-to-get-json-from-url-in-javascript
var getJSON = function(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.responseType = 'json';
    xhr.onload = function() {
      var status = xhr.status;
      if (status === 200) {
        callback(null, xhr.response);
      } else {
        callback(status, xhr.response);
      }
    };
    xhr.send();
};
</script>
<script>
function startUpdates() {
	updateAll()
	getWeather()
	setInterval(updateAll, 1000)
	setInterval(getWeather, 1000*60*10)
}
function updateAll(){
    var d = new Date()
	updateTime(d)
	updateDate(d)
}
function updateTime(d) {
    var hours = d.getHours()
    var minutes = d.getMinutes()
    var ampm = (hours < 12) ? "AM" : "PM"
    hours = hours % 12
    if (hours < 10) {
		hours = "0" + hours
	}
    if (minutes < 10) {
        minutes = "0" + minutes
    }
    var time = hours + ":" + minutes + " " + ampm
    document.getElementById("time").innerHTML = time
}
function updateDate(d) {
	var weekDay = shortWeekDays[d.getDay()]
	var month = shortMonths[d.getMonth()]
	var day = d.getDate()
	var year = d.getFullYear()
	var date = weekDay + ", " + month + " " + day + ", " + year
	document.getElementById("date").innerHTML = date
}
function getWeather() {
	var url = "http://api.wunderground.com/api/" + wundergroundKeyID + "/forecast/q/" + zip + ".json"
	getJSON(url, function(err, data) {
	  if (err !== null) {
	    document.getElementById("weatherText").innerHTML = "Unable to load data"
  	  } else {
	    document.getElementById("weatherTextHeader").innerHTML = data.forecast.txt_forecast.forecastday[0].title
	    document.getElementById("weatherText").innerHTML = data.forecast.txt_forecast.forecastday[0].fcttext
	    var iconURL = "https://icons.wxug.com/i/c/i/" + data.forecast.txt_forecast.forecastday[0].icon + ".gif"
	    document.getElementById("weatherImage").src = iconURL
  	  }
});

}
</script>
</head>
<body onLoad="startUpdates()">

<div id="dateTimeContainer">
<h1 id="time" class="datetime"></h1>
<h1 id="date" class="datetime"></h2>
</div>
<div id="weatherContainer">
<img src="" id="weatherImage" />
<h1 id="weatherTextHeader"></h1>
<div style="width: 0; height: 0; clear: both;"></div>
<h2 id="weatherText"></h2>
</div>

<?php

// echo "working".Date("Y");

?>

</body>
</html>
