<?php

session_start();
include "dbSettings.php";

$error='';
$memb_id = '';
$pass ='';

if(isset($_GET['state']) && $_GET['state'] == 'logOut'){

  $logout = "Successfully Logged out";
  ?>
  <script>
      setTimeout(() => {
          const box = document.getElementById('p1');

          // 👇️ removes element from DOM
          box.style.display = 'none';

      }, 4000); // 👈️ time in milliseconds                    
  </script>
  <?php

} else {
  $logout = "Please Login";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['memb_id']) && isset($_POST['pass'])) {
    $memb_id = $_POST['memb_id'];
    $pass = $_POST['pass'];

    if (empty($memb_id) || empty($pass)) {
      $error = "You must enter both Member ID and Password.";

    } else if ($memb_id == "admin") {

      $sql = "SELECT * FROM admin WHERE username = '$memb_id' AND password = '$pass'";

      $result = mysqli_query($con, $sql);
  
      if (mysqli_num_rows($result) == 1) {
  
        $row = mysqli_fetch_assoc($result);
  
        if ($row['username'] == $memb_id && $row['password'] == $pass) {
  
          
          Header("Location: adminPortal.php");
        } 
      } else {
        $error = "ID or password is incorrect";
        
      }




    } else {
      $sql = "SELECT * FROM members WHERE memberID = '$memb_id' AND password = '$pass'";

      $result = mysqli_query($con, $sql);
  
      if (mysqli_num_rows($result) == 1) {
  
        $row = mysqli_fetch_assoc($result);
  
        if ($row['memberID'] == $memb_id && $row['password'] == $pass) {
  
          
          Header("Location: myRecipes.php");
  
          $_SESSION['fullname'] = $row['firstName'] . " " . $row['lastName'];
          $_SESSION['member_id'] = $row['memberID'];
        } 
      } else {
        $error = "ID or password is incorrect";
        
      }
    }

   
  } 

}



?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>The Nutrition Coach</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
</head>

<body>

  <div class="container-fluid">

    <div style="text-align: center;padding-right:20px">
      <image width="700" height="95" class="img-fluid" src="images/logo light.png"></image>
    </div>
    <div>
      <p class="p1" id='p1' style="display:block;padding-bottom:30px;"><?= $logout ?> </p>
    </div>
    <div class="card mx-auto class">
      <div class="card-body mx-auto class">

        <form action="" method="post">
          <div class="form-group">

            <label for="memb_id">Member ID:</label>

            <input style="height:43px; width:280px" type="text" class="form-control" name="memb_id"
              placeholder="Enter ID" value=<?= $memb_id ?>>

          </div>
          <div class="form-group">

            <label for="pass">Password</label>
            <input style="height:45px; margin-bottom:40px" type="password" class="form-control" name="pass"
              placeholder="Password" value=<?= $pass ?>>

          </div>

          

          <button style="width:280px" align="center" type="submit" class="btn btn-outline-success">Login</button>

          
        </form>
      </div>
      <p style="font-weight:bold;color:#D22B2B; margin-top:20px;margin-right:auto;margin-left:auto"><?php echo $error ?></p>
    </div>
  </div>
</body>
</html>