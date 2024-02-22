<?php if (isset($_POST['favp'])) {

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
        $location = "product.php?product_id=$product_id_cart&category_id=$categoryId";
    } else {
        $location = "product.php?product_id=$product_id_cart";
    }

    header("Location: $location");
    exit();
}
}
