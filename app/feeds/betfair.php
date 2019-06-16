<?php
    $data = json_decode(file_get_contents("php://input"));
    $marketId = $data->marketId;
    $url = 'https://uk-api.betfair.com/www/sports/exchange/readonly/v1.0/bymarket?currencyCode=GBP&alt=json&locale=en_GB&types=MARKET_STATE%2CRUNNER_STATE%2CRUNNER_EXCHANGE_PRICES_BEST&marketIds='.$marketId;
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