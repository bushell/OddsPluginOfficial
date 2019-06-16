<!DOCTYPE html>

<!-- define angular app -->
<html ng-app="myApp">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- SCROLLS -->
  <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


  <!-- SPELLS -->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js"></script>
  <script src="https:////ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular-route.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-filter/0.4.7/angular-filter.js"></script>
  
  <script src="script.js"></script>

  <style type="text/css">
    html {
      line-height: 0px !important;
    }
    body {
      line-height: 0px !important;
      min-height: 0% !important;
    }
    .container {
      max-width: 1250px !important;
    }


h5, h6 {
     margin: 0 0 0 0 !important;
}
   

    .list-group-item {

      background-color: #f2f2f2;

    }

    .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
    background-color: #000;
    border-color: #000;
}


    /* BETTING SLIP */

    .mdl-list__item-primary-content,
    .mdl-list__item-sub-title {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .bet-slip {
      width: 100%;
    }

    .item-1 {
      border-top: 1px solid grey;
    }

    .item-1,
    .item-2,
    .item-3,
    .total-item {
      border-bottom: 1px solid grey;
    }

    .betslip-odds {
      min-width: 44px;
      text-align: center;
      padding: 4px;
      border: 1px solid #FFC107;
      border-radius: 2px;
      background-color: #FFC107;
    }

    .betslip-total-odds {
      padding: 4px;
      border: 1px solid #9E9E9E;
      border-radius: 2px;
      background-color: #E0E0E0;
    }

    .betslip-outcome {
      display: block;
      text-align: center;
      float: right;
      min-width: 16px;
      max-width: 100px;
      margin-right: 4px;
      padding: 4px;
      border: 1px solid #FFC107;
      border-radius: 2px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;

    }

    .mdl-list__item-secondary-content {
      flex-flow: row !important;
    }

    .total-odds {
      margin-right: 48px;
    }

    .total-item {
      background-color: #FAFAFA;
    }

    .bet-slip li {
      transition-duration: .28s;
      transition-timing-function: cubic-bezier(.4, 0, .2, 1);
      transition-property: background-color;
    }

    .bet-slip li:hover {
      background-color: #eee;
    }
  </style>

  <!-- betting slip -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.1.2/material.indigo-amber.min.css">

</head>

<!-- define angular controller -->

<body ng-controller="mainController">


  <div id="main">

    <!-- angular templating -->
    <!-- this is where content will be injected -->
    <div ng-view></div>

  </div>

  <!-- <footer class="text-center">
    <p>View the tutorial on <a href="http://scotch.io/tutorials/javascript/single-page-apps-with-angularjs-routing-and-templating">Scotch.io</a></p>
  
    <p>View a tutorial on <a href="http://scotch.io/tutorials/javascript/animating-angularjs-apps-ngview">Animating Your Angular Single Page App</a></p>
  </footer> -->

  
</body>

</html>

<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>



   <!-- Tooltips -->

  <script type="text/javascript" src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
  <!-- <script type="text/javascript" src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script> -->
 


 


