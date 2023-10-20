<?php 
 
// Load the database configuration file 
include_once 'dbSettings.php'; 

$id = $_GET['id'];
 
// Fetch records from database 
$query = $con->query("SELECT
    r.name,
    r.servings,
    r.calories_ps,
    r.carbs_ps,
    r.fats_ps,
    r.protein_ps,
    r.instructions
FROM recipes as r
WHERE r.recp_id = ".$id."");

// Fetch ingredients for the recipe
$query2 = $con->query("SELECT fi.Description as description, ri.quantity as quantity
FROM `recipes` as r
JOIN recipe_ingredients as ri ON r.recp_id = ri.recp_id
JOIN food_items as fi ON ri.foodID = fi.foodID
WHERE ri.recp_id = ".$id."");
 
if($query->num_rows > 0){ 
    $delimiter = ","; 
    
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 

    fputcsv($f, array('Recipe Name','Servings','Calories (per serve)','Carbohydrates','Fats','Protein'), $delimiter);
    while ($row = $query->fetch_assoc()) {
        fputcsv($f, array($row['name'],$row['servings'],$row['calories_ps'],$row['carbs_ps'],$row['fats_ps'],$row['protein_ps']), $delimiter);
        $instruct = $row['instructions'];    
        $name = "MyRecipe_".$row['name']."_";
    }
    $filename = $name . date('d-M-y') . ".csv";
    fputcsv($f, array('', ''), $delimiter);
    fputcsv($f, array('Ingredient', 'Quantity'), $delimiter);
    while ($row = $query2->fetch_assoc()) {
        
        fputcsv($f, array($row['description'], ceil($row['quantity'])." grams"), $delimiter);   
        
        
    }
    fputcsv($f, array('', ''), $delimiter);
    fputcsv($f, array('Instructions','' ), $delimiter);
    fputcsv($f, array($instruct, ''), $delimiter);

     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>