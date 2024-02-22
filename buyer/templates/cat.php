<?php 
$categoryQuery = "SELECT * FROM categories WHERE category_id=$category_id ";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categoryRow = mysqli_fetch_assoc($categoryResult);

?>