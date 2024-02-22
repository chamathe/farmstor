<?php

if (isset($_POST["pcheckout"])) {

    $sqlcartrecord = "SELECT * FROM carttb WHERE buyer_id = '$buyer_id'";

    $rescartrecord = mysqli_query($conn, $sqlcartrecord);

    $rowcartrecord =mysqli_fetch_all($rescartrecord, MYSQLI_ASSOC);

    $_SESSION['cart'] = $rowcartrecord;
   


      

    header("Location: checkout.php");
   
    
}

?>