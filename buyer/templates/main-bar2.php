<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="templates/main-bar2.css">
</head>

<div class="search-container">
    <div class="search-line">
        <form class="search-form" action="" method="GET">
            <button class="search-btn" name="search"><img src="..\images\search.png" alt="Fav"></button>
            <input class="search-bar" name="search" placeholder="Search farms and products" type="text"
                value="<?php if (isset($_GET['search'])) { echo $_GET['search']; } ?>">
        </form>
    </div>

    <div class="category-select">
        <ul>
            <li><a href="farm.php?farmer_id=<?php echo $farmer_id ?>">All</a></li>
            <?php
            // Fetch categories from the category table
            $categoryQuery = "SELECT * FROM categories";
            $categoryResult = mysqli_query($conn, $categoryQuery);

            foreach ($categoryResult as $category) {
                $category_id = $category['category_id'];
                $productQuerytop = "SELECT * FROM product WHERE category_id=$category_id ";
                $productResulttop = mysqli_query($conn, $productQuerytop);
                $productCounttop = mysqli_num_rows($productResulttop);

                // Check if the current category ID matches the selected category ID in the URL
                $selectedCategoryID = isset($_GET['category_id']) ? $_GET['category_id'] : null;
                $isSelected = ($selectedCategoryID == $category['category_id']) ? 'selected' : '';
            ?>
                <li class="category-list <?php echo $isSelected; ?>">
                    <a href="farm.php?farmer_id=<?php echo $farmer_id; ?>&category_id=<?php echo $category['category_id']; ?>">
                        <?php echo $category['category']; ?>
                        <b class="cat-count"><?php echo $productCounttop ?></b>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>



</html>
