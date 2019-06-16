<?php
include('../../../../../wp-config.php');


//

        // Create connection

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Check connection

        if ($conn->connect_error) {

            die("Connection failed: " . $conn->connect_error);

        } 
        else {
           $table_name = $table_prefix. 'options';
        }
                
        $sql = "SELECT * FROM `".$table_name ."` WHERE `option_name` = 'horse-exchange'";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $string = $row["option_value"];

            $array = unserialize($string);


            $smarkets_feed_url = $array['smarkets_feed_url'];
            $api_key = $array['api_key'];

            

        }
    } else {
            echo 'SQL Error';
    }

$key = $_GET['key'];

$your_key = $api_key;


if ($key == $your_key)
{
	echo 'Your key '. $your_key . ' has been matched with the system key '. $key . '<br>';

	$url = $smarkets_feed_url;
	$zipFile = "smarketOdds.gz"; // Local Zip File Path
	$zipResource = fopen($zipFile, "w");
	// Get The Zip File From Server
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_FILE, $zipResource);
	$page = curl_exec($ch);
	if(!$page) {
	echo "Error :- ".curl_error($ch);
	}
	curl_close($ch);


	echo "Odds have been downloaded from Smarkets.<br>";


	//This input should be from somewhere else, hard-coded in this example

	// Raising this value may increase performance
	$buffer_size = 4096; // read 4kb at a time
	$out_file_name = str_replace('.gz', '.xml', $zipFile); 

	// Open our files (in binary mode)
	$file = gzopen($zipFile, 'rb');
	$out_file = fopen($out_file_name, 'wb'); 

	// Keep repeating until the end of the input file
	while (!gzeof($file)) {
	    // Read buffer-size bytes
	    // Both fwrite and gzread and binary-safe
	    fwrite($out_file, gzread($file, $buffer_size));
	}

	// Files are done, close files
	fclose($out_file);
	gzclose($file);
	echo "Smarkets XML file has been extracted to server.";
}
else 
{
	echo "invalid key.";
}
?>