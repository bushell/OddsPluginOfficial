<?php

$xml = simplexml_load_file("smarketOdds.xml");
echo json_encode($xml);

?>
