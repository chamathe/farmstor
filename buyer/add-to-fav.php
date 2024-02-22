<?php if (isset($_POST['fav'])) {

    $product_id_cart = mysqli_real_escape_string($conn, $_POST["product_id_cart"]);
    $buyer_id = mysqli_real_escape_string($conn, $buyer_id);
    $farmerId = $_POST['farmer_id'];
    $categoryId = $_POST['category_id_cart'];

    

    $sqlcheck = "SELECT * FROM favtb WHERE product_id = $product_id_cart AND buyer_id = $buyer_id ";

    $rescheck = mysqli_query($conn, $sqlcheck);
    if (!$rescheck) {
        die("Query failed: " . mysqli_error($conn));
    }

    $countchek = mysqli_num_rows($rescheck);

    if ($countchek > 0) {
    } else {

        $sqlcart = "INSERT INTO favtb (buyer_id,product_id) VALUES('$buyer_id','$product_id_cart') ";

        $rescart = mysqli_query($conn, $sqlcart);

        if (isset($categoryId) && $categoryId !== "") {
            $location = "farm.php?farmer_id=$farmerId&category_id=$categoryId";
        } else {
            $location = "farm.php?farmer_id=$farmerId";
        }

        header("Location: $location");
        exit();
    }
}
