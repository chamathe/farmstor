<!DOCTYPE html>
<html lang="en">
<title>Orders</title>
<?php include("templates/header.php"); ?>


<?php 
if(isset($_POST['statusc'])){
    $change_id = $_POST['change_id'];
    $comment = htmlspecialchars($_POST['comments']);
    $status = htmlspecialchars($_POST['status']);

    
    $sqlstatus = "UPDATE checkout_tb SET order_status='$status', comment='$comment' WHERE order_id = $change_id  ";

    if(mysqli_query($conn,$sqlstatus)) {
        header("Location:orders.php");
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
}


?>

<?php
$sqlall = "SELECT * FROM checkout_tb WHERE farmer_id = $farmer_id  ORDER BY order_id DESC";
$resultall = mysqli_query($conn, $sqlall);

$sqlpending = "SELECT * FROM checkout_tb WHERE farmer_id = $farmer_id AND order_status='Pending' ORDER BY order_id DESC";
$resultpending = mysqli_query($conn, $sqlpending);

$sqlapproved = "SELECT * FROM checkout_tb WHERE farmer_id = $farmer_id AND order_status='Approve' ORDER BY order_id DESC";
$resultapproved = mysqli_query($conn, $sqlapproved);

$sqlcompleted = "SELECT * FROM checkout_tb WHERE farmer_id = $farmer_id AND order_status='Complete' ORDER BY order_id DESC";
$resultcompleted = mysqli_query($conn, $sqlcompleted);


$sqlrejected = "SELECT * FROM checkout_tb WHERE farmer_id = $farmer_id AND order_status='Reject' ORDER BY order_id DESC";
$resultrejected = mysqli_query($conn, $sqlrejected);


?>

<link rel="stylesheet" href="templates/orders.css">


<nav class="main">
    <button onclick="showOrders('all')">All Orders</button>
    <button onclick="showOrders('pending')">Pending Orders</button>
    <button onclick="showOrders('approved')">Approved Orders</button>
    <button onclick="showOrders('completed')">Completed Orders</button>
    <button onclick="showOrders('rejected')">Rejected Orders</button>
</nav>
<?php include("../buyer/templates/goback.php"); ?> 
<section>
    <div class="orders-container" id="allOrders">
        <h2>All Orders</h2>
        <div class="order-list">
            <?php foreach ($resultall as $orders) {
                $buyer_id = $orders['buyer_id'];
                include('templates/buyer.php')
            ?>
                <div class="order-item">
                    <div class="top">
                        <h3 class="order_id">Order # <?php echo $orders['order_id'] ?></h3>
                        <h3 class="farm"><?php echo $buyerRow['fname'] ?></h3>
                        <h3 class="status"><?php echo $orders['order_status'] ?></h3>

                    </div>
                    <div class="item-details">
                        <p class="array">(<?php echo $orders['product_array'] ?>)</p>
                        <p class="tcost">Total Cost : <?php echo number_format($orders['cost'], 2) ?></p>
                    </div>

                    <div class="bottom">
                        <div class="payment">
                            <?php if ($orders['payment_method'] == 'Card') { ?>
                                <p class="card">Payment completed</p>
                            <?php } else { ?>
                                <p class="cash">Pay in Cash</p>
                            <?php } ?>
                        </div>
                        <div class="delivery">
                            <?php if ($orders['delivery'] == 'Yes') { ?>
                                <p class="delivery">Delivery on - <?php echo $orders['delivery_address'] ?>(<?php echo $orders['postcode'] ?>)</p>
                            <?php } else { ?>
                                <p class="pickup">Pickup at - <?php echo $rowfarmer['address'] ?>(<?php echo $rowfarmer['postcode'] ?>)</p>
                            <?php } ?>
                        </div>

                    </div>
                    <div class="action">
                        <?php if ($orders['order_status'] == 'Pending' or $orders['order_status'] == 'Approve') { ?>
                            <div class="confirm-order">
                                <form action="" method="POST">
                                    <select name="status" id="status">
                                        <option value="0">Action required</option>
                                        <option value="Approve">Approve</option>
                                        <option value="Reject">Reject</option>
                                        <option value="Complete">Complete</option>
                                    </select>
                                    <input type="hidden" value="<?php $orders['order_id']  ?>" >
                                    <input type="text" name="comments" placeholder="Massage for the buyer" >
                                    <input name='change_id' type="hidden" value="<?php echo $orders['order_id']  ?>" >
                                    <button name="statusc" >Submit</button>
                                </form>
                            </div>

                        <?php } else { ?>

                        <?php  } ?>
                    </div>

                </div>

            <?php } ?>
        </div>
    </div>


    <div class="orders-container" id="pendingOrders" style="display: none;">
        <h2>Pending Orders</h2>
        <div class="order-list">
            <?php foreach ($resultpending as $orders) {
                $buyer_id = $orders['buyer_id'];
                include('templates/buyer.php')
            ?>

                <div class="order-item">
                    <div class="top">
                        <h3 class="order_id">Order # <?php echo $orders['order_id'] ?></h3>
                        <h3 class="farm"><?php echo $buyerRow['fname'] ?></h3>
                        <h3 class="status"><?php echo $orders['order_status'] ?></h3>
                    </div>
                    <div class="item-details">
                        <p class="array">(<?php echo $orders['product_array'] ?>)</p>
                        <p class="tcost">Total Cost : <?php echo number_format($orders['cost'], 2) ?></p>
                    </div>

                    <div class="bottom">
                        <div class="payment">
                            <?php if ($orders['payment_method'] == 'Card') { ?>
                                <p class="card">Payment completed</p>
                            <?php } else { ?>
                                <p class="cash">Pay in Cash</p>
                            <?php } ?>
                        </div>
                        <div class="delivery">
                            <?php if ($orders['delivery'] == 'Yes') { ?>
                                <p class="delivery">Delivery on - <?php echo $orders['delivery_address'] ?>(<?php echo $orders['postcode'] ?>)</p>
                            <?php } else { ?>
                                <p class="pickup">Pickup at - <?php echo $rowfarmer['address'] ?>(<?php echo $rowfarmer['postcode'] ?>)</p>
                            <?php } ?>
                        </div>

                    </div>
                    <div class="action">
                        <?php if ($orders['order_status'] == 'Pending' or $orders['order_status'] == 'Approve') { ?>
                            <div class="confirm-order">
                                <form action="" method="POST">
                                    <select name="status" id="status">
                                        <option value="0">Action required</option>
                                        <option value="Approve">Approve</option>
                                        <option value="Reject">Reject</option>
                                        <option value="Complete">Complete</option>
                                    </select>
                                    <input type="hidden" value="<?php $orders['order_id']  ?>" >
                                    <input type="text" name="comments" placeholder="Massage for the buyer" >
                                    <input name='change_id' type="hidden" value="<?php echo $orders['order_id']  ?>" >
                                    <button name="statusc" >Submit</button>
                                </form>
                            </div>

                        <?php } else { ?>

                        <?php  } ?>
                    </div>
                    

                </div>


            <?php } ?>
        </div>
    </div>

    <div class="orders-container" id="approvedOrders" style="display: none;">
        <h2>Approved Orders</h2>
        <div class="order-list">
            <?php foreach ($resultapproved as $orders) {
                $buyer_id = $orders['buyer_id'];
                include('templates/buyer.php')
            ?>

                <div class="order-item">
                    <div class="top">
                        <h3 class="order_id">Order # <?php echo $orders['order_id'] ?></h3>
                        <h3 class="farm"><?php echo $buyerRow['fname'] ?></h3>
                        <h3 class="status"><?php echo $orders['order_status'] ?></h3>
                    </div>
                    <div class="item-details">
                        <p class="array">(<?php echo $orders['product_array'] ?>)</p>
                        <p class="tcost">Total Cost : <?php echo number_format($orders['cost'], 2) ?></p>
                    </div>

                    <div class="bottom">
                        <div class="payment">
                            <?php if ($orders['payment_method'] == 'Card') { ?>
                                <p class="card">Payment completed</p>
                            <?php } else { ?>
                                <p class="cash">Pay in Cash</p>
                            <?php } ?>
                        </div>
                        <div class="delivery">
                            <?php if ($orders['delivery'] == 'Yes') { ?>
                                <p class="delivery">Delivery on - <?php echo $orders['delivery_address'] ?>(<?php echo $orders['postcode'] ?>)</p>
                            <?php } else { ?>
                                <p class="pickup">Pickup at - <?php echo $rowfarmer['address'] ?>(<?php echo $rowfarmer['postcode'] ?>)</p>
                            <?php } ?>
                        </div>

                    </div>
                    <div class="action">
                        <?php if ($orders['order_status'] == 'Pending' or $orders['order_status'] == 'Approve') { ?>
                            <div class="confirm-order">
                                <form action="" method="POST">
                                    <select name="status" id="status">
                                        <option value="0">Action required</option>
                                        <option value="Reject">Reject</option>
                                        <option value="Complete">Complete</option>
                                    </select>
                                    <input type="hidden" value="<?php $orders['order_id']  ?>" >
                                    <input type="text" name="comments" placeholder="Massage for the buyer" >
                                    <input name='change_id' type="hidden" value="<?php echo $orders['order_id']  ?>" >
                                    <button name="statusc" >Submit</button>
                                </form>
                            </div>

                        <?php } else { ?>

                        <?php  } ?>
                    </div>

                </div>


            <?php } ?>
        </div>
    </div>

    <div class="orders-container" id="completedOrders" style="display: none;">
        <h2>Completed Orders</h2>
        <div class="order-list">
            <?php foreach ($resultcompleted as $orders) {
                $buyer_id = $orders['buyer_id'];
                include('templates/buyer.php')
            ?>

                <div class="order-item">
                    <div class="top">
                        <h3 class="order_id">Order # <?php echo $orders['order_id'] ?></h3>
                        <h3 class="farm"><?php echo $buyerRow['fname'] ?></h3>
                        <h3 class="status"><?php echo $orders['order_status'] ?></h3>
                    </div>
                    <div class="item-details">
                        <p class="array">(<?php echo $orders['product_array'] ?>)</p>
                        <p class="tcost">Total Cost : <?php echo number_format($orders['cost'], 2) ?></p>
                    </div>

                    <div class="bottom">
                        <div class="payment">
                            <?php if ($orders['payment_method'] == 'Card') { ?>
                                <p class="card">Payment completed</p>
                            <?php } else { ?>
                                <p class="cash">Pay in Cash</p>
                            <?php } ?>
                        </div>
                        <div class="delivery">
                            <?php if ($orders['delivery'] == 'Yes') { ?>
                                <p class="delivery">Delivery on - <?php echo $orders['delivery_address'] ?>(<?php echo $orders['postcode'] ?>)</p>
                            <?php } else { ?>
                                <p class="pickup">Pickup at - <?php echo $rowfarmer['address'] ?>(<?php echo $rowfarmer['postcode'] ?>)</p>
                            <?php } ?>
                        </div>

                    </div>

                </div>


            <?php } ?>
        </div>
    </div>

    <div class="orders-container" id="rejectedOrders" style="display: none;">
        <h2>Rejected Orders</h2>
        <div class="order-list">
            <?php foreach ($resultrejected as $orders) {
                $buyer_id = $orders['buyer_id'];
                include('templates/buyer.php')
            ?>

                <div class="order-item">
                    <div class="top">
                        <h3 class="order_id">Order # <?php echo $orders['order_id'] ?></h3>
                        <h3 class="farm"><?php echo $buyerRow['fname'] ?></h3>
                        <h3 class="status"><?php echo $orders['order_status'] ?></h3>
                    </div>
                    <div class="item-details">
                        <p class="array">(<?php echo $orders['product_array'] ?>)</p>
                        <p class="tcost">Total Cost : <?php echo number_format($orders['cost'], 2) ?></p>
                    </div>

                    <div class="bottom">
                        <div class="payment">
                            <?php if ($orders['payment_method'] == 'Card') { ?>
                                <p class="card">Payment completed</p>
                            <?php } else { ?>
                                <p class="cash">Pay in Cash</p>
                            <?php } ?>
                        </div>
                        <div class="delivery">
                            <?php if ($orders['delivery'] == 'Yes') { ?>
                                <p class="delivery">Delivery on - <?php echo $orders['delivery_address'] ?>(<?php echo $orders['postcode'] ?>)</p>
                            <?php } else { ?>
                                <p class="pickup">Pickup at - <?php echo $rowfarmer['address'] ?>(<?php echo $rowfarmer['postcode'] ?>)</p>
                            <?php } ?>
                        </div>

                    </div>

                </div>


            <?php } ?>
        </div>

    </div>
</section>

<div class="order-details">

</div>

<script>
    function showOrders(orderType) {
        document.getElementById('allOrders').style.display = 'none';
        document.getElementById('pendingOrders').style.display = 'none';
        document.getElementById('approvedOrders').style.display = 'none';
        document.getElementById('completedOrders').style.display = 'none';
        document.getElementById('rejectedOrders').style.display = 'none';

        if (orderType === 'all') {
            document.getElementById('allOrders').style.display = 'block';
        } else if (orderType === 'pending') {
            document.getElementById('pendingOrders').style.display = 'block';
        } else if (orderType === 'approved') {
            document.getElementById('approvedOrders').style.display = 'block';
        } else if (orderType === 'completed') {
            document.getElementById('completedOrders').style.display = 'block';
        } else if (orderType === 'rejected') {
            document.getElementById('rejectedOrders').style.display = 'block';
        }
    }
</script>



<?php include("templates/footer.php"); ?>

</html>