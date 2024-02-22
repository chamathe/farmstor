<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="templates/product.css">

<?php include("templates/header.php"); ?>

<?php

// Get the product ID   
$product_id = $_GET['product_id'];

// Prepare and execute the query
$productQuery = "SELECT * FROM product WHERE product_id = $product_id";
$productResult = mysqli_query($conn, $productQuery);
$productRow = mysqli_fetch_assoc($productResult);

$pname = $productRow['product_name'];
$unit = $productRow['unit'];
$price = $productRow['price'];
$available = $productRow['available'];
$description = $productRow['description'];
$category_id = $productRow['category_id'];
$image = $productRow['image'];
$farmerId = $productRow['farmer_id'];

// Fetch farms from farmser table
$farmerQuery1 = "SELECT * FROM farmertb WHERE farmer_id = $farmerId ";
$farmerResult1 = mysqli_query($conn, $farmerQuery1);
$farmerRow1 = mysqli_fetch_assoc($farmerResult1);

$farm = $farmerRow1['farm'];

// Fetch categories from category table
$categoryQuery1 = "SELECT * FROM categories WHERE category_id = $category_id ";
$categoryResult1 = mysqli_query($conn, $categoryQuery1);
$categoryRow1 = mysqli_fetch_assoc($categoryResult1);

$category = $categoryRow1['category'];

?>

<div class="product-main">
<?php include("../buyer/templates/goback.php"); ?> 
    <div class="product-image-container">
        <img class="product-image" src="uploads\<?php echo $image ?>" alt="Product Image">
    </div>
    <div class="product-container">

        <div class="product-details">
            <h1><?php echo $pname ?></h1>
            <small><?php echo $category?></small>

            <p class="owner-line">By: <b class="owner"><?php echo $farm ?> </b></p>

            <p><?php echo $description ?></p>
            <p class="price">£ <?php echo $price ?> <small>per unit</small></p>
            <p class="price"><?php echo $available?> <?php echo $unit?> available</p>


        </div>
    </div>
</div>

<?php include("templates/footer.php"); ?>

</html>