<?php
include("templates/header.php");

//import age function
include("age.php");

$sqlfav = "SELECT * FROM favtb WHERE buyer_id = '$buyer_id'";

$resfav = mysqli_query($conn, $sqlfav);

$countfav = mysqli_num_rows($resfav);

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="templates/favourite.css">
<title>Favourites</title>
<div class="main">
<?php include("templates/goback.php"); ?> 
    <div class="title-area">
        <h1>Your Favourite Items</h1>
        <hr>
    </div>
    <div class="container">


        <?php
        if ($countfav > 0) {
            foreach ($resfav as $item) {

                $productId = $item['product_id'];
                $sqlcartproducts = "SELECT * FROM product WHERE product_id = $productId";
                $rescartproducts = mysqli_query($conn, $sqlcartproducts);

                foreach ($rescartproducts as $product) { ?>
                    <a href="product.php?product_id=<?php echo $productId ?>" class="card">
                        <img src="../farmer/uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>">
                        <div class="card-content">
                            <div class="title-farm">
                                <?php
                                // include famrer table details to get farmer details
                                $farmer_id = $product['farmer_id'];
                                include("templates/farmer.php");
                                ?>
                                <h2 class="card-title"><?php echo $product['product_name']; ?></h2>
                                <small> (<?php echo $farmerRow['farm'] ?>)</small>
                            </div>

                            <?php
                            // include category table details to get category name
                            $category_id = $product['category_id'];
                            include("templates/cat.php");
                            ?>
                            <div class="category-display"><?php echo $categoryRow['category'] ?></div>

                            <div class="shelf-time">current shelf time - <?php echo getAge($product['timestamp']); ?></div>

                            <div class="product-unit">Unit: <?php echo $product['unit']; ?></div>
                            <div class="product-price"><b>£ <?php echo $product['price']; ?></b><small> per unit</small> </div>
                            <div class="available-units">Available: <?php echo $product['available']; ?> <?php echo $product['unit']; ?></div>
                            <form action="" class="action-btn" method="POST">
                                <button name="add-cart-fav" id="add-cart-fav"><img src="../images/cart.png" alt=""></button>
                                <input type="hidden" name="farmer_id" id="farmer_id" value="<?php echo $product['farmer_id'] ?>">
                                <input type="hidden" name="category_id_cart" id="category_id_cart" value="<?php echo $category_id; ?>">
                                <input type="hidden" name="product_id_cart" id="product_id_cart" value="<?php echo $product['product_id'] ?>">
                                

                                <button name="delete-fav"  value="<?php echo $item['item_id']; ?>"><img src="../images/remove.png" alt=""></button>
                            </form>
                        </div>
                    </a>
            <?php }
            }
        } else { ?>
            <div class="errormsg">
                <h2> No favourites added </h2>
            </div>
        <?php  } ?>


    </div>


</div>

</html>