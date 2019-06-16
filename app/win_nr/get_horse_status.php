
<?php
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

// require_once("json.php");

error_reporting(E_ALL);

include ('includes/config.php');

//$market_id = '"1.149257838","1.149257845","1.149257852","1.149257859","1.149257866","1.149257873","1.149349978","1.149313240","1.149349943","1.149349983","1.149313245","1.149349948","1.149349988","1.149313250","1.149349953","1.149349993","1.149313255","1.149349958","1.149349998","1.149313260","1.149349963","1.149350003","1.149313265","1.149349968","1.149350008","1.149313270","1.149349973","1.149313200","1.149313275" ,"1.149313205","1.149313210","1.149313215","1.149313220","1.149313225","1.149313230","1.149313235","1.149350014","1.149350054","1.149350019","1.149350059"';
$maxResults = '100';
$eventTypeID = '7';
$sql = "SELECT DISTINCT market_id FROM $table_name";
$result = $conn->query($sql);
$market_ids = '';

if ($result->num_rows > 0)
	{

	// output data of each row

	while ($row = $result->fetch_assoc())
		{

		// echo $num_rows;
		// $selection_ids = $row["selection_id"].',';
		// echo $selection_ids;
		// $market_ids = $row["market_id"].',';
		// $market_ids = $market_ids .'"'.$row["market_id"].'",';
		// $market_ids[ $row['market_id']] = $row;

		$new_array[] = $row['market_id'];

		// $market_ids[] = $row["market_id"];
		// echo 'count: '. $row["COUNT(market_id)"];

		}
	}
  else
	{
	echo "0 results";
	}


// echo 'number of rows: '.$num_rows;

$max_market_ids = '40';

// print_r(array_chunk($new_array, $max_market_ids));

$arr_test = array_chunk($new_array, $max_market_ids);

// print_r($arr_test);

$market_id_arr1= count($arr_test);
$market_id_arr = '';
$increment = '0';
$inc = '0';


////////////////////////////////
// create the vars dnamically //
////////////////////////////////
$x = '1';
while ($x <= $market_id_arr1)
	{
		${"value" . $x} = '';
		$x++;
	}



////////////////////////////////
// adds a comma between values//
////////////////////////////////
foreach($arr_test as $row)
	{
	$market_id_arr = '';
	foreach($row as $value)
		{
			$market_id_arr .= "\"$value\",";
		}

	$increment++;
	$market_id_arr = rtrim($market_id_arr,","); 
	${"value" . $increment} =  $market_id_arr;
		
}

// print $value5;
 
ob_start();
$sessionToken = getACookie($username, $password);
ob_end_clean();
$DEBUG = false;

if ($sessionToken === "")
	{
	echo "We had a problem Logging on to the Betfair API\r\n";
	echo "Please Try again in a few moments.";
	}
  else
	{    
		$val = ${"value" . $market_id_arr1};
		$z = '1';
	  	while ($z <= $market_id_arr1)
	  	{
	       getMarketBook($appKey, $sessionToken, ${"value". $z}, $table_name, $conn);
	 		$z++;
	 	}
	 	// Close the connection
	 	$conn->close();

	}

function getACookie($username, $password)
	{
	$loginEndpoint = "https://identitysso.betfair.com/api/login";
	$cookie = "";
	$login = "true";
	$redirectmethod = "POST";
	$product = "home.betfair.int";
	$url = "https://www.betfair.com/";
	$fields = array(
		'username' => urlencode($username) ,
		'password' => urlencode($password) ,
		'login' => urlencode($login) ,
		'redirectmethod' => urlencode($redirectmethod) ,
		'product' => urlencode($product) ,
		'url' => urlencode($url)
	);

	// open connection

	$ch = curl_init($loginEndpoint);

	// url-ify the data for the POST

	$counter = 0;
	$fields_string = "&";
	foreach($fields as $key => $value)
		{
		if ($counter > 0)
			{
			$fields_string.= '&';
			}

		$fields_string.= $key . '=' . $value;
		$counter++;
		}

	rtrim($fields_string, '&');
	curl_setopt($ch, CURLOPT_URL, $loginEndpoint);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);

	// echo $result;

	$data = [];
	if ($result == false)
		{
		echo 'Curl error: ' . curl_error($ch);
		}
	  else
		{
		$temp = explode(";", $result);
		$result = $temp[0];
		$end = strlen($result);
		$start = strpos($result, 'ssoid=');
		$start = $start + 6;
		$result = substr($result, $start, $end);
		}

	return $result;
	}

function getMarketBook($appKey, $sessionToken, $market_ids, $table_name, $conn)
	{
		 
	// $market_ids = ltrim($market_ids, '5');
	 // print_r($market_ids); 
	$params = '{"marketIds":[' . $market_ids . '] }';
	$jsonResponse = sportsApingRequest($appKey, $sessionToken, 'listMarketBook', $params, $table_name, $conn);
	return $jsonResponse[0];
	}

function sportsApingRequest($appKey, $sessionToken, $operation, $params, $table_name, $conn)
	{
		print $params;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.betfair.com/exchange/betting/rest/v1/$operation/");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'X-Application: ' . $appKey,
		'X-Authentication: ' . $sessionToken,
		'Accept: application/json',
		'Content-Type: application/json'
	));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	debug('Post Data: ' . $params);
	$response = json_decode(curl_exec($ch));
	debug('Response: ' . json_encode($response));
	$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	if ($http_status == 200)
		{
			foreach($response as $res)
				{
					$runners1 = (array)$res->runners;
					foreach($runners1 as $runner)
						{
							// Only look at horses that have won or been removed
							if ($runner->status == 'WINNER' || $runner->status == 'REMOVED') {

								// Update horse in the database
								$sql_update_query = "UPDATE `$table_name` SET status='".$runner->status."' WHERE selection_id='".$runner->selectionId."'";
								
								if ($conn->query($sql_update_query) === TRUE) {
							    	echo "selection_id: " . $runner->selectionId . " - "; // echo selection_id
									echo "status: " . $runner->status . " has been inserted.\n"; // echo selection_id
								} else {
							    	echo "Error: " . $sql_update_query . "<br>" . $conn->error;
								}

							}

						}
				}
		}
	  else
		{
		echo 'Call to api-ng failed: ' . "\n";
		echo 'Response: ' . json_encode($response);
		exit(-1);
		}
	}

function debug($debugString)
	{
	global $DEBUG;
	if ($DEBUG) echo $debugString . "\n\n";
	}

?>