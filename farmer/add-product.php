<!DOCTYPE html>
<html lang="en">

// import header
<?php include("templates/header.php"); ?>

<?php

// defining variabals intial values
$pname = $unit = $price = $available = $description = $category= $tags= '';

if (isset($_POST["submit"])) {
    $pname = htmlspecialchars($_POST["pname"]);
    $unit = htmlspecialchars($_POST["unit"]);
    $price = htmlspecialchars($_POST["price"]);
    $available = htmlspecialchars($_POST["available"]);
    $description = htmlspecialchars($_POST["description"]);
    $tags = htmlspecialchars($_POST["tags"]);
    $category_id = htmlspecialchars($_POST["category"]);

    if (isset($_FILES['image'])) {

        $img_name = $_FILES['image']['name'];
        $img_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $error = $_FILES['image']['error'];

        if ($error === 0) {
            if ($img_size > 1250000) {
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

                    // sql query to insert into product table
                    $sqlinsert = "INSERT INTO product (product_name, unit, price, available, image, description,tags ,farmer_id, category_id) VALUES ('$pname', '$unit', '$price' , '$available','$new_img_name','$description','$tags','$farmer_id','$category_id') ";


                    if (mysqli_query($conn, $sqlinsert)) {

                        header("Location: home.php");
                    } else {
                        echo "Error updating record: " . $stmt->error;
                    }


                    $stmt->close();
                } else {
                    $em = "You can't upload files of this type";
                    header("Location: add-product.php?error=$em");
                }
            }
        } else {
        }
    } else {
    }
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/add-product.css">
    <title>Add Product</title>
</head>

<div class="main">
<?php include("../buyer/templates/goback.php"); ?> 
    <div class="container">
        <h2>Add Product</h2>
        <form action="add-product.php" method="POST" enctype="multipart/form-data">

            <label for="pname">Product Name: </label>
            <input type="text" id="pname" name="pname" value="<?php echo $pname ?>" required>

            <label for="unit">Unit:</label>
            <input type="text" id="unit" name="unit" value="<?php echo $unit ?>" required>


            <label for="price">Price per Unit (£): </label>
            <input type="text" id="price" name="price" value="<?php echo $price ?>" required>

            <label for="available">Available Qty: </label>
            <input type="tel" id="available" name="available" value="<?php echo $available ?>" required>


            <label for="description">Product Description:</label>
            <input id="description" name="description" value="<?php echo $description ?>">


            <label for="del-method">Select Product Category:</label>

            <?php
            // Fetch categories from category table
            $categoryQuery = "SELECT * FROM categories";
            $categoryResult = mysqli_query($conn, $categoryQuery);
            ?>

            <select name="category" id="category" required>
                <option value="0"><?php echo $category ?></option>
                <?php
                while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                    echo "<option value='{$categoryRow['category_id']}'>{$categoryRow['category']}</option>";
                }
                ?>
            </select>

            <label for="tags">Add tags to make your product more searchable:</label>
                <input id="tags" name="tags" required value="<?php echo $tags; ?>">

            <label for="image">Upload Product Image:</label>
            <input id="image" name="image" type="file" accept="image/*" required>

            <button name="submit"><img class="add-icon" src="..\images\add.png" alt=""> Add Product</button>
        </form>
    </div>
</div>



<?php include("templates/footer.php"); ?>

</html>