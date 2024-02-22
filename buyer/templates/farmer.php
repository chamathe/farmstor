<?php 
$farmerQuery = "SELECT * FROM farmertb WHERE farmer_id=$farmer_id ";
$farmerResult = mysqli_query($conn, $farmerQuery);
$farmerRow = mysqli_fetch_assoc($farmerResult);

?>