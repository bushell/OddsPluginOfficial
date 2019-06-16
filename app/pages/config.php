<?php 
include('../../../../../wp-config.php');


//

		// Create connection

		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		// Check connection

		if ($conn->connect_error) {

		    die("Connection failed: " . $conn->connect_error);

		} 
				$table_name = $table_prefix. 'options';

//


if (isset($_GET['data'])) {
	$data = $_GET['data'];
} else {
    // Fallback behaviour goes here
}







if ($data == 'live_odds') {

	$sql = "SELECT * FROM `".$table_name ."` WHERE `option_name` = 'horse-exchange'";


	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
		    $string = $row["option_value"];
			$needle = 'live_odds";i:';
			$str = substr($string, strpos($string, $needle) + strlen($needle), 1);
			//echo $str;
		}
		} else {
			echo 'SQL Error';
	}



	if ($str == '1'){
		$live_odds = true;
		echo $live_odds;
	}
	else if ($str == '0'){
		$live_odds = false;
		echo "0";
		//echo $live_odds;

	}
	$conn->close();

}

if ($data == 'bookmaker_data') {

	$sql = "SELECT * FROM `".$table_name ."` WHERE `option_name` = 'horse-exchange'";


	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
		    $string = $row["option_value"];

			$array = unserialize($string);

			$live_odds = $array['live_odds'];
			$betfair_affiliate_id = $array['betfair_affiliate_id'];
			$betfair_show_value = $array['betfair_show'];
			$betfair_welcome_bonus = $array['betfair_welcome_bonus'];
			$betfair_special_offers = $array['betfair_special_offers'];
			$betfair_bog = $array['betfair_bog'];
			$smarkets_show_value = $array['smarkets_show'];
			$smarkets_affiliate_id = $array['smarkets_affiliate_id'];
			$smarkets_welcome_bonus = $array['smarkets_welcome_bonus'];
			$smarkets_special_offers = $array['smarkets_special_offers'];
			$smarkets_bog = $array['smarkets_bog'];
			$matchbook_show_value = $array['show_matchbook'];
			$matchbook_affiliate_id = $array['matchbook_affiliate_id'];
			$matchbook_welcome_bonus = $array['matchbook_welcome_bonus'];
			$matchbook_special_offers = $array['matchbook_special_offers'];
			$matchbook_bog = $array['matchbook_bog'];
			$williamhill_show_value = $array['show_williamhill'];
			$williamhill_affiliate_id = $array['williamhill_affiliate_id'];
			$williamhill_welcome_bonus = $array['williamhill_welcome_bonus'];
			$williamhill_special_offers = $array['williamhill_special_offers'];
			$williamhill_bog = $array['williamhill_bog'];
			$betfred_show_value = $array['show_betfred'];
			$betfred_affiliate_id = $array['betfred_affiliate_id'];
			$betfred_welcome_bonus = $array['betfred_welcome_bonus'];
			$betfred_special_offers = $array['betfred_special_offers'];
			$betfred_bog = $array['betfred_bog'];
			$unibet_affiliate_id = $array['unibet_affiliate_id'];
			$unibet_show_value = $array['show_unibet'];
			$unibet_app_key = $array['unibet_app_key'];
			$unibet_app_id = $array['unibet_app_id'];
			$unibet_welcome_bonus = $array['unibet_welcome_bonus'];
			$unibet_special_offers = $array['unibet_special_offers'];
			$unibet_bog = $array['unibet_bog'];
			$leovegas_show_value = $array['show_leovegas'];
			$leovegas_affiliate_id = $array['leovegas_affiliate_id'];
			$leovegas_welcome_bonus = $array['leovegas_welcome_bonus'];
			$leovegas_special_offers = $array['leovegas_special_offers'];
			$leovegas_bog = $array['leovegas_bog'];
			// echo $betfair_affiliate_id;
			// echo "<br>";
			// echo $live_odds;
			// echo "<br>";
			// echo $betfair_show_value;
			// echo "<br>";
			 //echo $unibet_show_value;
			 //echo $unibet_affiliate_id;
			// echo "<br>";
			// echo $matchbook_show_value;
			// echo "<br>";
			//echo $william_show_value;
			// echo "<br>";
			// echo $betfred_show_value;
		}
	} else {
			echo 'SQL Error';
	}


	$data_set = array(
						"live_odds"=>"$live_odds",
						"show_betfair"=>"$betfair_show_value", 
						"betfair_affiliate_id"=>"$betfair_affiliate_id",
						"betfair_welcome_bonus"=>"$betfair_welcome_bonus", 
						"betfair_special_offers"=>"$betfair_special_offers", 
						"betfair_bog"=>"$betfair_bog",
						"show_smarkets"=>"$smarkets_show_value", 
						"smarkets_affiliate_id"=>"$smarkets_affiliate_id",
						"smarkets_welcome_bonus"=>"$smarkets_welcome_bonus", 
						"smarkets_special_offers"=>"$smarkets_special_offers", 
						"smarkets_bog"=>"$smarkets_bog",
						"show_matchbook"=>"$matchbook_show_value", 
						"matchbook_affiliate_id"=>"$matchbook_affiliate_id",
						"matchbook_welcome_bonus"=>"$matchbook_welcome_bonus", 
						"matchbook_special_offers"=>"$matchbook_special_offers", 
						"matchbook_bog"=>"$matchbook_bog",
						"show_williamhill"=>"$williamhill_show_value", 
						"williamhill_affiliate_id"=>"$williamhill_affiliate_id",
						"williamhill_welcome_bonus"=>"$williamhill_welcome_bonus", 
						"williamhill_special_offers"=>"$williamhill_special_offers", 
						"williamhill_bog"=>"$williamhill_bog",
						"show_betfred"=>"$betfred_show_value",
						"betfred_affiliate_id"=>"$betfred_affiliate_id",
						"betfred_welcome_bonus"=>"$betfred_welcome_bonus", 
						"betfred_special_offers"=>"$betfred_special_offers", 
						"betfred_bog"=>"$betfred_bog",
						"show_unibet"=>"$unibet_show_value",
						"unibet_affiliate_id"=>"$unibet_affiliate_id",
						"unibet_app_id"=>"$unibet_app_id",
						"unibet_app_key"=>"$unibet_app_key",
					    "unibet_welcome_bonus"=>"$unibet_welcome_bonus", 
						"unibet_special_offers"=>"$unibet_special_offers", 
						"unibet_bog"=>"$unibet_bog",
						"show_leovegas"=>"$leovegas_show_value",
						"leovegas_affiliate_id"=>"$leovegas_affiliate_id",
						"leovegas_welcome_bonus"=>"$leovegas_welcome_bonus", 
						"leovegas_special_offers"=>"$leovegas_special_offers", 
						"leovegas_bog"=>"$leovegas_bog"
					);
	echo json_encode($data_set);


	$conn->close();
}




?>