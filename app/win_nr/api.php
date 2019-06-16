<?php
// Example market id is 1.149257838, this should return the winner as Caspar The Cub
include ('../../../../../wp-config.php');

// Create connection

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection

if ($conn->connect_error)
	{
	die("Connection failed: " . $conn->connect_error);
	}

$table_name = $table_prefix . 'horses';

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// Get market id varible from URL
if (isset($_GET['market_id'])) {
    $market_id = $_GET['market_id'];
} else {
    $market_id = '';
    echo 'No Market ID parameter has been set.';
}
//


$sql = "SELECT * FROM $table_name WHERE market_id = '".$market_id."' AND status = 'WINNER'";

$result = $conn->query($sql);

if ($result->num_rows > 0)
	{

	// output data in to json

	while ($row = $result->fetch_assoc())
		{
			$arr = array('cloth_number'=>$row['cloth_number'], 'cloth'=>$row['cloth'], 'horse'=>$row['horse']);
			$json = json_encode($arr);
			echo $json;

		}
	}
  else
	{
	echo " 0 results";
	}

$conn->close();


?>