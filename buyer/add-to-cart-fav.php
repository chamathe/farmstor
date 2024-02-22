<?php if (isset($_POST['add-cart-fav'])) {

$product_id_cart = mysqli_real_escape_string($conn, $_POST["product_id_cart"]);
$buyer_id = mysqli_real_escape_string($conn, $buyer_id);
$farmerId = $_POST['farmer_id'];
$categoryId = $_POST['category_id_cart'];

//get delivery status of the farmer

$delivery = "No";

 // building condition to fill the cart from only one farmer
 $sqlunique = "SELECT * FROM carttb WHERE buyer_id = $buyer_id LIMIT 1 ";
 $resunique = mysqli_query($conn, $sqlunique);
 $countunique = mysqli_num_rows($resunique);
 $rowunique = mysqli_fetch_assoc($resunique);
 $farmerunique = $rowunique['farmer_id'];
 
if($countunique>0){
 // building condition to fill the cart from only one farmer
 $sqlunique = "SELECT * FROM carttb WHERE buyer_id = $buyer_id LIMIT 1 ";
 $resunique = mysqli_query($conn, $sqlunique);
 $rowunique = mysqli_fetch_assoc($resunique);
 $farmerunique = $rowunique['farmer_id'];

 if($farmerId === $farmerunique){

    $sqlcheck = "SELECT * FROM carttb WHERE product_id = $product_id_cart AND buyer_id = $buyer_id ";

    $rescheck = mysqli_query($conn, $sqlcheck);
    if (!$rescheck) {
        die("Query failed: " . mysqli_error($conn));
    }
    
    $countchek = mysqli_num_rows($rescheck);
    
    
    
    if ($countchek > 0) {
         // building condition to fill the cart from only one farmer
         $sqlunique = "SELECT * FROM carttb WHERE buyer_id = $buyer_id LIMIT 1 ";
         $resunique = mysqli_query($conn, $sqlunique);
         $rowunique = mysqli_fetch_assoc($resunique);
         $farmerunique = $rowunique['farmer_id'];
    
         if($farmerId === $farmerunique){
            
        //get user id of the user
        $arraycheck = mysqli_fetch_assoc($rescheck);
        $current_items = $arraycheck["quantity"];
    
        $new_items = $current_items + 1;
        $sqlquantity = "UPDATE carttb SET quantity='$new_items' WHERE product_id = $product_id_cart AND buyer_id = $buyer_id";
    
        $resquantity = mysqli_query($conn, $sqlquantity);
    
        if (isset($categoryId) && $categoryId !== "") {
            $location = "favourite.php";
        } else {
            $location = "favourite.php";
        }
    
        header("Location: $location");
        exit();
    } else {
        if (isset($categoryId) && $categoryId !== "") {
            $location = "favourite.php";
        } else {
            $location = "favourite.php";
        }
    
        header("Location: $location");
        
    }
    
    } else {
    
        
    
        $quantity = 1;
    
              
        $sqlcart = "INSERT INTO carttb (buyer_id,product_id,quantity,delivery,farmer_id) VALUES('$buyer_id','$product_id_cart','$quantity','$delivery',$farmerId) ";
    
        $rescart = mysqli_query($conn, $sqlcart);
    
        if (isset($categoryId) && $categoryId !== "") {
            $location = "favourite.php";
        } else {
            $location = "favourite.php";
        }
    
        header("Location: $location");
        exit();
        
    
        
    }
    
 } else {
    if (isset($categoryId) && $categoryId !== "") {
        $location = "favourite.php";
    } else {
        $location = "favourite.php";
    }

    header("Location: $location");
    echo '<script>alert("You only fill the cart from one farmer!! Please do seperatly");</script>';
 }


} else {
    $sqlcheck = "SELECT * FROM carttb WHERE product_id = $product_id_cart AND buyer_id = $buyer_id ";

    $rescheck = mysqli_query($conn, $sqlcheck);
    if (!$rescheck) {
        die("Query failed: " . mysqli_error($conn));
    }
    
    $countchek = mysqli_num_rows($rescheck);

    $quantity = 1;
    
              
        $sqlcart = "INSERT INTO carttb (buyer_id,product_id,quantity,delivery,farmer_id) VALUES('$buyer_id','$product_id_cart','$quantity','$delivery',$farmerId) ";
    
        $rescart = mysqli_query($conn, $sqlcart);
    
        if (isset($categoryId) && $categoryId !== "") {
            $location = "favourite.php";
        } else {
            $location = "favourite.php";
        }
    
        header("Location: $location");
        exit();
}
}