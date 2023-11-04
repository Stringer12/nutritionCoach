<?php

include "head.php";


$msg='';

$id = $_GET['id'];

$sql = "select * from recipes where recp_id = $id";
$res = mysqli_query($con,$sql);
$row = mysqli_fetch_array($res);


$q = "SELECT fi.Description as 'desc', ri.quantity as 'quantity' 
FROM `recipes` as r
join recipe_ingredients as ri on r.recp_id = ri.recp_id
join food_items as fi on ri.foodID = fi.foodID
WHERE ri.recp_id = $id";

$result = mysqli_query($con,$q);


if($_SERVER['REQUEST_METHOD'] == "POST") {
  $servingsLogged=$_POST['servingsLogged'];

  $sql="INSERT INTO `logged_recipe`(recp_id, date_logged, total_calories) VALUES (1, CURRENT_DATE, (SELECT calories_ps from recipes where recp_id = ".$id.")*".$servingsLogged." );";

$result = mysqli_query($con,$sql);

if(!$res) {
  echo "something went wrong";
} else {

  $msg= "Logged Recipe!";
  ?>
  <script>
      setTimeout(() => {
          const box = document.getElementById('p1');

          // 👇️ removes element from DOM
          box.style.display = 'none';

      }, 2500); // 👈️ time in milliseconds                    
  </script>
  <?php


$sql = "select * from recipes where recp_id = $id";
$res = mysqli_query($con,$sql);
$row = mysqli_fetch_array($res);


$q = "SELECT fi.Description as 'desc', ri.quantity as 'quantity' 
FROM `recipes` as r
join recipe_ingredients as ri on r.recp_id = ri.recp_id
join food_items as fi on ri.foodID = fi.foodID
WHERE ri.recp_id = $id";

$result = mysqli_query($con,$q);
}
}

?>



<script>
  function activeTab() {
    var link = document.getElementById('1');
    link.outerHTML = '<a id="1" style="height:70px" href="myRecipes.php" class="btn btn-outline-success active" aria-current="page">My Recipes</a>';
  }

  function openModal() {
    document.getElementById("exampleModal").style.display = "block";
  }

  function closeModal() {
    document.getElementById("exampleModal").style.display = "none";
  }

  function logRecipe (id) {

    var form =document.getElementById('logForm');
    var command = document.getElementById('command');

    command.value=id;

    form.submit();

  }

  function openModal2() {
    $('#logRecpModal').modal('toggle');
  }

</script>


<div id='page' class="container-fluid" style="text-align:center; height:80px">
  <div class="row">
    <div class="col-1">
      <a href="myRecipes.php" ><img id='backArrow' class="svgGreen2" style="vertical-align:middle;float:left;margin-top:10px" width="40px"
        height="40px" src="images/circle-arrow-left.svg" /></a>
    </div>
    <div class="col-10">
      <h3 class='pageTitle' style="color:#CDB03C;margin-top:15px;">Recipe Details</h3>
    </div>
  </div>


</div>
</div>

<div class="container-fluid" style="margin:0px;text-align:center; width:100%; border:solid 2px gainsboro; height:135px">


<div class="row">
    <div class="col-md-9" style="margin-top:20px;margin-left:50px">
      <label for="recp_name" class="col-sm-3 col-form-label"
        style="color:#404040;font-size:18px;font-weight:bold"><?php echo $row['name']; ?></label>
    </div>
    <div class="col">
      
    </div>
    <div class="col-md-9" style="margin-top:20px;margin-left:40px">
      <label for="servings" class="col-sm-3 col-form-label"
        style="color:#404040;font-size:18px;"><?php echo $row['servings']; ?> Servings</label>
    </div>
  </div>

  <div class="containerHori" style="position:relative; top:-110px">
 <div class="circle green" style="margin-right:10px"><label> <?php echo $row['calories_ps']; ?> <br> Cal</label></div>
 <div class="circle gold" style="margin-right:10px"><label> <?php echo $row['carbs_ps']; ?> <br> Carbs</label></div>
 <div class="circle blue" style="margin-right:10px"><label> <?php echo $row['fats_ps']; ?>  <br> Fats</label></div>
 <div class="circle purple" style="margin-right:10px"><label> <?php echo $row['protein_ps']; ?>  <br> Protein</label></div>
</div>

  <div>
    <a href='exportData.php?id=<?=$id?>'><button id="exportbtn" onclick=''class="thirdBtn" style="width:180px;height:45px;position:absolute; top:310px;right:120px;" >Export
    </button></a>
  </div>
</div>

<div class="row mr-auto">
  <label class="col" style="color:#404040; margin-top:30px;margin-left:165px">Ingredients</label>
  <label class="col-auto" style="margin-top:30px;margin-right:350px;color:#404040">Instructions</label>
</div>

<div class="row mr-auto container-fluid">

  <div class="col">
    <div style='width:530px; margin-left:130px'>
      <table class='' style="">
  <?php 


    while ($food = mysqli_fetch_assoc($result)){

      if (strlen($food['desc']) > 40) {
        $margin = "position:relative;right:10px";
      } else {
        $margin = "";
      }
      echo "<tr style='border-bottom: solid 1px gainsboro'>";
      echo "<td style='float:left;$margin;'>";      
      echo $food['desc'];
      echo "</td>";
      echo "<td>";
      echo "<div style='float:right;width:125px;'>". number_format($food['quantity'],0) . " Grams"."</div>";
      echo "</td>";
      echo "</tr>";     

    }

  ?>

      </table>
    </div>
  </div>
  <textarea readonly class="col-auto" style='padding-top:10px;height:150px;width:350px;margin-right:90px;margin-bottom:100px;' id=""
    placeholder=""> <?php echo $row['instructions']; ?></textarea>

    <h1 class="p1" id='p1' style="color:#03cf68;font-size:30px;display:block;margin-bottom:10px;margin-left:30px"><?=$msg;?></h1>

    <div class="text-center" style="margin-bottom:30px;margin-top:50px;position:relative; bottom:0px;left:25px">
    <button id=<?= $id?> class='thirdBtn' type="button" onclick="openModal2()" style="height:50px;width:200px">LOG RECIPE</button>
  </div>

  <!-- log recipie modal -->
<div class="modal" id="logRecpModal" tabindex="-1" aria-labelledby="logRecpModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#03cf68;">

        <h4 class="modal-title" style="color:white;font-weight:bold;font-size:24px;margin-left:160px">Log Recipe</h4>
        <button type="button" size=20 class="btn-close " data-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body" style="margin-left:40px;font-size:15px;">

        <form id="logForm" action="" method="POST">
          <input type="hidden" class="form-control" style="" name="command" id="command">

          <div class="mb-3" style="margin-left:30px">
            <div class="row">
              <div class="col">
                <label class="col-form-label" style="margin-top:30px">How many Servings?</label>

                <input type="number" style="width:320px;padding:20px; margin-top:10px;margin-bottom:30px" class="form-control"
                  id="servingsLogged" name="servingsLogged" placeholder="Enter the number of servings eaten..." />

              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" onclick="logRecipe(<?=$id?>)" class="secondBtn"
          style="height:50px;padding:5px;width:200px">Log</button>
      </div>

    </div>
  </div>
</div>
<!-- /Create recipie modal -->

<form id="submitForm">
  <input type='hidden' id='command' name='command'>
</form>
</div>
</body>
</html>