<!DOCTYPE html>
<html lang="en">

<?php


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/profile.css">
    <title>Customer Profile</title>
    <?php include("templates/header.php"); ?>
    <?php include("templates/goback.php"); ?> 
    <div class="main">
    
        <div class="farm-container">
        

            <div class="farm-info">
                <div>
                    <div class="farm-top">
                    <h1 class="farm-name" ><?php echo $rowbuyer['fname']; ?></h1>
                    </div>
                    <div class="farm-second">
                    <p><strong>ID:</strong> <?php echo $rowbuyer['buyer_id']; ?></p>
                    </div>
                    <hr>
                    <p><strong>Email: </strong> <?php echo $rowbuyer['email']; ?></p>
                    <p><strong>Telephone: </strong><?php echo $rowbuyer['telephone']; ?></p>
                    <hr>
                    <p><strong>Address: </strong><?php echo $rowbuyer['address']; ?></p>
                    <p><strong>Post Code: </strong><?php echo $rowbuyer['postcode']; ?></p>
                </div>

                <div class="farm-btn">
                    <a class="edit-farm-btn" href="edit-profile.php"><img class="edit-icon" src="..\images\edit.png" alt=""> Edit Profile</a>
                    <form action="farm.php" method="POST">
                        <button name="logout" class="logout-btn" href="index.php"><img class="edit-icon" src="..\images\logout.png" alt=""> Logout</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <?php include("templates/footer.php"); ?>

</html>