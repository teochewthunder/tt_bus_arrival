<?php
	$buses = [];

	if (isset($_POST["btnFindStop"]))
	{
		$curl = curl_init();

		curl_setopt_array(
			$curl, 
			[
				CURLOPT_URL => "http://datamall2.mytransport.sg/ltaodataservice/BusArrivalv2?BusStopCode=" . $_POST["txtStop"],
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_POSTFIELDS => "",
				CURLOPT_HTTPHEADER => 
			  	[
			    		"Content-Type: application/json",
			    		"accountKey: xxx=="
			  	],
			]
		);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$obj = json_decode($response);
			$buses = $obj->Services;
		}
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

		</script>
	</head>

	<body>
		<div id="container">
			<div id="stop">
				<form method="POST">
					<input type="number" name="txtStop" placeholder="e.g, 9810007" />
					<button name="btnFindStop" onclick="getArrivals()">FIND THIS STOP</button>
				</form>
			</div>

			<br/>

			<div id="bus" style="display:<?php echo (count($buses) == 0 ? "none" : "block");?>">
				<?php 
					foreach($buses as $bus)
					{
				?>
					<button>
						<?php 
							echo $bus->ServiceNo;
						?>
					</button>		
				<?php		
					}
				?>
			</div>

			<br/>

			<div id="arrival" style="display:<?php echo (count($buses) == 0 ? "none" : "block");?>">
				<?php 
					foreach($buses as $bus)
					{
				?>
					<h1 id="number">BUS <?php echo $bus->ServiceNo; ?> ARRIVAL TIMINGS</h1>
				<?php 
						if ($bus->NextBus)
						{
							echo "<p>" . $bus->NextBus->EstimatedArrival . (date("h:i", strtotime($bus->NextBus->EstimatedArrival))) . "</p>";
						}

						if ($bus->NextBus2)
						{
							echo "<p>" . $bus->NextBus2->EstimatedArrival . "</p>";
						}

						if ($bus->NextBus3)
						{
							echo "<p>" . $bus->NextBus->EstimatedArrival . "</p>";
						}			
					}
				?>				
			</div>
		</div>
	</body>
</html>
