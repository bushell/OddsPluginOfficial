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


            $williamhill_feed_url = $array['williamhill_feed_url'];

            

        }
    } else {
            echo 'SQL Error';
    }


$xml = simplexml_load_file($williamhill_feed_url);
echo json_encode($xml);

?>
