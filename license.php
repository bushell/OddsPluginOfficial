<?php
include('../../../wp-config.php');
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
	echo "No action entered.";
}


if (isset($_GET['license_key'])) {
    $license_key = $_GET['license_key'];
} else {
	echo "No license key entered.";
}







// The URL to your website and if your WordPress is installed on a sub directory add the full path to the folder
// Exemple:
//    website.com
//    website.com/wordpress
$url = 'http://bushell.net/';
  

////// check if we want to activate or deactivate
if ($action == 'activate'){
	$data = array(
    'fslm_v2_api_request' => 'activate', // The command
    'fslm_api_key' => '0A9Q5OXT13in3LGjM9F3', // API key
    'license_key' => $license_key, // The license keys
	);
}  

else if ($action == 'deactivate'){  
	$data = array(
    'fslm_v2_api_request' => 'deactivate', // The command
    'fslm_api_key' => '0A9Q5OXT13in3LGjM9F3', // API key
    'license_key' => $license_key, // The license keys
	);
}
///////////////////////////////////////////////////////

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
  
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
  
if ($result === FALSE) { /* Handle error */ }
  
// The variable $result contains the query result
 
  
$array = json_decode($result, true);
$code = $array['code'];
$message = $array['message'];




if ($code == '300' || $code == '400'){
	// Include WP config file
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

    mysql_select_db(DB_NAME);

    $table_name = $table_prefix. 'options';

	$sql = "SELECT * FROM `".$table_name ."` WHERE `option_name` = 'horse-exchange'";

    $result1 = mysql_query ($sql) or die (mysql_error ());
    
    while ($row = mysql_fetch_array ($result1)){
    
    	$original_string = $row ['option_value'];
    	//echo 'Original Code: '.$row ['option_value'];

    	$serializedData = $original_string;                  
		$data = unserialize($serializedData);

		if ($code == '300'){
			$data['license_status'] = 'Activated';
		}
		else if ($code == '400') {
			$data['license_status'] = 'Deactivated';
		}


		$data['license_key'] = $license_key;
		$updated_status = serialize($data);
		//echo $updated_status;


		$update_sql = "UPDATE `".$table_name ."` SET option_value = '".$updated_status."' WHERE `option_name` = 'horse-exchange'";
    	//echo $update_sql;

    	if ($conn->query($update_sql) === TRUE) {
    		echo $code. ' - ' . $message;
		} else {
		    echo "Error updating record: " . $conn->error;
		}

		$conn->close();
    }
       
}
else {
	echo $code . ' - '. $message;
}
?>