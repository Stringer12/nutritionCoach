<?php 
include "dbSettings.php";

session_start();


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>The Nutrition Coach</title>
  <link rel="stylesheet" href="styles.css">
  <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
</head>
<script>
  
function changeCol(id){

var element = document.querySelector("#grn_"+id);
element.classList.replace("svgGreen", "svgWhite");

}

function changeBack(id){

var element = document.querySelector("#grn_"+id);
element.classList.replace("svgWhite", "svgGreen");

}
</script>

<body onload="activeTab()">

<div class="navbar"> 
  <a href="myRecipes.php" ><image width="630" height="75" class="img-fluid" src="images/logo green.png"></image> </a>
</div>

<div id="tabGroup" class="btn-group-justified" style="position:relative; top:-20px">
  <a style="font-size:18px; height:70px;" id="1" href="myRecipes.php" class="btn btn-outline-success"  aria-current="page">My Recipes</a>
  <a style="font-size:18px;" id="2"href="newRecipe.php" onmouseover="changeCol(this.id)" onmouseout="changeBack(this.id)" class="btn btn-outline-success" >New Recipe <img id="grn_2" class="svgGreen" style="float:right;margin-right:10px" width="30px" height="30px" src="images/circle-plus.svg" /></a>
  <a style="font-size:18px;" id="3"href="addFood.php" onmouseover="changeCol(this.id)" onmouseout="changeBack(this.id)" class="btn btn-outline-success" >Add Food <img id="grn_3"class="svgGreen" style="float:right;margin-right:10px" width="30px" height="30px" src="images/circle-plus.svg" /></a>
  <a style="font-size:18px;" id="4"href="statistics.php" onmouseover="changeCol(this.id)" onmouseout="changeBack(this.id)" class="btn btn-outline-success" >My Stats <img id="grn_4"class="svgGreen" style="float:right;margin-right:10px" width="30px" height="30px" src="images/chart-column.svg" /></a>
  <a style="font-size:18px;" id="5" href= "login.php" onmouseover="changeCol(this.id)" onmouseout="changeBack(this.id)" class="btn btn-outline-success" data-toggle="modal" data-target="#logout">Logout <img id="grn_5"class="svgGreen" style="float:right;margin-right:10px" width="30px" height="30px" src="images/arrow-right-from-bracket.svg"/></a>
</div>

<div class="container-fluid"> 
 
<!-- logout modal -->
<div class="modal" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header" >
        <h5 class="modal-title" style="font-weight:bold;font-size:20px;margin-left:180px" id="exampleModalLabel">Confirm</h5>
        <button type="button" size=20 class="btn-close " data-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body d-flex justify-content-center">
          <div class="mb-3" style="margin-left:30px">
           <h4><b>Are you sure you want to Logout?</b></h4>
          </div>
      </div>

      <div class="modal-footer d-flex justify-content-center" style="margin-bottom:20px">
        <a href='#'><button type="button" class="cancelBtn" data-dismiss="modal" style="margin-top:20px;">Cancel</button></a>
        <a href="login.php?state=logOut"><button type="button" class="secondBtn" style="margin-top:20px;margin-left:30px;padding:10px;height:45px;width:180px">Logout</button></a>
      </div>

    </div>
  </div>
</div>

<!--message modal-->
<div class="modal" id="message" tabindex="-1" aria-labelledby="messageLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header" >
        <h5 class="modal-title" style="font-weight:bold;font-size:20px;margin-left:180px" id="messageLabel"></h5>
        <button type="button" size=20 class="btn-close " data-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body d-flex justify-content-center">
          <div class="mb-3" >
           <h4>Please enter Recipe Name and Serving Size</h4>
          </div>
      </div>

      <div class="modal-footer d-flex justify-content-center" style="margin-bottom:20px">
      <button type="button" class="secondBtn" data-dismiss="modal" style="margin-top:20px;margin-left:30px;padding:10px;height:45px;width:180px">OK</button>
      </div>

    </div>
  </div>
</div>