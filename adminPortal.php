<?php 
include "dbSettings.php";

//session_start();

$sql = "select * from members";
$res = mysqli_query($con,$sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['command'] == "delete") {

    $memberid= $_POST['memberid'];

    $q="DELETE FROM members WHERE memberID= ".$memberid."";
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

function submitForm() {

    var form =document.getElementById('deleteForm');
    form.submit(); 
}

function showPass (id) {

    var passField= document.getElementById('pass_'+id);

    if(passField.type == "password") {
        passField.type = "text";
    } else {
        passField.type = "password";
    }
    
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
  <a href="login.php" ><image width="630" height="75" class="img-fluid" src="images/logo green.png"></image> </a>
</div>

<!--<div class="container-fluid" style="text-align:center; border-color:gainsboro; height:80px">
    <h3 class="pageTitle" style="font-size:26px; font-family:sans-serif">Admin Portal <hr>
       
    </h3>
</div>-->

<div class="container-fluid" style="text-align:center;">
    <div class="row">
    <div class="col-1">
      <a href="login.php" ><img id='backArrow' class="svgGreen2" style="vertical-align:middle;float:left;margin-top:10px; margin-left:30px" width="40px"
        height="40px" src="images/circle-arrow-left.svg" /></a>
    </div>
    <div class="col-10">
    <h3 class="pageTitle" style="font-size:26px; font-family:sans-serif; margin-top:15px;margin-bottom:20px ">Admin Portal</h3>
    </div>
</div>

<div class="container-fluid" >
<table class="table table-border ">
    <tr>
        <thead>
            <th class='theader' scope="col">MemberID</th>
            <th class='theader' scope="col">First Name</th>
            <th class='theader' scope="col">Last Name</th>
            <th class='theader' scope="col">Email</th>
            <th class='theader' scope="col">Password</th>            
            <th class='theader' scope="col">Action</th>
        </thead>
    </tr>
    <?php 

    
    while ($row = mysqli_fetch_assoc($res)) {

        echo "<tr id='recipe_" . $row['memberID'] . "'  onmouseover='rowFocus(this)' onmouseout='rowUnfocus(this)' >";
        echo "<td onclick='viewRecp(".$row['memberID'].")'>";
        echo $row['memberID'];
        echo "</td>";
        echo "<td onclick='viewRecp(".$row['memberID'].")' >";
        echo $row['firstName'];
        echo "</td>";
        echo "<td onclick='viewRecp(".$row['memberID'].")'>";
        echo $row['lastName'];
        echo "</td>";
        echo "<td onclick='viewRecp(".$row['memberID'].")'>";
        echo $row['email'];
        echo "</td>";
        echo "<td>";
        echo "<div class='row'>";
        echo "<div class='col'>";
        echo "<input readonly id='pass_".$row['memberID']."' type='password' style='margin-left:20px;border:none;width:90px' value = '".$row['password']."'/>" ;
        echo "<img class='svgGray' id=".$row['memberID']." onclick='showPass(this.id)' style= 'margin-left:10px'  width='15px' height='15px' src='images/eye.svg'/>";
        echo "</div>";
        echo "</div>";
        echo "</td>";        
        echo "<td>";
        echo "<img class='svgRed' data-rowid=".$row['memberID']." data-toggle='modal' data-target='#deleteModal' style= 'margin-left:15px'  width='25px' height='25px' src='images/circle-trash.svg'/>";      
        echo "</td>";
        echo "</tr>";
    }
    ?>

</table>
<span style="display: flex;justify-content: center;margin-top:40px;"><a href='newMember.php'><button id="btn3" onmouseover="changeCol(this.id)" onmouseout="changeBack(this.id)" class="secondBtn">Add Member <img id="grn_btn3" class="svgGreen" style="vertical-align:middle;float:right;margin-left:10px;margin-bottom:20px;" width="25px" height="25px" src="images/circle-plus.svg" /></button></a></span>

<!-- delete confirm modal -->
<div class="modal" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header" >
        <h5 class="modal-title" style="text-align:center;font-weight:bold;font-size:20px;margin-left:200px" id="exampleModalLabel">Confirm</h5>
        <button type="button" size=20 class="btn-close " data-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
          <div class="text-center" style="margin-left:30px">
           <h4><b>Are you sure you want to delete this member?</b></h4>
          </div>
      </div>
      <form action='' method="POST" id= 'deleteForm'>
        <input type="hidden" id="command" name="command" value="">
        <input type="hidden" id="memberid" name="memberid" value = "">
    </form>

      <div class="modal-footer d-flex justify-content-center" style="margin-bottom:20px">
        <button type="button" class="cancelBtn" data-dismiss="modal" style="margin-top:20px;">Cancel</button>
        <button type="button" onclick="submitForm()" class="secondBtn" style="margin-top:20px;margin-left:30px;padding:10px;height:45px;width:180px">Confirm</button>

    </div>

    </div>
  </div>
</div>



</body>
</html>