<!DOCTYPE html>
<html lang="en">

<?php


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/farm.css">
    <title>Farm Profile</title>
    <?php include("templates/header.php"); ?>
    <?php include("../buyer/templates/goback.php"); ?> 
    <div class="main">
    
        <div class="farm-container">
            <div class="farm-image">
                <img src="uploads/<?php echo $rowfarmer['image']; ?>" alt="">
            </div>

            <div class="farm-info">
                <div>
                    <div class="farm-top">
                    <h1 class="farm-name" ><?php echo $rowfarmer['farm']; ?></h1>
                    <div class="user-name" ><p>By: </p><h3> <?php echo $rowfarmer['fname']; ?></h3></div>
                    </div>
                    <div class="farm-second">
                    <p><strong>ID:</strong> <?php echo $rowfarmer['farmer_id']; ?></p>
                    <h4><strong>Delivery:</strong> <?php echo $rowfarmer['delivery']; ?></h4>
                    </div>
                    <hr>
                    <p><strong>Email: </strong> <?php echo $rowfarmer['email']; ?></p>
                    <p><strong>Telephone: </strong><?php echo $rowfarmer['telephone']; ?></p>
                    <hr>
                    <p><strong>Address: </strong><?php echo $rowfarmer['address']; ?></p>
                    <p><strong>Post Code: </strong><?php echo $rowfarmer['postcode']; ?></p>
                    <small>(tags: <?php echo $rowfarmer['tags']; ?>)</small>
                </div>

                <div class="farm-btn">
                <a class="add-products-btn" href="add-product.php"><img class="edit-icon" src="..\images\add.png" alt=""> Add Products</a>
                    <a class="edit-farm-btn" href="edit-farm.php"><img class="edit-icon" src="..\images\edit.png" alt=""> Edit Farm</a>
                    <form action="farm.php" method="POST">
                        <button name="logout" class="logout-btn" href="index.php"><img class="edit-icon" src="..\images\logout.png" alt=""> Logout</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <?php include("templates/footer.php"); ?>

</html>