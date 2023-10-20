<?php 
include "dbSettings.php";

//session_start();

$sql = "select * from members";
$res = mysqli_query($con,$sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $q="insert into members (`password`, `firstName`, `lastName`, `email`) values ('".$_POST['pass']."','".$_POST['fname']."','".$_POST['lname']."','".$_POST['email']."')";
    $r=mysqli_query($con,$q);

    echo (!$r ? die($q) : "<script>window.location.href='adminPortal.php'</script>");
}
?>

<script>

function changeCol(id){

var element = document.querySelector("#grn_"+id);
element.classList.replace("svgGreen", "svgWhite");

}

function changeBack(id){

var element = document.querySelector("#grn_"+id);
element.classList.replace("svgWhite", "svgGreen");

}

document.addEventListener('click', function (e) {
        if (e.target.classList.contains('svgRed')) {
            
            // Retrieve the row ID from the clicked button's data attribute
            var rowID = e.target.getAttribute('data-rowid');
            
            // Store the row ID for use in your modal logic
            var modalRowID = rowID;
          
            document.getElementById('memberid').value=modalRowID;
            document.getElementById('command').value="delete";   
        }
    });

function generatePassword() {

    
    var length = 8,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
   
    document.getElementById('pass').value =retVal;
}


</script>

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

<body>

<div class="navbar"> 
  <a href="myRecipes.php" ><image width="630" height="75" class="img-fluid" src="images/logo green.png"></image> </a>
</div>

<div class="container-fluid" style="text-align:center">
    <div class="row">
    <div class="col-1">
      <a href="adminPortal.php" ><img id='backArrow' class="svgGreen2" style="vertical-align:middle;float:left;margin-top:10px; margin-left:30px" width="40px"
        height="40px" src="images/circle-arrow-left.svg" /></a>
    </div>
    <div class="col-10">
    <h3 class="pageTitle" style="font-size:26px; font-family:sans-serif; margin-top:15px">Add New Member</h3>
    <hr style="background-color:gainsboro;border:solid 0.5px gainsboro"class="col-xs-12"> 
    </div>
</div>

<div class="container-fluid" >

<div style="text-align: center;padding-right:20px; margin-bottom:30px">


    <div class="card mx-auto class">
      <div class="card-body mx-auto class" style="padding-left:40px">

        <form action="" method="post">

          <div class="form-group">
            <label style="float:left" for="fname">First Name:</label>
            <input style="height:43px; width:280px" type="text" class="form-control" name="fname"
              placeholder="Enter first name">
          </div>
          <div class="form-group">
            <label style="margin-top:0px;float:left" for="lname">Last Name:</label>
            <input style="height:43px; width:280px" type="text" class="form-control" name="lname"
              placeholder="Enter surname">
          </div>
          <div class="form-group">
            <label style="margin-top:10px;float:left" for="pass">Password:</label>  
            <button type ="button" style = "width:110px;height:35px;padding:5px;margin-left:34px; margin-top:10px" onclick="generatePassword()" class="btn btn-outline-success">Generate</button>
            <input style="height:43px; width:280px" type="text" class="form-control" name="pass" id="pass"
              placeholder="Create password"> 
          </div>
          <div class="form-group">
            <label style="margin-top:0px;float:left" for="email">Email:</label>  
            <input style="height:43px; width:280px" type="text" class="form-control" name="email" id="email"
              placeholder="Enter email"> 
          </div>

          <button type="submit" class="secondBtn" style="margin-top:20px;margin-right:30px;padding:10px;height:45px;width:240px">Add</button>
        </form>
        
      
      </div>
    </div>

</div>



</body>
</html>