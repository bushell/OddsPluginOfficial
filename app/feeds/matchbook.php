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


            $matchbook_feed_url = $array['matchbook_feed_url'];

            

        }
    } else {
            echo 'SQL Error';
    }



    $url = $matchbook_feed_url;
    function get_data($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    $returned_content = get_data($url);
    echo $returned_content;
?>