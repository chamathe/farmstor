<?php 
if (isset($_POST['delete'])) {
    $id_to_delete = $_POST['delete'];
    $sqldelete = "DELETE FROM carttb WHERE item_id=$id_to_delete";

    if (mysqli_query($conn, $sqldelete)) {
        header("Location: cart.php");
        exit();
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
}

?>