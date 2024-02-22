<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/checkout.css">
    <title>Checkout Page</title>
    <?php include("templates/header.php");
    ?>
    <?php
    $cart = $_SESSION["cart"];
   
    include("payment-method.php") 
    ?>

<?php include("templates/goback.php"); ?> 
    <form action="checkout.php" method="POST">

        <div class="title-area">
            <h1>Checkout Details</h1>
            <hr>
        </div>
        <div class="container">
            <h2 style="margin-top: -0.5rem; font-family: 'Lato', sans-serif !important; ">Your contact details</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required value="<?php echo $rowbuyer['fname']; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required value="<?php echo $rowbuyer['email']; ?>">

            <label for="email">Telephone:</label>
            <input type="telephone" id="telephone" name="telephone" required value="<?php echo $rowbuyer['telephone']; ?>">
        </div>


        <?php
        $sqldelcheck = "SELECT * FROM carttb WHERE  buyer_id = $buyer_id LIMIT 1";
        $resdelcheck = mysqli_query($conn, $sqldelcheck);
        $arraydelcheck = mysqli_fetch_assoc($resdelcheck);
        $delcheck = $arraydelcheck['delivery'];
        $farmer_id = $arraydelcheck['farmer_id']; ?>

        <input name="delivery" type="hidden" value="<?php echo $delcheck; ?>">
        <input name="farmer_id" type="hidden" value="<?php echo  $farmer_id; ?>">

        <?php if ($delcheck === 'Yes') {
        ?>
            <div class="container">
                <h2 style="margin-top: -0.5rem; font-family: 'Lato', sans-serif !important; ">You have chosen to deliver to your address...</h2>

                <label for="address">Delivery Address:</label>
                <input type="text" id="address" name="address" required value="<?php echo $rowbuyer['address']; ?>">

                <label for="postcode">Delivery Post Code:</label>
                <input type="text" id="postcode" name="post_code" required value="<?php echo $rowbuyer['postcode']; ?>">
            </div> <?php } ?>

        <div class="container">
            <h2 style="margin-top: -0.5rem; font-family: 'Lato', sans-serif !important; ">Your Order Summary</h2>
            <?php include("templates/farmer.php") ?>
            <h3>Order from : <?php echo $farmerRow['farm'] ?></h3>
            <table class="order-summary-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Ordered Quantity</th>
                        <th>Total Item Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalprice = 0;
                    foreach ($resitemcount as $item) {

                        $productId = $item['product_id'];
                        $sqlcartproducts = "SELECT * FROM product WHERE product_id = $productId";
                        $rescartproducts = mysqli_query($conn, $sqlcartproducts);

                        foreach ($rescartproducts as $product) {
                    ?>

                            <tr class="order-detail-checkout">
                                <td><?php echo $product['product_name']; ?></td>
                                <td><?php echo $item['quantity']; ?> <?php echo $product['unit']; ?></td>
                                <td><strong>£ <?php echo $item['quantity'] * $product['price']; ?></strong></b></td>
                            </tr>

                    <?php $totalprice += $product['price'] * $item['quantity'];
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php if ($delcheck === 'Yes') { 
               $totprice = $totalprice * 1.05 ; 
                ?>
                <div class="update-cart-section">
                    <div class="cost-list">
                        <div class="sub-cost">
                            <p>Order Cost:</p>
                            <p class="amount">£ <?php echo $totalprice; ?></p>
                        </div>
                        <div class="sub-cost">
                            <p>Delivery Cost: </p>
                            <p class="amount">£ <?php echo $totalprice * 0.05; ?></p>
                        </div>
                        <p class="tcost">Total Cost: <b class="tamount">£ <?php echo $totprice; ?></b> </p>
                        <input name="cost" type="hidden" value="<?php echo $totprice; ?>">
                    </div>

                </div>
            <?php } else { ?>
                <div class="update-cart-section">
                    <p class="tcost">Total Cost: <b>£ <?php echo $totalprice; ?></b> </p> <?php } ?>
                <input name="cost" type="hidden" value="<?php echo $totalprice; ?>">
                </div>
        </div>


        <div class="container">
            <h2 style="margin-top: -0.5rem; font-family: 'Lato', sans-serif !important; ">Select Payment Method</h2>
            <Select style="margin-bottom: 3rem;" name="payment_method">
                <option value="0"></option>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
            </Select>
            <button name="next" class="porder" type="submit">Next</button>
        </div>

    </form>



    <?php include("templates/footer.php"); ?>

</html>