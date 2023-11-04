<?php

include "head.php";

$days='';

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['filter'])){
  $days = $_GET['filter'];
}

if(empty($days)){
    $days= "7";
}

$sql = "SELECT r.name, lr.date_logged, lr.total_calories FROM `logged_recipe`as lr join recipes as r on lr.recp_id = r.recp_id WHERE lr.date_logged BETWEEN CURDATE() - INTERVAL ".$days." DAY AND CURDATE();";

$result = $con->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$labels = [];
$values = [];

foreach ($data as $row) {
    $date = strtotime($row['date_logged']);

    $labels[] = [$row['name'],date('d-M-y',$date)];
    $values[] = $row['total_calories'];
}
?>


<script>

 
    function activeTab() {
        var link1 = document.getElementById('4');
        link1.outerHTML = ' <a id="4" href="statistics.php" class="btn btn-outline-success active" >My Stats <img class="img-fluid svgWhite" style="float:right;margin-right:10px" width="30px" height="30px" src="images/chart-column.svg" /></a>';
    };

    function activeFilter(id,name) {

        var link1 = document.getElementById(id);
        link1.outerHTML = '<button id="'+id+'" class="btn btn-outline-success active"  onclick="submitForm('+id+')" type="button">'+name+'</button>';
    };

    function submitForm(days) {

        var form = document.getElementById('dateFilterForm');
        var command = document.getElementById('command');
        command.value = days;
       
        const urlParams = new URLSearchParams(window.location.search);

        urlParams.set('filter', days);
        form.submit();
        window.location.search = urlParams;
    } 

    $( document ).ready(function () {
      
      const searchParams = new URLSearchParams(window.location.search);
      var filter = searchParams.get('filter');

      if(filter == 7 || filter== null ) {
        activeFilter(7,"Past Week");
      } else if (filter == 14) {
        activeFilter(14, "Past Fortnight");
      } else {
        activeFilter(31, "Past Month");
      }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class="container-fluid" style="text-align:center; height:80px">
    <h3 class='pageTitle'>Statistics</h3>
</div>

<nav class="navbar navbar" style="height:60px; border-bottom:1px gainsboro solid; background-color:white">
  <form class="form-inline">
    <button id='7' class="btn btn-outline-success"  onclick='submitForm(7)' type="button">Past Week</button>
    <button id='14' class="btn btn-outline-success" onclick='submitForm(14)' type="button">Past Fortnight</button>
    <button id='31' class="btn btn-outline-success" onclick='submitForm(31)' type="button">Past Month</button>
  </form>
</nav>

<div style="margin-left:25%;width:50%; height:50%; margin-top:30px;margin-bottom:30px">
  <canvas id="myChart"></canvas>
</div>

<script>
  const ctx = document.getElementById('myChart');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($labels)?>,
      datasets: [{
        label: 'Total Caloires Logged',
        data: <?php echo json_encode($values)?>,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<form id="dateFilterForm" method="POST">
    <input type="hidden" name="command" id="command" value=''>
</form>

</div>
</body>
</html>