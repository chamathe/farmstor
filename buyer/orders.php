<!DOCTYPE html>
<html lang="en">
<?php include("templates/header.php"); ?>

<?php
$sqlall = "SELECT * FROM checkout_tb WHERE buyer_id = $buyer_id  ORDER BY order_id DESC";
$resultall = mysqli_query($conn, $sqlall);

$sqlpending = "SELECT * FROM checkout_tb WHERE buyer_id = $buyer_id AND order_status='Pending' ORDER BY order_id DESC";
$resultpending = mysqli_query($conn, $sqlpending);

$sqlapproved = "SELECT * FROM checkout_tb WHERE buyer_id = $buyer_id AND order_status='Approve' ORDER BY order_id DESC";
$resultapproved = mysqli_query($conn, $sqlapproved);

$sqlcompleted = "SELECT * FROM checkout_tb WHERE buyer_id = $buyer_id AND order_status='Complete' ORDER BY order_id DESC";
$resultcompleted = mysqli_query($conn, $sqlcompleted);


$sqlrejected = "SELECT * FROM checkout_tb WHERE buyer_id = $buyer_id AND order_status='Reject' ORDER BY order_id DESC";
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
<?php include("templates/goback.php"); ?> 
<section>
    <div class="orders-container" id="allOrders">
        <h2>All Orders</h2>
        <div class="order-list">
            <?php foreach ($resultall as $orders) {
                $farmer_id = $orders['farmer_id'];
                include('templates/farmer.php')
            ?>
                <div class="order-item">
                    <div class="top">
                        <h3 class="order_id">Order # <?php echo $orders['order_id'] ?></h3>
                        <h3 class="farm"><?php echo $farmerRow['farm'] ?></h3>
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
                                <p class="pickup">Pickup at - <?php echo $farmerRow['address'] ?>(<?php echo $farmerRow['postcode'] ?>)</p>
                            <?php } ?>
                        </div>

                    </div>

                </div>

            <?php } ?>
        </div>
    </div>


    <div class="orders-container" id="pendingOrders" style="display: none;">
        <h2>Pending Orders</h2>
        <div class="order-list">
            <?php foreach ($resultpending as $orders) {
                $farmer_id = $orders['farmer_id'];
                include('templates/farmer.php')
            ?>

                <div class="order-item">
                    <div class="top">
                        <h3 class="order_id">Order # <?php echo $orders['order_id'] ?></h3>
                        <h3 class="farm"><?php echo $farmerRow['farm'] ?></h3>
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
                                <p class="pickup">Pickup at - <?php echo $farmerRow['address'] ?>(<?php echo $farmerRow['postcode'] ?>)</p>
                            <?php } ?>
                        </div>

                    </div>

                </div>


            <?php } ?>
        </div>
    </div>

    <div class="orders-container" id="approvedOrders" style="display: none;">
        <h2>Approved Orders</h2>
        <div class="order-list">
            <?php foreach ($resultpending as $orders) {
                $farmer_id = $orders['farmer_id'];
                include('templates/farmer.php')
            ?>

                <div class="order-item">
                    <div class="top">
                        <h3 class="order_id">Order # <?php echo $orders['order_id'] ?></h3>
                        <h3 class="farm"><?php echo $farmerRow['farm'] ?></h3>
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
                                <p class="pickup">Pickup at - <?php echo $farmerRow['address'] ?>(<?php echo $farmerRow['postcode'] ?>)</p>
                            <?php } ?>
                        </div>

                    </div>

                </div>


            <?php } ?>
        </div>
    </div>

    <div class="orders-container" id="completedOrders" style="display: none;">
        <h2>Completed Orders</h2>
        <div class="order-list">
            <?php foreach ($resultpending as $orders) {
                $farmer_id = $orders['farmer_id'];
                include('templates/farmer.php')
            ?>

                <div class="order-item">
                    <div class="top">
                        <h3 class="order_id">Order # <?php echo $orders['order_id'] ?></h3>
                        <h3 class="farm"><?php echo $farmerRow['farm'] ?></h3>
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
                                <p class="pickup">Pickup at - <?php echo $farmerRow['address'] ?>(<?php echo $farmerRow['postcode'] ?>)</p>
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
            <?php foreach ($resultpending as $orders) {
                $farmer_id = $orders['farmer_id'];
                include('templates/farmer.php')
            ?>

                <div class="order-item">
                    <div class="top">
                        <h3 class="order_id">Order # <?php echo $orders['order_id'] ?></h3>
                        <h3 class="farm"><?php echo $farmerRow['farm'] ?></h3>
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
                                <p class="pickup">Pickup at - <?php echo $farmerRow['address'] ?>(<?php echo $farmerRow['postcode'] ?>)</p>
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