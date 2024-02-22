<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="templates/payment.css">

<?php include("templates/header.php");
if (isset($_POST['submit'])) {
    header('Location:orderstatus.php');
}



?>



<div class="title-area">
    <h1>Payment Details</h1>
    <hr>
</div>
<form action="" method="POST">
<div class="container">
    
        <h2 style="margin-top: -0.5rem; font-family: 'Lato', sans-serif !important; ">Enter payment details</h2>

        <label for="card-type">Card Type:</label>
        <select id="card-type" name="card-type" required>
            <option value="visa">Visa</option>
            <option value="mastercard">MasterCard</option>
        </select>

        <label for="card">Card Number:</label>
        <input type="text" id="card" name="card" placeholder="Card Number" required>

        <label for="expiry">Expiry Date:</label>
        <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required>

        <button name="submit" class="porder" type="submit">Place Order</button>
  
</div>
</form>


<?php include("templates/footer.php"); ?>

</html>