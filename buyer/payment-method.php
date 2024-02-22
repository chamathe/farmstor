<?php if (isset($_POST['next'])) {

    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $telephone = htmlspecialchars($_POST["telephone"]);
    $address = htmlspecialchars($_POST["address"]);
    $postcode = htmlspecialchars($_POST["post_code"]);
    $delivery = htmlspecialchars($_POST["delivery"]);
    $farmer_id = htmlspecialchars($_POST["farmer_id"]);
    $cost1 = htmlspecialchars($_POST["cost"]);
    $selectedPaymentMethod = $_POST['payment_method'];

    if($delivery=="Yes"){
        $cost = $cost1*1.05;
    } else {
        $cost = $cost1;
    }

    $product_array = '';

    foreach($cart as $line) {
        $product_id = $line['product_id'];
        $resproduct = mysqli_query($conn,"SELECT * FROM product WHERE product_id=$product_id ");
        $rowproduct = mysqli_fetch_assoc($resproduct);
        
        $product = $rowproduct['product_name'];
        $unit = $rowproduct['unit'];
        $quantity = $line['quantity'];
        
    
        $product_array .= $product.' - '.$quantity.' '.$unit.';    ';
      }



    if ($selectedPaymentMethod !== "0") {

        $sqlcheckoutUpdate = "INSERT INTO checkout_tb (buyer_id,name,email,telephone,payment_method,farmer_id,product_array,cost,delivery,delivery_address,postcode) 
        VALUES ($buyer_id, '$name','$email','$telephone','$selectedPaymentMethod','$farmer_id','$product_array','$cost','$delivery','$address','$postcode')";

        if (mysqli_query($conn, $sqlcheckoutUpdate)) {

          
                $sqlcheckout1 = "SELECT checkout_id FROM checkout_tb ORDER BY checkout_id DESC LIMIT 1";

                //Execute the sql query
                $rescheckout1 = mysqli_query($conn, $sqlcheckout1);

                //get user id of the checkout

                $checkout_id = $rescheckout1;
                session_start();
                $_SESSION["checkout_id"] = $checkout_id;

                if( $selectedPaymentMethod=="Card"){
                    header("Location:payment.php");
                } else {
                    header("Location:orderstatus.php");
                }
                
            } else{
                echo 'query error: ' . mysqli_error($conn);  
            }
           
        
    } else {

        echo "Please select a payment method.";
    }
}
?>

<?php if (isset($_POST['change'])) {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $telephone = htmlspecialchars($_POST["telephone"]);
    $address = htmlspecialchars($_POST["address"]);

    $selectedPaymentMethod = "Pending";


    if ($selectedPaymentMethod !== "0") {
        $sqlcheckoutUpdate = "UPDATE checkout_tb SET payment_method='$selectedPaymentMethod' WHERE buyer_id = $buyer_id ORDER BY order_id DESC LIMIT 1";

        if (mysqli_query($conn, $sqlcheckoutUpdate)) {
            header("Location:checkout.php");
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}
?>


