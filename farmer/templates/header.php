<?php


session_start();
if (isset($_SESSION['farmer_id'])) {
    // If the 'user_id' session variable is set
    $farmer_id = $_SESSION['farmer_id'];
} else {
    $farmer_id="";
}


if(isset($_POST['logout'])){
    unset($_SESSION['farmer_id']);
   
    header("Location: index.php");
} 

//setting database connection
include('C:\xampp\htdocs\farmstore\config\db-connect.php');

//getting all the user details
$sqlfarmer = "SELECT * FROM farmertb WHERE farmer_id = '$farmer_id'";

//Execute the sql query
$resfarmer = mysqli_query($conn, $sqlfarmer);

$rowfarmer = mysqli_fetch_assoc($resfarmer);

//To get how many pending orders for farmer
$sqlpending1 = "SELECT * FROM checkout_tb WHERE farmer_id = $farmer_id AND order_status='Pending'";
$resultpending1 = mysqli_query($conn, $sqlpending1);
$countpending1 = mysqli_num_rows($resultpending1);

 
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/header.css">

    <title>FarmStore</title>
</head>

<body>

    <header>
        <nav>
            <ul>
                <li><a href="home.php"><img src="..\images\home.png" alt="Home"></a></li>
                <a class="pending-count" href="orders.php"><img class="order-icon" src="..\images\order.png" alt="Cart"> <b  ><?php  echo $countpending1 ?></b></a>
            </ul>
        </nav>
        <div class="logo">
        <img  src="../images/logo.png" alt="#">
        <h1>FarmStore</h1>
        </div>
        
        <?php if($farmer_id){ ?>
            <a class="profile" href="farm.php">👨🏼‍🌾<b><?php  echo $rowfarmer['farm'] ?></b></a>
     <?php } else { ?>
      <a class="not-logged" href="index.php">Login</a>
      <?php } ?>
        
    </header>