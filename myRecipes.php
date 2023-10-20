<?php
include "head.php";

    $name = $_SESSION['fullname'];
    $memb_id = $_SESSION['member_id'];  

    $sql = "Select * FROM recipes where memberID='".$memb_id."'";
    $res = mysqli_query($con, $sql);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['command'] == "delete") {

        $recpid= $_POST['recpid'];

        $q="DELETE FROM recipes WHERE recp_id= ".$recpid."";
        $r=mysqli_query($con,$q);

        echo (!$r ? die($q) : "<script>window.location.href='myRecipes.php'</script>");
       
    }


?>

<script>
    function activeTab() {
        var link = document.getElementById('1');
        link.outerHTML = '<a id="1" style="height:70px" href="myRecipes.php" class="btn btn-outline-success active" aria-current="page">My Recipes</a>';
    };
    function confirmExit() {
        var link = document.getElementById('1');
        link.outerHTML = '<a id="1" style="height:70px" href="myRecipes.php" class="btn btn-outline-success active" aria-current="page">My Recipes</a>';
    };

    function rowFocus(row) {
        var cells = row.getElementsByTagName('td');
        for (var i = 0; i < cells.length; i++) {
            cells[i].style.border = "#03cf68";
            cells[i].style.color = "#03cf68";
        }
    }

    function rowUnfocus(row) {
        var cells = row.getElementsByTagName('td');
        for (var i = 0; i < cells.length; i++) {
            cells[i].style.border = "";
            cells[i].style.color = "";
        }
    }

    function viewRecp(id) {

    window.location.href="recipeDetails.php?id="+id;  

    }


    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('svgRed')) {
            
            // Retrieve the row ID from the clicked button's data attribute
            var rowID = e.target.getAttribute('data-rowid');
            
            // Store the row ID for use in your modal logic
            var modalRowID = rowID;
          
            document.getElementById('recpid').value=modalRowID;
            document.getElementById('command').value="delete";   
        }
    });
 

    function submitForm() {
        var form =document.getElementById('deleteForm');
        form.submit();    
    }

</script>

<div class="container-fluid" style="text-align:center; border-color:gainsboro; height:80px">
    <h3>Welcome,
        <?php echo $name ?>
    </h3>
</div>

<!-- delete confirm modal -->
<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header" >
        <h5 class="modal-title" style="font-weight:bold;font-size:20px;margin-left:180px" id="exampleModalLabel">Confirm</h5>
        <button type="button" size=20 class="btn-close " data-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
          <div class="mb-3" style="margin-left:30px">
           <h4><b>Are you sure you want to delete this recipe?</b></h4>
          </div>
      </div>
      <form action='' method="POST" id= 'deleteForm'>
        <input type="hidden" id="command" name="command" value="">
        <input type="hidden" id="recpid" name="recpid" value = "">
    </form>

      <div class="modal-footer d-flex justify-content-center" style="margin-bottom:20px">
        <button type="button" class="cancelBtn" data-dismiss="modal" style="margin-top:20px;">Cancel</button>
        <button type="button" onclick="submitForm()" class="secondBtn" style="margin-top:20px;margin-left:30px;padding:10px;height:45px;width:180px">Confirm</button>

    </div>

    </div>
  </div>
</div>

<div class="container-fluid" >
<table class="table table-border ">
    <tr>
        <thead>
            <th class='theader' scope="col">Recipe</th>
            <th class='theader' scope="col">Carbs</th>
            <th class='theader' scope="col">Fats</th>
            <th class='theader' scope="col">Protein</th>
            <th class='theader' scope="col">Calories</th>
            <th class='theader' scope="col">Action</th>
        </thead>
    </tr>
    <?php 

    
    while ($row = mysqli_fetch_assoc($res)) {

        echo "<tr id='recipe_" . $row['recp_id'] . "'  onmouseover='rowFocus(this)' onmouseout='rowUnfocus(this)' >";
        echo "<td onclick='viewRecp(".$row['recp_id'].")' >";
        echo $row['name'];
        echo "</td>";
        echo "<td onclick='viewRecp(".$row['recp_id'].")'>";
        echo $row['carbs_ps'];
        echo "</td>";
        echo "<td onclick='viewRecp(".$row['recp_id'].")'>";
        echo $row['fats_ps'];
        echo "</td>";
        echo "<td onclick='viewRecp(".$row['recp_id'].")'>";
        echo $row['protein_ps'];
        echo "</td>";
        echo "<td onclick='viewRecp(".$row['recp_id'].")'>";
        echo ceil($row['calories_ps']);
        echo "</td>";
        echo "<td>";
        echo "<a href='editRecipe.php?id=".$row['recp_id']."' ><img class='svgGray' style='margin-right:20px' width='25px' height='25px' src='images/pen-circle.svg'/></a>  <img class='svgRed' data-rowid=".$row['recp_id']." data-toggle='modal' data-target='#exampleModal' style= 'margin-left:15px'  width='25px' height='25px' src='images/circle-trash.svg'/>";      
        echo "</td>";
        echo "</tr>";
    }
    ?>

</table>
<span style="display: flex;justify-content: center;margin-top:40px;"><a href='newRecipe.php'><button id="btn3" onmouseover="changeCol(this.id)" onmouseout="changeBack(this.id)" class="secondBtn">Create Recipe <img id="grn_btn3" class="svgGreen" style="vertical-align:middle;float:right;margin-left:10px" width="25px" height="25px" src="images/circle-plus.svg" /></button></a></span>

</div>

</div>


</body>
</html>