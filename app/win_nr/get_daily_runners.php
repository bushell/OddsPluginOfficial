<?php
include('../../../../../wp-config.php');



// Create connection

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

} 
		$table_name = $table_prefix. 'horses';

echo "db success";
echo $table_name;












header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
//require_once("json.php");
error_reporting(E_ALL);


include ('includes/config.php');
$sessionToken = "";


$horseRacingEventTypeId = '7';

$market_id = '1.131081826';

$results = '100';
$eventID = '7';


ob_start();
$sessionToken = getACookie($username, $password);
ob_end_clean();


$DEBUG = false;




if($sessionToken === "")
	{
		echo  "We had a problem Logging on to the Betfair API\r\n";
		echo "Please Try again in a few moments.";
	}
	
else
	{
		//echo $sessionToken;
		//echo "<br>";
		getEventTime($appKey, $sessionToken, $market_id, $results, $eventID, $table_name, $conn);
		
	}






	
function getACookie($username, $password){
	
	$loginEndpoint= "https://identitysso.betfair.com/api/login";
	
	$cookie = "";
	
	$login = "true";
	$redirectmethod = "POST";
	$product = "home.betfair.int";
	$url = "https://www.betfair.com/";

	$fields = array
		(
			'username' => urlencode($username),
			'password' => urlencode($password),
			'login' => urlencode($login),
			'redirectmethod' => urlencode($redirectmethod),
			'product' => urlencode($product),
			'url' => urlencode($url)
		);

	//open connection
	$ch = curl_init($loginEndpoint);


	//url-ify the data for the POST
	$counter = 0;
	$fields_string = "&";
	
	foreach($fields as $key=>$value) 
		{ 
			if ($counter > 0) 
				{
					$fields_string .= '&';
				}
			$fields_string .= $key.'='.$value; 
			$counter++;
		}

	rtrim($fields_string,'&');

	curl_setopt($ch, CURLOPT_URL, $loginEndpoint);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
	curl_setopt($ch, CURLOPT_HEADER, true);  // DO  RETURN HTTP HEADERS
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // DO RETURN THE CONTENTS OF THE CALL

	//execute post

	$result = curl_exec($ch);


	echo $result;

	if($result == false) 
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
	curl_close($ch);
	
	return $result;
}



 

function getEventTime($appKey, $sessionToken, $marketid, $maxResults, $eventTypeID, $table_name, $conn)
{

	// individual market
   // $params = '{"filter":{"marketIds":["'.$marketid.'"]},"locale":"en","maxResults":"'.$maxResults.'","marketProjection":["MARKET_START_TIME"]}}';



    
$params = '{"filter": 
			{
				"eventTypeIds": ["'.$eventTypeID.'"],
				"marketCountries": ["GB", "IE"], 
				"marketTypeCodes": ["WIN"]
			}, 
			"marketProjection": ["MARKET_START_TIME", "EVENT", "EVENT_TYPE", "RUNNER_DESCRIPTION", "RUNNER_METADATA"],
			"locale": "en", 
			"maxResults": "'.$maxResults.'"}';



    $jsonResponse = sportsApingRequest($appKey, $sessionToken, 'listMarketCatalogue', $params, $table_name, $conn);


    return $jsonResponse[0];//->Response[0];

}



function sportsApingRequest($appKey, $sessionToken, $operation, $params, $table_name, $conn)
{
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
    if ($http_status == 200) {
        //return $response;
        // ccommented above line and added below to get it to work
        //echo json_encode($response);

	foreach($response as $res) {



		echo "Market Name: ".$res->marketName." - ";
		echo "Event Name: ".$res->event->name." - ";
		echo "Venue: ".$res->event->venue." - ";
		echo "Country: ".$res->event->countryCode." - ";
		echo "Start Time: ".$res->marketStartTime."\n";



		$runners1 = (array) $res->runners;

	
foreach ($runners1 as $runner) {
    


					
	
					echo "selection_id: ".$runner->selectionId." - "; // echo selection_id
					
					$runner_name = $runner->runnerName;
					echo "runner_name: ".$runner_name." - "; // echo runner_name
					echo "runner_number: ".$runner->metadata->CLOTH_NUMBER." - "; // echo runner_name
					echo "runner_color: ".$runner->metadata->COLOURS_FILENAME." - "; // echo runner_name

					echo "Market ID: ".$res->marketId." - ";
					echo "Market Name: ".$res->marketName." - ";
					echo "Event Name: ".$res->event->name." - ";
					echo "Venue: ".$res->event->venue." - ";
					echo "Country: ".$res->event->countryCode." - ";
					echo "Start Time: ".$res->marketStartTime."\n";

	
					$sql = "INSERT INTO `$table_name` 
					(
						`horse`, 
						`event_name`, 
						`market_name`, 
						`market_id`, 
						`event_time`, 
						`selection_id`, 
						`cloth`, 
						`cloth_number`, 
						`venue`, 
						`country`, 
						`status`
					)
					SELECT 
					'".$runner->runnerName."', 
					'".$res->event->name."',
					'".$res->marketName."',
					'".$res->marketId."', 
					'".$res->marketStartTime."', 
					'".$runner->selectionId."',
					'".$runner->metadata->COLOURS_FILENAME."',
					'".$runner->metadata->CLOTH_NUMBER."',
					'".$res->event->venue."',
					'".$res->event->countryCode."',
					'ACTIVE'
					FROM DUAL
					WHERE NOT EXISTS(
					    SELECT 1
					    FROM `$table_name`
					    WHERE horse = '".$runner->runnerName."' 
					    AND event_name = '".$res->event->name."' 
					    AND selection_id = '".$runner->selectionId."'
					)";

					//echo $sql;

					if ($conn->query($sql) === TRUE) {

					    echo "New record created successfully";

					} else {

					    echo "Error: " . $sql . "<br>" . $conn->error;

					}

		}

		


echo "\n\n";


	}



    } else {
        echo 'Call to api-ng failed: ' . "\n";
        echo  'Response: ' . json_encode($response);
        exit(-1);
    }
}

function debug($debugString)
{
    global $DEBUG;
    if ($DEBUG)
        echo $debugString . "\n\n";
}
	
?>