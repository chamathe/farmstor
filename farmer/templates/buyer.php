<?php 
$buyerQuery = "SELECT * FROM buyertb WHERE buyer_id=$buyer_id ";
$buyerResult = mysqli_query($conn, $buyerQuery);
$buyerRow = mysqli_fetch_assoc($buyerResult);

?>