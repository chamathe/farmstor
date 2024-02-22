<!DOCTYPE html>
<html lang="en">

<?php include("templates/header.php"); ?>




<?php

if (isset($_POST["submit"])) {
    $fname = htmlspecialchars($_POST["fname"]);
    $farm = htmlspecialchars($_POST["farm"]);
    $email = htmlspecialchars($_POST["email"]);
    $address = htmlspecialchars($_POST["address"]);
    $telephone = htmlspecialchars($_POST["telephone"]);
    $postcode = htmlspecialchars($_POST["postcode"]);
    $tags = htmlspecialchars($_POST["tags"]);
    $del = htmlspecialchars($_POST["del-method"]);

    if (isset($_FILES['image'])) {

        $img_name = $_FILES['image']['name'];
        $img_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $error = $_FILES['image']['error'];

        if ($error === 0) {
            if ($img_size > 12500000) {
                $em = "Sorry, your file is too large.";
                header("Location: edit-farm.php?error=$em");
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = 'uploads/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);


                    $sqlupdate = "UPDATE farmertb SET 
                        fname = ?,
                        farm = ?,
                        email = ?,
                        address = ?,
                        telephone = ?,
                        postcode = ?,
                        tags =?,
                        delivery = ?,
                        image = ?
                        WHERE farmer_id = ?";

                    $stmt = $conn->prepare($sqlupdate);

                    $stmt->bind_param("sssssssssi", $fname, $farm, $email, $address, $telephone, $postcode,$tags , $del, $new_img_name, $farmer_id);

                    if ($stmt->execute()) {

                        header("Location: farm.php");
                    } else {
                        echo "Error updating record: " . $stmt->error;
                    }


                    $stmt->close();
                } else {
                    $em = "You can't upload files of this type";
                    header("Location: edit-farm.php?error=$em");
                }
            }
        } else {
            $new_img_name = $rowfarmer['image'];

        $sqlupdate = "UPDATE farmertb SET 
                        fname = ?,
                        farm = ?,
                        email = ?,
                        address = ?,
                        telephone = ?,
                        postcode = ?,
                        tags=?,
                        delivery = ?,
                        image = ?
                        WHERE farmer_id = ?";

                    $stmt = $conn->prepare($sqlupdate);

                    $stmt->bind_param("sssssssssi", $fname, $farm, $email, $address, $telephone, $postcode,$tags ,$del, $new_img_name, $farmer_id);

                    if ($stmt->execute()) {

                        header("Location: farm.php");
    };


        }
    } else {
}
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/edit-farm.css">
    <title>Edit Farm</title>


    <div class="main">
    <?php include("../buyer/templates/goback.php"); ?> 
        <div class="container">
            <h2>Edit Farm Details</h2>
            <form action="edit-farm.php" method="POST" enctype="multipart/form-data">

                <label for="farm">Farm Name:</label>
                <input type="text" id="farm" name="farm" value="<?php echo $rowfarmer['farm']; ?>" required>

                <label for="fname">Full Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo $rowfarmer['fname']; ?>" required>


                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $rowfarmer['email']; ?>" required>

                <label for="telephone">Telephone:</label>
                <input type="tel" id="telephone" name="telephone" value="<?php echo $rowfarmer['telephone']; ?>" required>

                <label for="address">Address:</label>
                <input id="address" name="address" required value="<?php echo $rowfarmer['address']; ?>">

                <label for="postcode">Post Code:</label>
                <input id="postcode" name="postcode" required value="<?php echo $rowfarmer['postcode']; ?>">

                <label for="tags">Add tags to make your farm more searchable:</label>
                <input id="tags" name="tags" required value="<?php echo $rowfarmer['tags']; ?>">


                <label for="del-method">Select Delivery Availability:</label>
<select name="del-method" id="del-method">
    <option value="Yes" <?php echo ($rowfarmer['delivery'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
    <option value="No" <?php echo ($rowfarmer['delivery'] == 'No') ? 'selected' : ''; ?>>No</option>
</select>

                <div class="img-upload">
                    <div style="display: flex; flex-direction: column; " >
                        <label for="image">Upload Farm Image:</label>
                        <input id="image" name="image" type="file" value="<?php echo $rowfarmer['image']; ?>" accept="image/*">
                    </div>

                    <div style="display: flex; flex-direction: column; " > 
                        <label for="existing-image">Existing Image:</label>
                        <?php
                        if (!empty($rowfarmer['image'])) { ?>
                            <img class="existing-img" src="uploads/<?php echo $rowfarmer['image'] ?>" alt="Existing Image">
                        <?php } else {
                            echo '<p>No existing image available.</p>';
                        }
                        ?>
                    </div>
                </div>



                <input type="submit" name="submit" value="Save Changes">
            </form>
        </div>
    </div>



    <?php include("templates/footer.php"); ?>

</html>