<?php
	$buses = [];
	$busStop = "";

	if (isset($_POST["btnFindStop"]))
	{
		$busStop = $_POST["txtStop"];
		$curl = curl_init();

		curl_setopt_array(
			$curl, 
			[
				//CURLOPT_URL => "http://datamall2.mytransport.sg/ltaodataservice/BusArrivalv2?BusStopCode=" . $busStop,
				CURLOPT_URL => "https://datamall2.mytransport.sg/ltaodataservice/v3/BusArrival?BusStopCode=" . $busStop,			
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

	function formatArrivalTime($strTime)
	{
		$newStr = str_replace("+08:00", "", $strTime);
		return date("h:i A", strtotime($newStr));
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Singapore Bus Arrival</title>

		<style>
			body
			{
				background-color: rgb(255, 255, 255);
				font-family: sans-serif;
				font-size: 16px;
			}

			#container
			{
				border-radius: 20px;
				border: 3px solid rgba(100, 0, 0, 0.8);
				padding: 2em;
			}

			#container div
			{
				border-radius: 20px;
				border: 3px solid rgba(100, 0, 0, 0.2);
				padding: 0.5em;
				color: rgb(0, 0, 0);
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
				border: 3px solid rgba(0, 0, 0, 0.5);
				padding: 5px;
				width: 5em;
				font-size: 20px;
				font-weight: bold;
			}
		</style>

		<script>
			function showArrivalFor($bus)
			{
				var hide = document.getElementsByClassName("arrival");

				for (var i = 0; i < hide.length; i++)
				{
					hide[i].style.display = "none";
				}

				var show = document.getElementById("arrival_" + $bus);
				show.style.display = "block";
			}
		</script>
	</head>

	<body>
		<div id="container">
			<div id="stop">
				<h1>&#128655; BUS STOP <?php echo $busStop;?></h1>
				<form method="POST">
					<input type="number" name="txtStop" placeholder="e.g, 9810007" />
					<button name="btnFindStop">FIND THIS STOP</button>
				</form>
			</div>

			<br/>

			<div id="bus" style="display:<?php echo (count($buses) == 0 ? "none" : "block");?>">
				<h1>&#128652; BUS SERVICES</h1>
				<?php 
					foreach($buses as $bus)
					{
				?>
					<button onclick="showArrivalFor('<?php echo $bus->ServiceNo; ?>');">
						<?php 
							echo $bus->ServiceNo;
						?>
					</button>		
				<?php		
					}
				?>
			</div>

			<br />

			<?php 
				foreach($buses as $bus)
				{
			?>
				<div id="arrival_<?php echo $bus->ServiceNo; ?>" class="arrival" style="display:none">
				<h1>&#128336; BUS <?php echo $bus->ServiceNo; ?> ARRIVAL TIMINGS</h1>
			<?php 
					if ($bus->NextBus)
					{
						echo "<h2>" . formatArrivalTime($bus->NextBus->EstimatedArrival) . "</h2>";
					}

					if ($bus->NextBus2)
					{
						echo "<h2>" . formatArrivalTime($bus->NextBus2->EstimatedArrival) . "</h2>";
					}

					if ($bus->NextBus3)
					{
						echo "<h2>" . formatArrivalTime($bus->NextBus3->EstimatedArrival) . "</h2>";
					}
			?>
				</div>
			<?php			
				}
			?>				
		</div>
	</body>
</html>
