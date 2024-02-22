<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="templates/cart.css">

<?php
include("templates/header.php");
include("delete-cart.php");
include("update-cart.php");
include("record-cart.php");
?>
 <?php include("templates/goback.php"); ?> 
<div class="title-area">
    <h1>Your Cart</h1>
    <hr>
</div>

<div class="cart-container">

    <form action="" method="POST">
        <?php
        if ($item_count > 0) {
            $totalprice = 0;
            foreach ($resitemcount as $item) {

                $productId = $item['product_id'];
                $sqlcartproducts = "SELECT * FROM product WHERE product_id = $productId";
                $rescartproducts = mysqli_query($conn, $sqlcartproducts);

                foreach ($rescartproducts as $product) {
        ?>
                    <div class="cart-item">
                        <img src="../farmer/uploads/<?php echo $product['image']; ?>" alt="Product 1">
                        <div>
                            <h3><?php echo $product['product_name']; ?></h3>
                            <?php
                            $farmer_id = $product['farmer_id'];
                            $sqlfarmer = "SELECT * from farmertb WHERE farmer_id = $farmer_id";
                            $resfarmer = mysqli_query($conn, $sqlfarmer);
                            $rowfarmer = mysqli_fetch_assoc($resfarmer);
                            $farm = $rowfarmer['farm'];
                            $delivery = $rowfarmer['delivery'];
                            ?>
                            <p>By: <a href="farm.php?farmer_id=<?php echo $farmer_id; ?>"><?php echo $farm; ?></a></p>
                        </div>

                        <div style="text-align: center;">
                            <p>Price: <b class="price">£ <?php echo $product['price'] * $item['quantity']; ?></b></p>
                            <div class="quantity-unit">
                                <input name="spinner[<?php echo $product['product_id']; ?>]" class="spinner" type="number" value="<?php echo $item['quantity']; ?>">
                                <p><?php echo $product['unit']; ?></p>
                            </div>
                            <input name="product_id[<?php echo $productId ?>]" type="hidden" value="<?php echo $productId ?>">
                        </div>
                        <button name="delete" class="trashcan" value="<?php echo $item['item_id']; ?>"><img src="../images/delete.png" alt=""></button>



                    </div>
            <?php }

                $totalprice += $product['price'] * $item['quantity'];
            } ?>

            <div class="delivery">
                <?php
                if ($delivery === "Yes") { ?>

                    <div class="delivery-yes">
                        <p>This farmer offers delivery (5% delivery fee) </p>
                        <div class="checkbox">

                            <?php
                            $sqldelcheck = "SELECT * FROM carttb WHERE  buyer_id = $buyer_id LIMIT 1";
                            $resdelcheck = mysqli_query($conn, $sqldelcheck);
                            $arraydelcheck = mysqli_fetch_assoc($resdelcheck);
                            $delcheck = $arraydelcheck['delivery'];

                            ?>
                            <p>Get your items delivered?</p><input type="checkbox" name="checkbox" value="1" <?php echo ($delcheck === 'Yes') ? 'checked' : ''; ?>>

                        </div>
                    </div>
                    <?php if($delcheck === 'Yes'){ ?>
                    <div class="update-cart-section">
                        <input type="submit" value="↺ Update Cart" name="update-cart" class="update-cart">
                        <div class="cost-list">
                            <div class="sub-cost"><p>Order Cost:</p><p class="amount">£ <?php echo $totalprice; ?></p> </div> 
                            <div class="sub-cost"><p>Delivery Cost: </p><p class="amount" >£ <?php echo $totalprice * 0.05; ?></p></div>
                            <p class="tcost">Total Cost: <b class="tamount">£ <?php echo $totalprice * 1.05; ?></b> </p>
                        </div>

                    </div> <?php } else {?>
                        <div class="update-cart-section">
                        <input type="submit" value="↺ Update Cart" name="update-cart" class="update-cart">
                        <p class="tcost" >Total Cost: <b >£ <?php echo $totalprice; ?></b> </p>
                    </div>

                        <?php }} else { ?>

                    <p>This farmer do not offer delivery*</p>
                    <div class="update-cart-section">
                        <input type="submit" value="↺ Update Cart" name="update-cart" class="update-cart">
                        <p class="tcost">Total Cost: <b >£ <?php echo $totalprice; ?></b> </p>
                    </div>

                <?php }  ?>

            </div>

            <?php if ($buyer_id > 0) { ?>
                <input type="hidden" name="buyer" value="<?php echo $buyer_id ?>">
                <button name="pcheckout" class="pcheckout-btn">Proceed to Checkout</button>
            <?php  } else { ?>
                <a class="cart-not-logged" href="index.php">Login to order items</a>
            <?php } ?>
    </form>

<?php
        } else { ?>
    <div class="errormsg">
        <h2>Your Cart is empty!!</h2>
    </div>

<?php
        }
        if ($item_count == 0) { ?>
</div>
<hr style="margin-bottom: 7.5rem;">
<?php  }
?>
</div>




<?php include("templates/footer.php"); ?>


</html>