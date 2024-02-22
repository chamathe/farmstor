<!DOCTYPE html>
<html lang="en">

<?php include("templates/header.php"); ?>

<?php

// Get the product ID   
$product_id = $_GET['product_id'];

// Prepare and execute the query
$productQuery = "SELECT * FROM product WHERE product_id = $product_id";
$productResult = mysqli_query($conn, $productQuery);
$productRow = mysqli_fetch_assoc($productResult);

$pname = $productRow['product_name'];
$unit = $productRow['unit'];
$price = $productRow['price'];
$available = $productRow['available'];
$description = $productRow['description'];
$category_id = $productRow['category_id'];
$image = $productRow['image'];
$tags = $productRow['tags'];

// Fetch categories from category table
$categoryQuery1 = "SELECT * FROM categories WHERE category_id = $category_id ";
$categoryResult1 = mysqli_query($conn, $categoryQuery1);
$categoryRow1 = mysqli_fetch_assoc($categoryResult1);

$category = $categoryRow1['category'];

?>

<?php

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
            if ($img_size > 125000) {
                $em = "Sorry, your file is too large.";
                header("Location: edit-product.php?error=$em");
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = 'uploads/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);


                    $sqlupdate = "UPDATE product SET 
                        product_name = ?,
                        unit = ?,
                        price = ?,
                        available = ?,
                        image = ?,
                        description = ?,
                        category_id = ?
                        tags = ?
                        WHERE product_id = ?";

                    $stmt = $conn->prepare($sqlupdate);

                    $stmt->bind_param("ssssssssi", $pname, $unit, $price, $available, $new_img_name, $description, $category_id,$tags ,$product_id);

                    if ($stmt->execute()) {

                        header("Location: home.php");
                    } else {
                        echo "Error updating record: " . $stmt->error;
                    }
                } else {
                    $em = "You can't upload files of this type";
                    header("Location: edit-product.php?error=$em");
                }
            }
        } else {
            $new_img_name = $image;

            $sqlupdate = "UPDATE product SET 
                        product_name = ?,
                        unit = ?,
                        price = ?,
                        available = ?,
                        image = ?,
                        description = ?,
                        category_id = ?,
                        tags = ?
                        WHERE product_id = ?";

                    $stmt = $conn->prepare($sqlupdate);

                    $stmt->bind_param("ssssssssi", $pname, $unit, $price, $available, $new_img_name, $description, $category_id,$tags ,$product_id);

                    if ($stmt->execute()) {

                header("Location:home.php");
            };
        }
    } else {
    }
}
?>



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/edit-product.css">
    <title>Edit Product</title>
</head>
<?php include("../buyer/templates/goback.php"); ?> 
<div class="main">

    <div class="container">
        <h2>Edit Product</h2>
        <form action="" method="POST" enctype="multipart/form-data">

            <label for="pname">Product Name: </label>
            <input type="text" id="pname" name="pname" value="<?php echo $pname ?>" required>

            <label for="unit">Unit:</label>
            <input type="text" id="unit" name="unit" value="<?php echo $unit ?>" required>


            <label for="price">Price per Unit (£): </label>
            <input type="text" id="price" name="price" value="<?php echo $price ?>" required>

            <label for="available">Available Qty: </label>
            <input type="tel" id="available" name="available" value="<?php echo $available ?>" required>

            <label for="description">Product Description:</label>
            <textarea id="description" name="description" required><?php echo $description; ?></textarea>



            <label for="del-method">Select Product Category:</label>

            <?php
            // Fetch categories from category table
            $categoryQuery = "SELECT * FROM categories";
            $categoryResult = mysqli_query($conn, $categoryQuery);
            $categoryRow = mysqli_fetch_assoc($categoryResult);
            

            ?>

            <select name="category" id="category" required>
                <option value="<?php echo $category_id?>"><?php echo $category ?></option>
                <?php foreach($categoryResult as $cat) { ?>
                <option value="<?php echo $cat['category_id'] ?>"><?php echo $cat['category'] ?></option>
             <?php   } ?>
            </select>

            <label for="tags">Add tags to make your product more searchable:</label>
                <input id="tags" name="tags" required value="<?php echo $tags; ?>">

            <div class="img-upload">
                <div style="display: flex; flex-direction: column; ">
                    <label for="image">Upload Product Image:</label>
                    <input id="image" name="image" type="file" value="<?php echo $image ?>" accept="image/*">
                </div>

                <div style="display: flex; flex-direction: column; ">
                    <label for="existing-image">Existing Image:</label>
                    <?php
                    if (!empty($image)) { ?>
                        <img class="existing-img" src="uploads/<?php echo $image ?>" alt="Existing Image">
                    <?php } else {
                        echo '<p>No existing image available.</p>';
                    }
                    ?>
                </div>
            </div>

            <button name="submit"><img class="add-icon" src="..\images\add.png" alt=""> Update</button>
        </form>
    </div>
</div>



<?php include("templates/footer.php"); ?>

</html>