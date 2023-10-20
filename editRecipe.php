<?php

include "head.php";


$_SESSION['recp_id'] = $_GET['id'];

$sql = "select * from recipes where recp_id = ".$_SESSION['recp_id']."";
$res = mysqli_query($con,$sql);
$row = mysqli_fetch_array($res);

$_SESSION['recp_name'] = $row['name'];
$_SESSION['servings'] = $row['servings'];
$_SESSION['instructions'] = $row['instructions'];


$q = "SELECT fi.Description as 'desc', ri.quantity as 'quantity', ri.ingredi_id as 'rowID' 
FROM `recipes` as r
join recipe_ingredients as ri on r.recp_id = ri.recp_id
join food_items as fi on ri.foodID = fi.foodID
WHERE ri.recp_id = ".$_SESSION['recp_id']."";

$result = mysqli_query($con,$q);


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['command2']) && $_POST['command2'] == "addFood" ) {

   $recp_id = $_SESSION['recp_id'];

   
   $_SESSION['instructions'] = $_POST['instructSave'];

   $sql = "INSERT INTO `recipe_ingredients`(`recp_id`, `foodID`, `quantity`) VALUES ('".$recp_id."','".$_POST['searchResults']."',".$_POST['quant'].")";
   $res = mysqli_query($con, $sql);

  if (!$res) {
        die($sql);
  }
      $sq = "SELECT fi.Description as 'desc', ri.quantity as 'quantity', ri.ingredi_id as 'rowID' 
    FROM `recipes` as r
    join recipe_ingredients as ri on r.recp_id = ri.recp_id
    join food_items as fi on ri.foodID = fi.foodID
    WHERE ri.recp_id = ".$recp_id."";

    $result = mysqli_query($con,$sq);

    
    

    
} else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['command3']) && $_POST['command3'] == "delete"){

  

      $qz = "DELETE FROM `recipe_ingredients` WHERE ingredi_id = ".$_POST['ingred_id']."";
      $rez = mysqli_query($con,$qz);
      if(!$rez) {
        die($qz);
      } else {

        $recp_id = $_SESSION['recp_id'];

        $q = "SELECT fi.Description as 'desc', ri.quantity as 'quantity', ri.ingredi_id as 'rowID' 
        FROM `recipes` as r
        join recipe_ingredients as ri on r.recp_id = ri.recp_id
        join food_items as fi on ri.foodID = fi.foodID
        WHERE ri.recp_id = ".$recp_id."";
    
        $result = mysqli_query($con,$q);

        
      }
} else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['command']) && $_POST['command'] == "save") {

  $_SESSION['recp_name'] =$_POST['recp_name'];
  $_SESSION['instructions'] =$_POST['instruct'];
  $_SESSION['servings'] =$_POST['servings'];


  $sql = "UPDATE recipes AS r
  SET
      name = '".$_SESSION['recp_name']."',
      servings ='".$_SESSION['servings']."',
      instructions = '".$_SESSION['instructions']."', 
      carbs_ps = COALESCE(
          (SELECT SUM(ri.quantity * fi.Carbohydrates / r.servings) /100
           FROM recipe_ingredients AS ri
           JOIN food_items AS fi ON ri.foodID = fi.foodID
           WHERE ri.recp_id = r.recp_id), 0),
      fats_ps = COALESCE(
          (SELECT SUM(ri.quantity * fi.Fats / r.servings) /100
           FROM recipe_ingredients AS ri
           JOIN food_items AS fi ON ri.foodID = fi.foodID
           WHERE ri.recp_id = r.recp_id), 0),
      protein_ps = COALESCE(
          (SELECT SUM(ri.quantity * fi.Proteins / r.servings) /100
           FROM recipe_ingredients AS ri
           JOIN food_items AS fi ON ri.foodID = fi.foodID
           WHERE ri.recp_id = r.recp_id), 0),
    calories_ps = COALESCE (
        (r.carbs_ps * 4) + (r.protein_ps * 4)+ (r.fats_ps * 9)
      )
      WHERE recp_id = ".$_SESSION['recp_id']."";

  $r = mysqli_query($con,$sql);

  if(!$r){
    die($sql);
  } else {
     echo "<script>window.location.href='myRecipes.php' </script>";
  }

 

}

?>


<script>

function activeTab() {
    var link = document.getElementById('1');
    link.outerHTML = '<a id="1" style="height:70px" href="myRecipes.php" class="btn btn-outline-success active" aria-current="page">My Recipes</a>';
  };

  function openModal() {
    $('#createRecpModal').modal('toggle');
  }

  function check() {

      $('#exampleModal').modal('show');    
    
  }

  function performSearch() {
    
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
   
        const query = searchInput.value;

        // Clear previous search results
        searchResults.innerHTML = '<option style="font-family:sans-serif;width:100px" value="" disabled selected>Select a product</option>';

        // Send an AJAX request to the server to retrieve search results
        if (query.length > 2) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'search.php?query=' + query, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = xhr.responseText;
                    const results = JSON.parse(response);                 

                    if (results.length > 0) {

                      document.getElementById('dropdown').style.display = "block";
                      
                      document.getElementById('dropdown').focus();
                     
                      results.forEach(function(result) {
                       
                        const cleanedID =result.foodID.replace(/"/g, '');
                        const cleanedDescription =result.Description.replace(/"/g, '');

                            const option = document.createElement('option');
                            option.style.fontFamily="sans-serif";
                            option.value =   cleanedID;
                            option.textContent = cleanedDescription // Set the text to the product name
                            option.style.width = '100px';

                            searchResults.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.textContent = 'No results found';
                        searchResults.appendChild(option);
                    }
                }
            };
            xhr.send();
        }    
  }


 function addFood () {

  var instructVal = document.getElementById('instruct').value;

  document.getElementById('instructSave').value = instructVal;

  var dropd = document.getElementById('searchResults');
  var command = document.getElementById('command2');
  command.value="addFood";
  var form = document.getElementById('searchForm');
  form.submit();
 }

  function deleteFood(id) {

      var form = document.getElementById('deleteForm');
      document.getElementById('ingred_id').value=id;
      document.getElementById('command3').value="delete";
      form.submit();
  }


  function saveRecipe() {

    document.getElementById('command').value = "save";
    var form = document.getElementById("createForm");
    form.submit();
  }

</script>

<div class="container-fluid" style=" text-align:center; height:80px">
  <h3 class='pageTitle' style='color:#47D7BD'> Editing Recipe - <?=$_SESSION['recp_name']?></h3>
  <a href="myRecipes.php" ><img id='backArrow' class="svgGreen2" style="float:left;position:relative;bottom:40px" width="40px"
        height="40px" src="images/circle-arrow-left.svg" /></a>
</div>
</div>






<!-- add ingredient modal -->
<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header" style="background-color:#03cf68;">
        <h4 class="modal-title" style="color:white;font-weight:bold;font-size:24px;margin-left:160px"
          id="exampleModalLabel">Food Search</h4>
        <button type="button" size=20 class="btn-close " data-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" style="margin-left:40px;font-size:15px;">
        <form id="searchForm" action="" method="POST">
          <input type="hidden" class="form-control" style="" name="command2" id="command2">
          <input type="hidden" class="form-control" style="" name="instructSave" id="instructSave">
          <div class="mb-3" style="margin-left:30px">
            <div class="row">
              <div class="col-2">
                <label for="food-search" class="col-form-label">Ingredient:</label>
                <input type="text" class="form-control" style="width:320px; margin-top:10px;padding:20px"
                  name="searchInput" id="searchInput" placeholder="type food description and search">
              </div>
              <div class="col-2">      
                <img id="" type="button" onclick="performSearch()" class="svgGray"
                  style="margin-left:280px;margin-right:30px;margin-top:43px" width="30px" height="30px"
                  src="images/magnifying-glass.svg" />
              </div>

              <div id='dropdown'class="col-2" style="width:300px; positon:relative; right:350px; display:none">
                    <select name="searchResults" class="custom-select" style="padding-left:15px;border:1px solid gainsboro; margin-top:2px;width:320px;height:40px;background-color:white" id="searchResults">
                    <optgroup style="font-size:20px">
                      <option id='opt' value="" disabled selected>Select a product</option>
                    </optgroup>
                    </select>
                    
              </div>

            </div>
          </div>
          <div class="mb-3" style="margin-left:30px">
            <div class="row">
              <div class="col-5">
                <label class="col-form-label">Quantity (grams):</label>

                <input type="number" style="width:320px;padding:20px; margin-top:10px" class="form-control"
                  id="quant" name="quant" />

              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer d-flex justify-content-center">
        <button type="button" onclick="addFood()" class="secondBtn" style="height:50px;padding:5px;width:200px">Add Food</button>
      </div>

    </div>
  </div>
</div>
<!-- /add ingredient modal -->



    <form action='' method="POST" id="createForm" name="createForm">

      <div class="container-fluid"
        style="margin:0px;text-align:center; width:100%; border:solid 2px gainsboro; height:135px">

        <div class="row">
          <input type='hidden' name="command" id="command" value="" />
          <div class="col-md-9" style="margin-top:20px;margin-left:100px">
            <label for="recp_name" class="col-sm-2 col-form-label"
              style="color:#47D7BD;font-size:18px;font-weight:bold">Recipe Name:</label>
            <div class="col-sm-1">
              <input type="text" class="form-control" style='width:250px' id="recp_name" name="recp_name"
                placeholder="what is the recipe name?" value="<?= $_SESSION['recp_name'] ?>">
            </div>
          </div>
          <div class="col-md-9" style="margin-top:20px;margin-left:100px">
            <label for="servings" class="col-md-2 col-form-label"
              style="color:#47D7BD;font-size:18px; positon:flex; right:20px">Servings:</label>
            <div class="col-sm-1">
              <input type="number" style='width:250px' class="form-control" id="servings" name="servings"
                placeholder="How many servings?" value="<?= $_SESSION['servings'] ?>">
            </div>
          </div>

        </div>


        <div>
          <button id="btn2" type="button" class="thirdBtn" style="position:absolute; top:330px;right:230px"
            onmouseover="changeCol(this.id)" onmouseout="changeBack(this.id)" onclick="check()">Add ingredients
            <img id="grn_btn2" class="svgGreen" style="vertical-align:middle;float:right;margin-left:10px" width="25px"
              height="25px" src="images/circle-plus.svg" />
          </button>
        </div>



    
  </div>


  <div class="row mr-auto">
    <label class="col" style="color:#CDB03C; margin-top:30px;margin-left:145px">Ingredients</label>

    <label class="col-auto" style="margin-top:30px;margin-right:350px;color:#CDB03C">Instructions</label>
  </div>

  <div class="row mr-auto container-fluid">
  <div class="col">
    <div style='width:530px; margin-left:130px'>
      <table class='' style="">
  <?php 

    if(isset($result)) {

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
      echo "<td>";
      echo "<img class='svgRed' onclick='deleteFood(".$food['rowID'].")' style= 'margin-left:15px'  width='25px' height='25px' src='images/circle-trash.svg'/>";
      echo "</td>";
      echo "</tr>";     

    }
    }
   

  ?>

      </table>
    </div>
  </div>
  <textarea class="col-auto" style='padding-top:10px;height:150px;width:350px;margin-right:90px;margin-bottom:100px;' id="instruct" name="instruct"
    placeholder="e.g 1. chop vegetables" form="createForm"><?php  echo $_SESSION['instructions']; ?></textarea>
    </form>


  <div class="text-center" style="margin-bottom:30px;margin-top:50px;position:relative; bottom:0px;">
    <button class='thirdBtn' type="button" onclick="saveRecipe()"
      style="height:50px;width:200px">SAVE</button>
  </div>

</div> <!--end hide content-->



<form id='deleteForm' method='post'>
  <input type="hidden" id="command3" name="command3">
  <input type="hidden" id="ingred_id" name="ingred_id">
</form>  
</body>
</html>