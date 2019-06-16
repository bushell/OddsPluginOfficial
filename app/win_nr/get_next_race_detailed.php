
<?php


//require_once("json.php");
error_reporting(E_ALL);

include ('includes/config.php');



$horseRacingEventTypeId = '7';

$market_id = '1.131081826';

$results = '100';
$eventID = '7';


ob_start();
$sessionToken = getACookieNRD($username, $password);
ob_end_clean();






if($sessionToken === "")
	{
		echo  "We had a problem Logging on to the Betfair API\r\n";
		echo "Please Try again in a few moments.";
	}
	
else
	{
		//echo $sessionToken;
		//echo "<br>";
		getNextRaceDet($appKey, $sessionToken,$eventID);
		
	}






	
function getACookieNRD($username, $password){
	
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


 

function getNextRaceDet($appKey, $sessionToken, $eventTypeID)
{

	// individual market
   // $params = '{"filter":{"marketIds":["'.$marketid.'"]},"locale":"en","maxResults":"'.$maxResults.'","marketProjection":["MARKET_START_TIME"]}}';



    
$params = '{"filter": 
			{
				"eventTypeIds": ["'.$eventTypeID.'"],
				"marketCountries": ["GB", "IE"], 
				"marketTypeCodes": ["WIN"],
				"sort":"FIRST_TO_START",
				"maxResults":"1"
			}, 
			"marketProjection": ["MARKET_START_TIME", "EVENT", "EVENT_TYPE", "RUNNER_DESCRIPTION", "RUNNER_METADATA"],
			"locale": "en", 
			"maxResults": "1"}';



    $jsonResponse = nextRaceDetApingRequest($appKey, $sessionToken, 'listMarketCatalogue', $params);


    return $jsonResponse[0];//->Response[0];

}



function nextRaceDetApingRequest($appKey, $sessionToken, $operation, $params)
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
    $response = json_decode(curl_exec($ch));
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($http_status == 200) {
        //return $response;
        // ccommented above line and added below to get it to work
        //echo json_encode($response);
echo "<h3>Next Race</h3>";
	foreach($response as $res) {


		if ($res->event->countryCode == 'GB'){
			echo "<h3><img src='wp-content/plugins/horse-exchange/app/images/GB.png' />".$res->event->venue . ' - ' . date("H:i:s", strtotime($res->marketStartTime))."</h3>";
		}
		else if ($res->event->countryCode == 'IE'){
			echo "<h3><img src='wp-content/plugins/horse-exchange/app/images/IE.png' />".$res->event->venue . ' - ' . date("H:i:s", strtotime($res->marketStartTime))."</h3>";
		}

		echo "<h5>".$res->marketName. " - " . $res->event->name."</h5>";



		$runners1 = (array) $res->runners;

echo "<table class='table table-hover table-striped'>";
/*	echo 					  "<tr>
					    <th>Firstname</th>
					    <th>Lastname</th> 
					    <th>Age</th>
					  </tr>";*/


echo  "<thead>";
echo  "    <tr>";
echo  "      <th scope='col'>#</th>";
echo  "      <th scope='col'>Colours</th>";
echo  "      <th scope='col'>Horse</th>";
echo  "      <th scope='col'>Jockey</th>";
echo  "      <th scope='col'>Trainer</th>";
echo  "      <th scope='col'>Age</th>";
echo  "      <th scope='col'>Form</th>";
echo  "    </tr>";
echo  "  </thead>";
echo "<tbody>";
foreach ($runners1 as $runner) {



	echo "<tr>";
		echo "<td>". $runner->metadata->CLOTH_NUMBER. "</td>";
		echo "<td> <img src='https://content-cache.cdnbf.net/feeds_images/Horses/SilkColours/".$runner->metadata->COLOURS_FILENAME."' </img>";
		echo "<td>". $runner->runnerName . "</td>";
		echo "<td>". $runner->metadata->JOCKEY_NAME . "</td>";
		echo "<td>". $runner->metadata->TRAINER_NAME . "</td>";
		echo "<td>". $runner->metadata->AGE . "</td>";
		echo "<td>". $runner->metadata->FORM . "</td>";

		//echo "selection_id: ".$runner->selectionId." - "; // echo selection_id
	echo "<tr>";
					
}

		

echo  " </tbody>";

echo "</table>";
echo "<a class='btn btn-primary' href='race/?market_id=".$res->marketId."' role='button'>VIEW</a>";

	}



    } else {
        echo 'Call to api-ng failed: ' . "\n";
        echo  'Response: ' . json_encode($response);
        exit(-1);
    }
}



?>