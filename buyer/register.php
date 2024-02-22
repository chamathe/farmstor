<?php
include('C:\xampp\htdocs\farmstore\config\db-connect.php');

$fname = $email = $telephone = $address = '';

$error = array('fname' => '', 'email' => '', 'password' => '', 'cpassword' => '', 'telephone' => '', 'address' => '');

//getting data from the input form

if (isset($_POST['register'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $address = htmlspecialchars($_POST['address']);
    $password = htmlspecialchars($_POST['password']);
    $cpassword = htmlspecialchars($_POST['cpassword']);

    // error vaildation
    if (empty($fname)) {
        $error['fname'] = '‼️ Please enter your name';
    } else {
        $fname = htmlspecialchars($_POST['fname']);
    }

    if (empty($email)) {
        $error['email'] = '‼️ Please enter your email';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            $error['email'] = '‼️ Email must be a valid email address';
        } else {
            $email = htmlspecialchars($_POST['email']);
        }
    }

    if (empty($telephone)) {
        $error['telephone'] = '‼️ Please enter telephone number';
    } else {
        if (strlen($telephone) < 10 || strlen($telephone) > 13) {
            $error['telephone'] = '!! Plese enter valid telephone number';
        } else {
            $telephone = htmlspecialchars($_POST['telephone']);
        }
    }

    if (empty($address)) {
        $error['address'] = '‼️ Please enter your address';
    } else {
        $address = htmlspecialchars($_POST['address']);
    }


    if (empty($password)) {
        $error['password'] = '‼️ Password required';
    } else {
        $password = htmlspecialchars($_POST['password']);
    }

    // check if emails are matching
    if ($password != $cpassword) {
        $error['cpassword'] = '‼️ Passwords are not matching';
    }

    if (array_filter($error)) {
        // if any error do nothing
    } else {
        // escape sql chars
        $fname = htmlspecialchars($_POST['fname']);
        $email = htmlspecialchars($_POST['email']);
        $telephone = htmlspecialchars($_POST['telephone']);
        $address = htmlspecialchars($_POST['address']);
        $password = sha1($_POST['password']);

        //query for unique email address
        $sql1 = "SELECT * FROM buyertb WHERE email = '$email'";

        //3. Execute the sql query
        $res = mysqli_query($conn, $sql1);

        //4. Count rows to check the user exist or not
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            $error['email'] = '‼️ Email already registered try different email or try logging in';
        } else {
            // create sql if email is unique
            $sql = "INSERT INTO buyertb (fname,email,telephone,address,password) VALUES ('$fname','$email','$telephone','$address','$password')";

            if (mysqli_query($conn, $sql)) {
                //Sql to check wether the user exist or not
                $sql1 = "SELECT * FROM buyertb WHERE email = '$email' AND password = '$password'";

                //Execute the sql query
                $res1 = mysqli_query($conn, $sql1);


                //4. Count rows to check the user exist or not
                $count1 = mysqli_num_rows($res1);

                if ($count1 == 1) {

                    //get user id of the user
                    $array = mysqli_fetch_assoc($res1);
                    $buyer_id = $array["buyer_id"];
                    session_start();
                    $_SESSION["buyer_id"] = $buyer_id;

                    //Redirect to Home page Dashboard
                    header('location: home.php');
                } else {
                    echo 'query error: ' . mysqli_error($conn);
                }
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmStore Register</title>
    <link rel="stylesheet" href="templates/index.css">
</head>

<body>
    <div class="register-left">
        
    </div>
    <div class="register-container">
        <h1 class="reg-header">Register.</h1>
        <form class="register-form" method="POST" action="">
            <div class="name-email">
                <div class="form-group">
                    <p class="fname-label" id="fnameLabel">Full Name</p>
                    <input type="text" id="fname" name="fname" class="fname" placeholder="Full Name*" value="<?php echo $fname ?>">
                    <div class="errormsg"><b><?php echo $error['fname'] ?></b></div>
                </div>
                <div class="form-group">
                    <p class="email-label" id="emailLabel">Email</p>
                    <input type="text" id="email" name="email" class="email" placeholder="Email*" value="<?php echo $email ?>">
                    <div class="errormsg"><b><?php echo $error['email'] ?></b></div>
                </div>
            </div>
            <div class="form-group">
                <p class="telephone-label" id="telephoneLabel">Telephone</p>
                <input type="text" id="telephone" name="telephone" class="telephone" placeholder="Telephone*" value="<?php echo $telephone ?>">
                <div class="errormsg"><b><?php echo $error['telephone'] ?></b></div>
            </div>
            <div class="form-group">
                <p class="address-label" id="addressLabel">Address</p>
                <input type="text" id="address" name="address" class="address" placeholder="Address*" value="<?php echo $address ?>">
                <div class="errormsg"><b><?php echo $error['address'] ?></b></div>
            </div>
            <div class="name-email">
                <div class="form-group">
                    <p class="password-label" for="password" id="passwordLabel">Password</p>
                    <input type="password" id="password" name="password" class="password" placeholder="Password*">
                    <div class="errormsg"><b><?php echo $error['password'] ?></b></div>
                </div>
               

                <div class="form-group">
                    <p class="cpassword-label" for="cpassword" id="cpasswordLabel">Confirm Password</p>
                    <input type="password" id="cpassword" name="cpassword" class="cpassword" placeholder="Confirm Password*">
                    <div class="errormsg"><b><?php echo $error['cpassword'] ?></b></div>
                </div>
            </div>
            <div class="button-link">
                <div class="redirect-login">
                    <p>Already a member?</p><a href="index.php">◄ Please Login</a>
                </div>
                <div class="form-group">
                    <button type="submit" name="register">Register</button>
                </div>
            </div>

        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var fnameInput = document.getElementById('fname');
                var fnameLabel = document.getElementById('fnameLabel');

                fnameInput.addEventListener('focus', function() {
                    fnameLabel.style.display = 'block';
                });

                fnameInput.addEventListener('blur', function() {
                    if (fnameInput.value.trim() === '') {
                        fnameLabel.style.display = 'none';
                    }
                });
            });


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

            document.addEventListener('DOMContentLoaded', function() {
                var telephoneInput = document.getElementById('telephone');
                var telephoneLabel = document.getElementById('telephoneLabel');

                telephoneInput.addEventListener('focus', function() {
                    telephoneLabel.style.display = 'block';
                });

                telephoneInput.addEventListener('blur', function() {
                    if (telephoneInput.value.trim() === '') {
                        telephoneLabel.style.display = 'none';
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                var addressInput = document.getElementById('address');
                var addressLabel = document.getElementById('addressLabel');

                addressInput.addEventListener('focus', function() {
                    addressLabel.style.display = 'block';
                });

                addressInput.addEventListener('blur', function() {
                    if (addressInput.value.trim() === '') {
                        addressLabel.style.display = 'none';
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                var cpasswordInput = document.getElementById('cpassword');
                var cpasswordLabel = document.getElementById('cpasswordLabel');

                cpasswordInput.addEventListener('focus', function() {
                    cpasswordLabel.style.display = 'block';
                });

                cpasswordInput.addEventListener('blur', function() {
                    if (cpasswordInput.value.trim() === '') {
                        cpasswordLabel.style.display = 'none';
                    }
                });
            });
        </script>
    </div>







</body>

</html>