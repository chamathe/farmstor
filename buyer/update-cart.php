<?php
if (isset($_POST['update-cart'])) {
    $quantities = $_POST['spinner'];
    $product_ids = $_POST['product_id'];

    if (isset($_POST['checkbox']) && $_POST['checkbox'] === '1') {
        $delivery = "Yes";
    } else {
        $delivery = "No";
    }

    // Use prepared statements to avoid SQL injection
    $sqlquantity = "UPDATE carttb SET quantity = ?, delivery = ? WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $sqlquantity);

    if ($stmt) {
        foreach ($quantities as $product_id => $quantity) {
            // Bind parameters inside the loop
            mysqli_stmt_bind_param($stmt, "ssi", $quantity, $delivery, $product_id);

            // Update each product in the cart
            mysqli_stmt_execute($stmt);
        }

        // Redirect after the loop to avoid multiple redirects
        header("Location: cart.php");
        exit();
    } else {
        // Handle the case where the prepared statement fails
        echo "Error preparing statement: " . mysqli_error($conn);
    }

   
}
?>
