<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="templates/home.css">
</head>
<?php include("templates/header.php"); ?>
<?php include("templates/main-bar.php"); ?>

<div class="restaurant-container" style=" display:flex; flex-wrap: wrap;" >
    <?php
    if (isset($_GET['search'])) {
        $search = strtolower($_GET['search']);
        $sqlsearch = "SELECT * FROM farmertb WHERE CONCAT(farm, fname,postcode, address,tags) LIKE '%$search%'";
        $ressearch = mysqli_query($conn, $sqlsearch);

        if (!$ressearch) {
            die('Error: ' . mysqli_error($conn));
        }

        $searchcount = mysqli_num_rows($ressearch);

        if ($searchcount > 0) {
            foreach ($ressearch as $farm) { ?>
                <div class="restaurant-card">
                    <a href="farm.php?farmer_id=<?php echo $farm['farmer_id']; ?>">
                        <img src="../farmer/uploads/<?php echo $farm['image']; ?>" alt="">
                        <div class="rescard-content">
                            <div class="card-title">
                                <h3><?php echo $farm['farm'] ?></h3>
                            </div>
                            <div class="card-owner">Farmer - <b><?php echo $farm['fname'] ?></b></div>
                            <?php
                            $farmer_id =  $farm['farmer_id'];
                            $sqlb = "SELECT DISTINCT category_id FROM product WHERE farmer_id = $farmer_id";
                            $resb = mysqli_query($conn, $sqlb);

                            foreach ($resb as $a) {
                                $category_id = $a['category_id'];
                                $categoryQuery = "SELECT DISTINCT * FROM categories WHERE category_id=$category_id ";
                                $categoryResult = mysqli_query($conn, $categoryQuery);
                                foreach($categoryResult as $cat){ ?>
                                    <div class="card-categories"><?php echo $cat['category'] ?></div>
                               <?php } 
                            }

                            ?>
                            <div class="card-delivery">Delivery - <strong><?php echo $farm['delivery'] ?></strong></div>
                        </div>
                    </a>
                </div>
            <?php }
        } else { ?>
            <div class="errormsg">
                <h2>No Result found</h2>
                <hr style="margin-bottom: 7.5rem;">

            </div>
            <?php }
    } else {
        // Fetch farms from farmers table if there is no search
        $farmQuery = "SELECT * FROM farmertb";
        $farmResult = mysqli_query($conn, $farmQuery);

        if (!$farmResult) {
            die('Error: ' . mysqli_error($conn));
        }

        $farmCount = mysqli_num_rows($farmResult);

        if ($farmCount > 0) {
            foreach ($farmResult as $farm) { ?>
                <div class="restaurant-card">
                    <a href="farm.php?farmer_id=<?php echo $farm['farmer_id']; ?>">
                        <img src="../farmer/uploads/<?php echo $farm['image']; ?>" alt="#">
                        <div class="rescard-content">
                            <div class="card-title">
                                <h3><?php echo $farm['farm'] ?></h3>
                            </div>
                            <div class="card-owner">Farmer - <b><?php echo $farm['fname'] ?></b></div>

                            <?php
                            $farmer_id =  $farm['farmer_id'];
                            $sqlb = "SELECT DISTINCT category_id FROM product WHERE farmer_id = $farmer_id";
                            $resb = mysqli_query($conn, $sqlb);

                            foreach ($resb as $a) {
                                $category_id = $a['category_id'];
                                $categoryQuery = "SELECT DISTINCT * FROM categories WHERE category_id=$category_id ";
                                $categoryResult = mysqli_query($conn, $categoryQuery);
                                foreach($categoryResult as $cat){ ?>
                                    <div class="card-categories"><?php echo $cat['category'] ?></div>
                               <?php } 
                            }

                            ?>
                            <div class="card-delivery">Delivery - <strong><?php echo $farm['delivery'] ?></strong></div>
                        </div>
                    </a>
                </div>
            <?php }
        } else { ?>
            <div class="errormsg">
                <h2>No products added</h2>
                <hr style="margin-bottom: 7.5rem;">
            </div>

        <?php  }
    }
    if (isset($searchcount)) {
        if ($searchcount == 0) { ?>
            <hr style="margin-bottom: 11.1rem;">
        <?php }
    } else {
        if ($farmCount == 0) { ?>
            <hr style="margin-bottom: 11.1rem;">
    <?php
        }
    } ?>



</div>

<?php include("templates/footer.php"); ?>

</html>