<head>
  <link rel="stylesheet" href="templates/main-bar.css">
</head>

<div class="search-container">


  <div class="search-line">
    <form class="search-form" action="" method="GET">
      <button class="search-btn" name="search"><img src="..\images\search.png" alt="Fav"></button>
      <input class="search-bar" name="search" placeholder="Search farms and products" type="text" value="<?php if (isset($_GET['search'])) {
                                                                                                            echo $_GET['search'];
                                                                                                          } ?>">
    </form>

  </div>


  <div class="category-select">

    <ul>
      <li><a href="all-products.php">All products</a></li>
    </ul>

  </div>
  <div class="category-select" style="background-color: #0047AB;">

    <ul class="orders" >
      <li><a href="orders.php">View all orders</a></li>
    </ul>
  </div>

</div>