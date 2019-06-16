<?php


//require_once("json.php");
error_reporting(E_ALL);



	
include ('includes/config.php');



$horseRacingEventTypeId = '7';



$results = '100';
$eventID = '7';


ob_start();
$sessionToken = getACookieUR($username, $password);
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
		getEventTime($appKey, $sessionToken,$eventID);
		
	}





function getACookieUR($username, $password){
	
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

 

function getEventTime($appKey, $sessionToken, $eventTypeID)
{

	// individual market
   // $params = '{"filter":{"marketIds":["'.$marketid.'"]},"locale":"en","maxResults":"'.$maxResults.'","marketProjection":["MARKET_START_TIME"]}}';



    
$params = '{"filter": 
			{
				"eventTypeIds": ["'.$eventTypeID.'"],
				"marketCountries": ["GB", "IE"], 
				"marketTypeCodes": ["WIN"],
				"sort":"FIRST_TO_START",
				"maxResults":"5"
			}, 
			"marketProjection": ["MARKET_START_TIME", "EVENT", "EVENT_TYPE"],
			"locale": "en", 
			"maxResults": "5"}';



    $jsonResponse = sportsApingRequest($appKey, $sessionToken, 'listMarketCatalogue', $params);


    return $jsonResponse[0];//->Response[0];

}



function sportsApingRequest($appKey, $sessionToken, $operation, $params)
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
echo "<h4>Next 5 Races</h4>";
echo "<table class='table table-hover table-striped no-border-tbl'>";
	foreach($response as $res) {

	echo "<tr>";

		if ($res->event->countryCode == 'GB'){
			echo "<td><img src='wp-content/plugins/horse-exchange/app/images/GB.png' /> ".$res->event->venue . ' - ' . date("H:i:s", strtotime($res->marketStartTime))."</td>";
		}
		else if ($res->event->countryCode == 'IE'){
			echo "<td><img src='wp-content/plugins/horse-exchange/app/images/IE.png' /> ".$res->event->venue . ' - ' . date("H:i:s", strtotime($res->marketStartTime))."</td>";
		}

		echo "<td>".$res->event->name."</td>";
		echo "<td><a class='btn btn-primary' href='race/?market_id=".$res->marketId."' role='button'>></a></td>";

	echo "</tr>";
		


/*	echo 					  "<tr>
					    <th>Firstname</th>
					    <th>Lastname</th> 
					    <th>Age</th>
					  </tr>";*/



		




	}
echo "</table>";


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