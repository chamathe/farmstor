<?php

include('C:\xampp\htdocs\farmstore\config\db-connect.php');

$email = '';
$error = array('email' => '', 'password' => '');

// Get data and check for errors
if (isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($email)) {
        $error['email'] = '‼️ Please enter your email to login';
    } else {
        $email = htmlspecialchars($_POST['email']);
    }

    if (empty($password)) {
        $error['password'] = '‼️ Password required';
    } else {
        $password = htmlspecialchars($_POST['password']);
    }

    if (array_filter($error)) {
        // if any error do nothing
    } else {
        // escape email and password
        $email = htmlspecialchars($_POST['email']);
        $password = sha1(htmlspecialchars($_POST['password']));

        //2. Sql to check wether the user exist or not
        $sql = "SELECT * FROM buyertb WHERE email = '$email' AND password = '$password'";

        //3. Execute the sql query
        $res = mysqli_query($conn, $sql);


        //4. Count rows to check the user exist or not
        $count = mysqli_num_rows($res);

        if ($count == 1) {

            //get user id of the user
            $array = mysqli_fetch_assoc($res);
            $buyer_id = $array["buyer_id"];

            session_start();
            $_SESSION["buyer_id"] = $buyer_id;


            //Redirect to Home page Dashboard
            header('location: home.php');
        } else {

            $error['password'] = '‼️ Your email or password might be incorrect';
        }
    }
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Products Login</title>
    <link rel="stylesheet" href="templates/index.css">
</head>

<body>
    <div class="login-container">
        <h1 class="header">Login.</h1>
        <form class="login-form" method="POST" action="">
            <div class="form-group">
                <p class="email-label" id="emailLabel">Email</p>
                <input type="text" id="email" name="email" class="email" placeholder="Email*" value="<?php echo $email ?>">
                <div class="errormsg"><b><?php echo $error['email'] ?></b></div>
            </div>
            <div class="form-group">
                <p class="password-label" for="password" id="passwordLabel">Password</p>
                <input type="password" id="password" name="password" class="password" placeholder="Password*">
                <div class="errormsg"><b><?php echo $error['password'] ?></b></div>
            </div>
            <div class="form-group">
                <button type="submit" name="login">Login</button>
            </div>
            <div class="redirect-register">
                <p>Not registered yet?</p>
                <a href="register.php" id="registerLink">Register Here ►</a>
            </div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var emailInput = document.getElementById('email');
                var emailLabel = document.getElementById('emailLabel');

                emailInput.addEventListener('focus', function() {
                    emailLabel.style.display = 'block';
                });

                emailInput.addEventListener('blur', function() {
                    if (emailInput.value.trim() === '') {
                        emailLabel.style.display = 'none';
                    }
                });
            });


            document.addEventListener('DOMContentLoaded', function() {
                var passwordInput = document.getElementById('password');
                var passwordLabel = document.getElementById('passwordLabel');

                passwordInput.addEventListener('focus', function() {
                    passwordLabel.style.display = 'block';
                });

                passwordInput.addEventListener('blur', function() {
                    if (passwordInput.value.trim() === '') {
                        passwordLabel.style.display = 'none';
                    }
                });
            });
        </script>
    </div>
    <div class="login-left">
       
    </div>
</body>

</html>