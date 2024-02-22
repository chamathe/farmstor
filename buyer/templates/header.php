<?php


session_start();
if (isset($_SESSION['buyer_id'])) {
    // If the 'user_id' session variable is set
    $buyer_id = $_SESSION['buyer_id'];
} else {
    $buyer_id="";
}


if(isset($_POST['logout'])){
    unset($_SESSION['buyer_id']);

    header("Location: index.php");
} 

//setting database connection
include('C:\xampp\htdocs\farmstore\config\db-connect.php');

//getting all the user details
$sqlbuyer = "SELECT * FROM buyertb WHERE buyer_id = '$buyer_id'";

//Execute the sql query
$resbuyer = mysqli_query($conn, $sqlbuyer);

$rowbuyer = mysqli_fetch_assoc($resbuyer);

include("add-to-cart.php");
include("add-to-cart-product.php");
include("add-to-fav.php");
include("add-to-fav-all.php");
include("add-to-cart-fav.php");
include("add-to-cart-all.php");
include("delete-fav.php");
include("add-to-fav-product.php");
 
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/header.css">

    
</head>

<body>

    <header>
        <nav>
            <ul>
                <li><a href="home.php"><img src="..\images\home.png" alt="Home"></a></li>
                <li><a href="favourite.php"><img src="..\images\fav.png" alt="Fav"></a></li>
                <a href="cart.php"><img src="..\images\cart.png" alt="Cart"> <strong><?php  echo $item_count ?></strong></a>
            </ul>
        </nav>
        <div class="logo">
        <img  src="../images/logo.png" alt="#">
        <h1>FarmStore</h1>
        </div>
        <?php if($buyer_id){ ?>
            <a class="profile" href="profile.php">🧑🏻<b><?php  echo $rowbuyer['fname'] ?></b></a>
     <?php } else { ?>
      <a class="not-logged" href="index.php">Login</a>
      <?php } ?>
        
    </header>