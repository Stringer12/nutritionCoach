<?php

include "head.php";

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if ($_POST['command'] == "createFood") {



        $carbs = $_POST['carbs'];
        $fats = $_POST['fat'];
        $prot = $_POST['prot'];
        $cals = $_POST['cals'];

        $brand = $_POST['brand'];
        $serving_size = $_POST['servings'];
        $description = $_POST['desc'];

        $description = "$brand - $description";

        $sql = "insert into food_items (`Description`, `Carbohydrates`, `Fats`, `Proteins`, `Calories`) VALUES (


            '" . $description . "',
            
            ($carbs / $serving_size * 100),
            
            (" . $fats . " / " . $serving_size . ") * 100,
            
            (" . $prot . " / " . $serving_size . ") * 100,
            
            (" . $cals . " / " . $serving_size . ") * 100
            
            
            );";

        $res = mysqli_query($con, $sql);

        if (!$res) {
            die($sql);
        } else {

            $msg = "Successfully Created Food!";


            ?>
            <script>
                setTimeout(() => {
                    const box = document.getElementById('msg');

                    // 👇️ removes element from DOM
                    box.style.display = 'none';

                }, 4000); // 👈️ time in milliseconds                    
            </script>
            <?php


        }
    }
}
?>

<script>
    function activeTab() {
        var link = document.getElementById('3');
        link.outerHTML = ' <a id="3"href="addFood.php" class="btn btn-outline-success active" >Add Food <img class="img-fluid svgWhite" style="float:right;margin-right:10px" width="30px" height="30px" src="images/circle-plus.svg" /></a>';
    };

    function submitForm() {

        var form = document.getElementById('addFoodForm');
        var command = document.getElementById('command');

        command.value = "createFood";

        form.submit();

    } 
</script>


<div class="container-fluid" style="text-align:center; height:80px">
    <h3 class='pageTitle'>Add New Food Item</h3>
</div>
</div>


<div class="container-fluid" style="margin:0px;text-align:center; width:100%; border:solid 2px gainsboro; height:135px">
    <div class="container" style="padding-top:20px;">
        <form id="addFoodForm" action="" method="POST">
            <div class="row">
                <div class="col">
                    <label for="recp_name" class="form-label"
                        style="display:inline;color:#CDB03C;font-size:18px;font-weight:bold;margin-right:10px;">Brand
                        Name:</label>
                    <input type="text" class="form-control" style='display:inline;width:250px' name="brand"
                        placeholder="what is the brand?" value="">
                </div>
                <div class="col" style="">
                    <label for="recp_name" class="form-label"
                        style="display:inline;color:#CDB03C;font-size:18px;font-weight:bold;margin-right:35px;width:120px">Serving
                        size(grams):</label>
                    <input type="text" class="form-control" style='display:inline;width:250px' name="servings"
                        placeholder="e.g 50" value="">
                </div>
                <div class="w-100"></div>
                <div class="col" style="padding-top:20px;">
                    <label for="recp_name" class="form-label"
                        style="display:inline;color:#CDB03C;font-size:18px;font-weight:bold;margin-right:19px;width:120px">Description:</label>
                    <input type="text" class="form-control" style='display:inline;width:250px' name="desc"
                        placeholder="e.g Pams strawberry jam" value="">
                </div>
                <div class="col" style="padding-top:20px;">
                    <label for="recp_name" class="form-label"
                        style="display:inline;color:#CDB03C;font-size:18px;font-weight:bold;margin-right:10px;width:120px">Servings
                        per container:</label>
                    <input type="text" class="form-control" style='display:inline;width:250px' id="per_container"
                        placeholder="e.g 10" value="">
                </div>
            </div>
    </div>
</div>


<div class="d-flex justify-content-center" style="padding:30px; ">
    <div class="box">
        <div class="containerVert">
            <h3 class='pageTitle'>Nutrition Facts</h3>

            <div class="row" style="border-bottom:1px gainsboro solid; width:350px; margin-top:40px;">
                <div class="col">
                    <div class="text-left">
                        <label style="float:left;display:inline-block;width:195px;font-size:19px">Calories</label>
                    </div>
                    <input class=" form-control" id="cals" name="cals" style="display:inline-block; width:140px;"
                        type="text">
                </div>
            </div>

            <div class="row" style="border-bottom:1px gainsboro solid; width:350px; margin-top:10px; ">
                <div class="col">
                    <div class="text-left">
                        <label style="float:left;display:inline-block;width:195px;font-size:19px">Total Fat(g)</label>
                    </div>
                    <input class=" form-control" id="fat" name="fat" style="display:inline-block; width:140px;"
                        type="text">
                </div>
            </div>

            <div class="row" style="border-bottom:1px gainsboro solid; width:350px; margin-top:10px; ">
                <div class="col">
                    <div class="text-left">
                        <label
                            style="float:left;display:inline-block;width:195px;font-size:19px">Carbohydrates(g)</label>
                    </div>
                    <input class=" form-control" id="carbs" name="carbs" style="display:inline-block; width:140px;"
                        type="text">
                </div>
            </div>
            <div class="row" style="border-bottom:1px gainsboro solid; width:350px; margin-top:10px;">
                <div class="col">
                    <div class="text-left">
                        <label style="float:left;display:inline-block;width:195px;font-size:19px">Protein(g)</label>
                    </div>

                    <input class=" form-control" id="prot" name="prot" style="display:inline-block; width:140px;"
                        type="text">
                    <input type="hidden" id="command" name="command">
                </div>
            </div>
            <div class="row text-center" style="width:350px; margin-top:30px; ">
                <div class="col">
                    <button type="button" onclick='submitForm()' class="btn btn-outline-success"
                        style="height:50px;border-radius:8px;">SAVE</button>
                </div>
                <!-- button save form-->

            </div>

            </form>

        </div>
    </div>

</div>

<div class="d-flex justify-content-center" style="margin-bottom:20px;">
    <input type="text" style="border:none;display:block" id='msg' class="row message" value="<?php echo $msg; ?>">
</div>

</body>
</html>