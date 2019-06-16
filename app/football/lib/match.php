<?php
  include 'FootballData.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>phplib football-data.org</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

       
       <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
        $id = $_GET['id'];
        echo $id;
        ?>
        <div class="container">

                <?php
                // Create instance of API class
                $api = new FootballData();
                ?>

            <?php
                echo "<p><hr><p>";
                // fetch all available upcoming matches for the next 3 days

                $match = $api->findMatchById($id);
            ?>
            <div class="page-header">
                <h1><?php echo $match->match->homeTeam->name . ' ('. $match->match->score->fullTime->homeTeam . ') '. ' v  (' .  $match->match->score->fullTime->awayTeam . ') '. $match->match->awayTeam->name ;  ?></h1>

                <h5>Half-Time</h5>
                <span><?php echo $match->match->homeTeam->name . ' ('. $match->match->score->halfTime->homeTeam . ') '. ' v  (' .  $match->match->score->halfTime->awayTeam . ') '. $match->match->awayTeam->name ;  ?></span>
                
                <hr>
                <?php echo $match->match->competition->name ;?>
                <br>
                Venue: <?php echo $match->match->venue ;?>
                <br>
                Matchday: <?php echo $match->match->matchday ; ?>
                <br>
                Date: <?php echo $match->match->utcDate ; ?>
            </div>
            
            
            
            <h3>Head to Head</h3>
            Played: <?php echo $match->head2head->numberOfMatches ;?>
            <br>
            <?php 
            echo $match->match->homeTeam->name . ' ' . $match->head2head->homeTeam->wins; 
            echo "<br>";
            echo 'Draws: '. $match->head2head->homeTeam->draws;  
            echo "<br>";
            echo $match->match->awayTeam->name . ' ' . $match->head2head->homeTeam->losses; 

            echo "<hr>";
            ?>

           

            Status: <?php echo $match->match->status ; ?>

           
        </div>
    </body>
</html>
