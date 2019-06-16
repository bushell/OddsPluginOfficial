<?php
$competition_id = '2021';


$api_key = '0161d713d58742328724ed3be59cfb7b';



$league_url = 'https://api.football-data.org/v2/competitions/'.$competition_id.'/teams' ;
$teams_url = 'https://api.football-data.org/v2/competitions/'.$competition_id.'/standings';

// 1 = list all teams
// 2 = league standings


$api_url = '0';
$api_id = $_GET['api_id'];

if ($api_id == '1'){
  $api_url = $league_url ;
}
else if ($api_id == '2'){
  $api_url = $teams_url;
}



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $api_url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    ": ",
    "Postman-Token: 4c6550ca-f356-4901-a309-3d73795ec9e1",
    'X-Auth-Token: '. $api_key,
    "cache-control: no-cache"
  ),
));

$someJSON = curl_exec($curl);
$err = curl_error($curl);



curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {


  
  if ($api_id == '1'){

   //////////////////////////////////////////////////////////////////////////////////
  ///         GET TEAMS               //////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////

     echo "<h1>Teams</h1>";

    // Convert JSON string to Object
    $someObject = json_decode($someJSON);
    //print_r($someObject);      // Dump all data of the Object

    foreach($someObject->teams as $key => $value) {
      $name = $value->name;
      $id = $value->id;
      $shortName = $value->shortName;
      $crestUrl = $value->crestUrl;
      $founded = $value->founded;
      $venue = $value->venue;
      $website = $value->website;
      $club_colours = $value->clubColors;

      echo $id . "<br>";
      echo $name . "<br>";
      echo $shortName . "<br>";
      echo $crestUrl . "<br>";
      echo $venue . "<br>";
      echo $founded . "<br>";
      echo $website . "<br>";
      echo $club_colours . "<br>";
      echo "<hr>";
    }

    echo "<br>";
  //////////////////////////////////////////////////////////////////////////////////
  ///         GET TEAMS               //////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////

  }
  else if ($api_id == '2'){
    

  //////////////////////////////////////////////////////////////////////////////////
  ///         GET STANDINGS               //////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////

     echo "<h1>Standings</h1>";
    // Convert JSON string to Object
    $someObject = json_decode($someJSON);
    //print_r($someObject);      // Dump all data of the Object

    foreach($someObject->standings as $key => $value) {
       $position = $value->type;

       echo $position . '<br>';

          foreach($key->table->team as $team => $value2)                                                                                       
          {                   
              echo $value2->name . "<br>";                                                                                                    
          }         
      }
    //echo $competitionName;
    echo "<br>";

  //////////////////////////////////////////////////////////////////////////////////
  ///         GET STANDINGS               //////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////

  }








}





?>