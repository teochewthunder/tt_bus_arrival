<?php
 //header("Access-Control-Allow-Origin: http://www.teochewthunder.com");
 //header("Access-Control-Allow-Credentials: true");

 $curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "http://datamall2.mytransport.sg/ltaodataservice/BusArrivalv2?BusStopCode=83139",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
    "accountKey: xxx=="
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Singapore Bus Arrival</title>

		<style>
			body
			{
				background-color: rgb(100, 0, 0);
				font-family: sans-serif;
			}

			#container
			{
				border-radius: 20px;
				border: 3px solid rgba(255, 255, 255, 0.8);
				padding: 1em;
			}

			#container div
			{
				border-radius: 20px;
				border: 3px solid rgba(255, 255, 255, 0.2);
				padding: 0.5em;
			}

			#stop input
			{
				border-radius: 5px;
				padding: 5px;
				width: 10em;
				height: 1em;
			}

			#stop button
			{
				background-color: rgb(50, 0, 0);
				color: rgb(255, 255, 255);
				border-radius: 5px;
				padding: 5px;
				width: 10em;
			}

			#stop button:hover
			{
				background-color: rgb(50, 50, 0);
			}

			#bus button
			{
				background-color: rgb(50, 0, 0);
				color: rgb(255, 255, 255);
				border-radius: 5px;
				border: 3px solid rgba(255, 255, 255, 0.5);
				padding: 5px;
				width: 5em;
				font-size: 20px;
				font-weight: bold;
			}

			#arrival
			{
				color: rgb(255, 255, 255);
			}
		</style>

		<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

		<script>
			function getArrivals()
			{
const settings = {
  "async": true,
  "crossDomain": true,
  "url": "http://datamall2.mytransport.sg/ltaodataservice/BusArrivalv2?BusStopCode=83139",
  "method": "GET",
  "headers": {
    "accountKey": "jA6FF90AQqSbpAPRs9XJAg==",
    "Content-Type": "application/json"
  }
};

$.ajax(settings).done(function (response) {
  console.log(response);
});
			}

		</script>
	</head>

	<body>
		<div id="container">
			<div id="stop">
				<input type="number" id="txtStop" placeholder="e.g, 9810007" />
				<button id="btnSearchStop" onclick="getArrivals()">FIND THIS STOP</button>
			</div>

			<br/>

			<div id="bus">
				<button>182</button>
				<button>55</button>
			</div>

			<br/>

			<div id="arrival">
				<h1 id="number">BUS 182 ARRIVAL TIMINGS</h1>
				<p>test1</p>
				<p>test2</p>
			</div>
		</div>
	</body>
</html>
