<!DOCTYPE html>
<html lang="en">

<?php include("templates/header.php"); ?>




<?php

if (isset($_POST["submit"])) {
    $fname = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $address = htmlspecialchars($_POST["address"]);
    $telephone = htmlspecialchars($_POST["telephone"]);
    $postcode = htmlspecialchars($_POST["postcode"]);




    $sqlupdate = "UPDATE buyertb SET 
                        fname = ?,
                        email = ?,
                        address = ?,
                        telephone = ?,
                        postcode = ?
                        WHERE buyer_id = ?";

    $stmt = $conn->prepare($sqlupdate);

    $stmt->bind_param("sssssi", $fname, $email, $address, $telephone, $postcode, $buyer_id);

    if ($stmt->execute()) {

        header("Location: profile.php");
    } else {
        echo "Error updating record: " . $stmt->error;
    }


    $stmt->close();
} else {
}



?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/edit-profile.css">
    <title>Edit Profile</title>


    <div class="main">
    <?php include("templates/goback.php"); ?> 
        <div class="container">
            <h2>Edit Profile Details</h2>
            <form action="edit-profile.php" method="POST" enctype="multipart/form-data">

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $rowbuyer['fname']; ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $rowbuyer['email']; ?>" required>

                <label for="telephone">Telephone:</label>
                <input type="tel" id="telephone" name="telephone" value="<?php echo $rowbuyer['telephone']; ?>" required>

                <label for="address">Address:</label>
                <input id="address" name="address" required value="<?php echo $rowbuyer['address']; ?>">

                <label for="postcode">Post Code:</label>
                <input id="postcode" name="postcode" required value="<?php echo $rowbuyer['postcode']; ?>">






                <input type="submit" name="submit" value="Save Changes">
        </div>
        </form>
    </div>
    </div>



    <?php include("templates/footer.php"); ?>

</html>