<!DOCTYPE html>
<html lang="en">
<?php include("templates/header.php"); ?>


<title>Farm Page</title>
<link rel="stylesheet" href="templates/home.css">


<?php
// Sql query to delete items
if (isset($_POST['delete'])) {
  $id_to_delete = $_POST['id_to_delete'];
  $sqldelete = "DELETE FROM product WHERE product_id=$id_to_delete";

  if (mysqli_query($conn, $sqldelete)) {
    // Deletion successful
  } else {
    echo 'query error: ' . mysqli_error($conn);
  }
}


?>


<div class="profile-container">
  <img class="restaurant-image" src="uploads/<?php echo $rowfarmer['image']; ?>" alt="Update your profile">
  <div class="restaurant-details">
    <div class="profile-top">
      <h2><?php echo $rowfarmer['farm']; ?></h2>
      <div class="profile-delivery">Delivery - <strong><?php echo $rowfarmer['delivery']; ?></strong></div>
    </div>


    <div class="contact-info">
      <p><?php echo $rowfarmer['address']; ?> (<?php echo $rowfarmer['postcode']; ?>)</p>

    </div>
    <hr>


    <ul class="category-profile">

      <li><a href="home.php">All</a></li>
      <?php
      // Fetch categories from category table
      $categoryQuery = "SELECT * FROM categories";
      $categoryResult = mysqli_query($conn, $categoryQuery);

      foreach ($categoryResult as $category) {
        $category_id = $category['category_id'];
        $productQuerytop = "SELECT * FROM product WHERE category_id=$category_id AND farmer_id = $farmer_id";
  $productResulttop = mysqli_query($conn, $productQuerytop);
  $productCounttop = mysqli_num_rows($productResulttop);

      ?> 
        <li class="category-list" ><a href="home.php?category_id=<?php echo $category['category_id']; ?>"><?php echo $category['category']; ?> <b class="cat-count" ><?php echo $productCounttop?></b> </a></li>
      <?php } ?>
    </ul>

  </div>
</div>

<a class="add-products-btn" href="add-product.php"><img class="edit-icon" src="..\images\add.png" alt=""> Add Products</a>
<?php

if (isset($_GET['category_id'])) {

  $category_id = $_GET['category_id'];

  // Fetch products from products table
  $productQuery = "SELECT * FROM product WHERE farmer_id=$farmer_id AND category_id=$category_id ";
  $productResult = mysqli_query($conn, $productQuery);
  $productCount = mysqli_num_rows($productResult);

if ( $productCount > 0) {
  foreach ($productResult as $product) {
    ?>
        <div class="product-container">
          <div class="product-card">
    
            <a class="product-image" href="product.php?product_id=<?php echo $product['product_id'] ?>  ">
              <img src="uploads/<?php echo $product['image']; ?>" alt="Product image">
            </a>
    
            <div class="product-details">
              <div>
                <div class="product-name"><?php echo $product['product_name']; ?></div>
    
                <?php
                $category_id = $product['category_id'];
                // Fetch relevant category from category table
                $categoryQuery1 = "SELECT * FROM categories WHERE category_id = $category_id ";
                $categoryResult1 = mysqli_query($conn, $categoryQuery1);
                $categoryRow1 = mysqli_fetch_assoc($categoryResult1);
                ?>
    
                <div class="category-display"><?php echo $categoryRow1['category'] ?></div>
              </div>
              <div class="product-unit">Unit: <?php echo $product['unit']; ?></div>
              <div class="product-price"><b>£ <?php echo $product['price']; ?></b><small> per unit</small> </div>
              <div class="available-units">Available: <?php echo $product['available']; ?> <?php echo $product['unit']; ?></div>
            </div>
            <form class="action-btn" method="POST">
              <a href="edit-product.php?product_id=<?php echo $product['product_id'] ?>"><img src="../images/edit.png" alt=""></a>
              <input type="hidden" name="id_to_delete" id="id_to_delete" value="<?php echo $product['product_id'] ?>">
              <button name="delete" id="delete"><img src="../images/delete.png" alt=""></button>
            </form>
          </div>
    
        </div>
      <?php }
    
} else { ?>
    <div class="errormsg" > 
<h2> No products added  </h2>
<hr style="margin-bottom: 7.5rem;">
</div>
<?php } } else {

  // Fetch products from products table
  $productQuery = "SELECT * FROM product WHERE farmer_id=$farmer_id ";
  $productResult = mysqli_query($conn, $productQuery);
  $productCount = mysqli_num_rows($productResult);

if ( $productCount > 0) {
  foreach ($productResult as $product) {
    ?>
        <div class="product-container">
          <div class="product-card">
    
            <a class="product-image" href="product.php?product_id=<?php echo $product['product_id'] ?>  ">
              <img src="uploads/<?php echo $product['image']; ?>" alt="Product image">
            </a>
    
            <div class="product-details">
              <div>
                <div class="product-name"><?php echo $product['product_name']; ?></div>
    
                <?php
                $category_id = $product['category_id'];
                // Fetch relevant category from category table
                $categoryQuery1 = "SELECT * FROM categories WHERE category_id = $category_id ";
                $categoryResult1 = mysqli_query($conn, $categoryQuery1);
                $categoryRow1 = mysqli_fetch_assoc($categoryResult1);
                ?>
    
                <div class="category-display"><?php echo $categoryRow1['category'] ?></div>
              </div>
              <div class="product-unit">Unit: <?php echo $product['unit']; ?></div>
              <div class="product-price"><b>£ <?php echo $product['price']; ?></b><small> per unit</small> </div>
              <div class="available-units">Available: <?php echo $product['available']; ?> <?php echo $product['unit']; ?></div>
            </div>
            <form class="action-btn" method="POST">
              <a href="edit-product.php?product_id=<?php echo $product['product_id'] ?>"><img src="../images/edit.png" alt=""></a>
              <input type="hidden" name="id_to_delete" id="id_to_delete" value="<?php echo $product['product_id'] ?>">
              <button name="delete" id="delete"><img src="../images/delete.png" alt=""></button>
            </form>
          </div>
    
        </div>
      <?php }
    
} else { ?>
<div class="errormsg" > 
<h2> No products added </h2>
<hr style="margin-bottom: 7.5rem;">
</div>
    
<?php }
} ?>

<?php include("templates/footer.php"); ?>

</html>