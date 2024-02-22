<!DOCTYPE html>
<html lang="en">
<?php include("templates/header.php"); ?>

<?php
$farmer_id = $_GET['farmer_id'];
// Fetch farms from farmertb
$farmQuery = "SELECT * FROM farmertb WHERE farmer_id=$farmer_id";
$farmResult = mysqli_query($conn, $farmQuery);
$farmRow = mysqli_fetch_assoc($farmResult);


//import age function
include("age.php")

?>


<title>Farm Page</title>
<link rel="stylesheet" href="templates/farm.css">


<div class="profile-container">

  <img class="restaurant-image" src="../farmer/uploads/<?php echo $farmRow['image']; ?>" alt="Restaurant Image">
  <div class="restaurant-details">
    <div class="profile-top">
      <h1><?php echo $farmRow['farm']; ?></h1>
      <div class="profile-delivery"><b>Delivery - <?php echo $farmRow['delivery']; ?></b></div>
    </div>

    <div class="contact-info">
      <h2><strong><?php echo $farmRow['fname']; ?></strong></h2>
      <p>Email: <strong><?php echo $farmRow['email']; ?></strong></p>
      <p>Phone: <strong><?php echo $farmRow['telephone']; ?></strong></p>
      <p>Address: <strong><?php echo $farmRow['address']; ?> (<?php echo $farmRow['postcode']; ?>) </strong></p>
    </div>
    <hr>
    <ul class="category-profile">
      <li><a href="farm.php?farmer_id=<?php echo $farmer_id ?>">All</a></li>
      <?php
      // Fetch categories from the category table
      $categoryQuery = "SELECT * FROM categories";
      $categoryResult = mysqli_query($conn, $categoryQuery);

      foreach ($categoryResult as $category) {
        $category_id = $category['category_id'];
        $productQuerytop = "SELECT * FROM product WHERE farmer_id=$farmer_id AND category_id=$category_id ";
        $productResulttop = mysqli_query($conn, $productQuerytop);
        $productCounttop = mysqli_num_rows($productResulttop);

        // Check if the current category ID matches the selected category ID in the URL
        $selectedCategoryID = isset($_GET['category_id']) ? $_GET['category_id'] : null;
        $isSelected = ($selectedCategoryID == $category['category_id']) ? 'selected' : '';
      ?>
        <li class="category-list <?php echo $isSelected; ?>">
          <a href="farm.php?farmer_id=<?php echo $farmer_id; ?>&amp;category_id=<?php echo $category['category_id']; ?>">
            <?php echo $category['category']; ?>
            <b class="cat-count"><?php echo $productCounttop ?></b>
          </a>
        </li>
      <?php } ?>
    </ul>

  </div>
</div>

<?php

if (isset($_GET['category_id'])) {

  $category_id = $_GET['category_id'];

  // Fetch products from products table
  $productQuery = "SELECT * FROM product WHERE farmer_id=$farmer_id AND category_id=$category_id ";
  $productResult = mysqli_query($conn, $productQuery);
  $productCount = mysqli_num_rows($productResult);

  if ($productCount > 0) {
    foreach ($productResult as $product) {
?>
      <div class="product-container">
        <div class="product-card">

          <a class="product-image" href="product.php?product_id=<?php echo $product['product_id'] ?>  ">
            <img src="../farmer/uploads/<?php echo $product['image']; ?>" alt="Product image">
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

              <?php
              $timestamp = $product['timestamp'];

              ?>

              <div class="shelf-time">current shelf time - <?php echo getAge($timestamp); ?></div>
            </div>
            <div class="product-unit">Unit: <?php echo $product['unit']; ?></div>
            <div class="product-price"><b>£ <?php echo $product['price']; ?></b><small> per unit</small> </div>
            <div class="available-units">Available: <?php echo $product['available']; ?> <?php echo $product['unit']; ?></div>
          </div>

          <form action="" class="action-btn" method="POST">
            <button name="add-cart" id="add-cart" ><img src="../images/cart.png" alt=""></button>
            <input type="hidden" name="farmer_id" id="farmer_id" value="<?php echo $product['farmer_id'] ?>">
            <input type="hidden" name="category_id_cart" id="category_id_cart" value="<?php echo $category_id; ?>">
            <input type="hidden" name="product_id_cart" id="product_id_cart" value="<?php echo $product['product_id'] ?>">
            <button name="fav" id="fav"><img src="../images/fav.png" alt=""></button>
          </form>

        </div>

      </div>
    <?php }
  } else { ?>
    <div class="errormsg">
      <h2> No products added by farmers </h2>
    </div>
    <?php }
} else {

  // Fetch products from products table
  $productQuery = "SELECT * FROM product WHERE farmer_id=$farmer_id ";
  $productResult = mysqli_query($conn, $productQuery);
  $productCount = mysqli_num_rows($productResult);

  if ($productCount > 0) {
    foreach ($productResult as $product) {
    ?>
      <div class="product-container">
        <div class="product-card">

          <a class="product-image" href="product.php?product_id=<?php echo $product['product_id'] ?>  ">
            <img src="../farmer/uploads/<?php echo $product['image']; ?>" alt="Product image">
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

              <?php
              $timestamp = $product['timestamp'];

              ?>

              <div class="shelf-time">current shelf time - <?php echo getAge($timestamp); ?></div>
            </div>
            <div class="product-unit">Unit: <?php echo $product['unit']; ?></div>
            <div class="product-price"><b>£ <?php echo $product['price']; ?></b><small> per unit</small> </div>
            <div class="available-units">Available: <?php echo $product['available']; ?> <?php echo $product['unit']; ?></div>
          </div>

          <form action="" class="action-btn" method="POST">
            <button name="add-cart" id="add-cart" ><img src="../images/cart.png" alt=""></button>
            <input type="hidden" name="farmer_id" id="farmer_id" value="<?php echo $farmer_id ?>">
            <input type="hidden" name="product_id_cart" id="product_id_cart" value="<?php echo $product['product_id'] ?>">
            <button name="fav" id="fav"><img src="../images/fav.png" alt=""></button>
          </form>

        </div>

      </div>
    <?php }
  } else { ?>
    <div class="errormsg">
      <h2> No products added by farmers </h2>
    </div>

<?php }
} ?>

<?php include("templates/footer.php"); ?>

</html>