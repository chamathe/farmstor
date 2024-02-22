<?php 
if (isset($_POST['delete-fav'])) {
    $id_to_delete = $_POST['delete-fav'];
    $sqldelete = "DELETE FROM favtb WHERE item_id=$id_to_delete";

    if (mysqli_query($conn, $sqldelete)) {
        header("Location: favourite.php");
    exit();
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
}

?>