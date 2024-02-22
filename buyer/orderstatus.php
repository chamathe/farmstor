<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/orderstatus.css">

    <?php include("templates/header.php");

    $sqlcart = "SELECT * FROM carttb WHERE buyer_id = $buyer_id";
    $rescart = mysqli_query($conn, $sqlcart);
    $rowcart = mysqli_num_rows($rescart);

    $sqlstatus = "SELECT * FROM checkout_tb WHERE buyer_id = $buyer_id ORDER BY order_id DESC LIMIT 1";

    $resultstatus = mysqli_query($conn, $sqlstatus);
    

    
    if ($resultstatus) {
        $row = mysqli_fetch_assoc($resultstatus);
    } else {
        echo "Query failed: " . mysqli_error($conn);
    }

     //get farmer details
     $farmer_id = $row['farmer_id'];
     include("templates/farmer.php");


    if (isset($_POST["confirm"])) {
        $id_to_delete = $buyer_id;
        $sqldelete = "DELETE FROM carttb WHERE buyer_id=$id_to_delete";
        $order_status = "Pending";

        if (mysqli_query($conn, $sqldelete)) {
            $checkout_id = $row['order_id'];
            $sqlcheckout = "UPDATE checkout_tb SET order_status = '$order_status' WHERE order_id=$checkout_id";
            if (mysqli_query($conn, $sqlcheckout)) {
                header("Location:confirm.php");
            } else {
                echo 'query error: ' . mysqli_error($conn);
            }
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }



    ?>



    <div class="container">


        <div class="title-area">
            <h1><?php echo $farmerRow['farm'] ?></h1>
            <hr>
        </div>
        
        <h2>Order # <?php echo $row['order_id'] ?></h2>
        <p>Name: <strong><?php echo $row['name'] ?></strong></p>
        <p>Email: <strong><?php echo $row['email'] ?></strong></p>
        <p>Telephone: <strong><?php echo $row['telephone'] ?></strong></p>
        <p>Date: <strong><?php echo date("d-M-Y", strtotime($row['timestamp'])) ?></strong></p>

        <div class="payment">
            <?php if ($row['payment_method']=='Card'){ ?>
        <p>Payment completed</p>
           <?php } else {?>
            <p>Pay in Cash</p>
<?php } ?>
        </div>


        <table class="order-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Item Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalCost = 0;
                foreach ($rescart as $cartitem) {

                    $product_id = $cartitem['product_id'];
                    $resproduct = mysqli_query($conn, "SELECT * FROM product WHERE product_id=$product_id ");
                    $rowproduct = mysqli_fetch_assoc($resproduct);


                    foreach ($resproduct as $item) {
                        $totalItemCost = $cartitem['quantity'] * $item['price'];
                        $totalCost += $totalItemCost;
                        echo '<tr>';
                        echo '<td><img src="../farmer/uploads/' . $item['image'] . '" alt="Product Image"></td>';
                        echo '<td>' . $item['product_name'] . '</td>';
                        echo '<td>' . $cartitem['quantity'] . ' ' . $item['unit'] .  '</td>';
                        echo '<td>$' . number_format($item['price'] * $cartitem['quantity'], 2) . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total items cost :</strong></td>
                    <td>£<?php echo number_format($totalCost, 2); ?></td>
                </tr>
            </tfoot>
        </table>

        <?php
        $delivery = $row['delivery'];
        if ($delivery == "Yes") {
        ?>
            <div class="cost-list">
                <div class="sub-cost">
                    <p>Order Cost:</p>
                    <p class="amount">£ <?php echo number_format($totalCost, 2); ?></p>
                </div>
                <div class="sub-cost">
                    <p>Delivery Cost: </p>
                    <p class="amount">£ <?php echo number_format($totalCost * 0.05, 2); ?></p>
                </div>
                <p class="tcost">Total Cost: <b class="tamount">£ <?php echo number_format($totalCost * 1.05, 2);  ?></b> </p>
    
            </div>
            <p>Del Address: <strong> <?php echo $row['delivery_address'] ?> (<?php echo $row['postcode'] ?>) </strong></p>

        <?php } else { ?>
            <div class="cost-list">
            <p class="tcost">Total Cost: <b class="tamount">£ <?php echo number_format($totalCost, 2);  ?></b> </p>
        </div>
        <p>Pickup Address: <strong> <?php echo $farmerRow['address'] ?> (<?php echo $farmerRow['postcode'] ?>) </strong></p>
      <?php  } ?>


        

        <form action="" method="POST">

            <?php if ($rowcart > 0) { ?>
                <div>
                    <input type="hidden" name="totalCost" value="<?php echo $totalCost ?>">
                    <button name="confirm">Confirm</button>
                </div>
            <?php } else { ?>

            <?php } ?>

        </form>

    </div>


    <?php include("templates/footer.php"); ?>

</html>