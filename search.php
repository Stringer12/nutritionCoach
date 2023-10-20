<?php
// Connect to your database (you'll need your database connection code here)
include 'dbSettings.php';

// Get the search query from the JavaScript
$query = $_GET['query'];

// Perform a MySQL query to search for products based on the query
$sql = "SELECT * FROM food_items WHERE `Description` LIKE '%" . $query . "%'";
$result = $con->query($sql);

$results = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
}

// Return results as JSON
echo json_encode($results);

// Close the database connection
$con->close();
?>
