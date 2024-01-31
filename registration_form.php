<?php
@include 'db.php';
/**
 * This file acts as the registration page for the site. 
 * All passwords are encrytpted using md5. 
 * The safety check is to ensure that emails to accounts are 1:1.
 */
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    if($pass != $cpass){
        $error[] = 'Passwords do not match';
    }else{
    $safety_check = "SELECT * FROM VCFinderLogins WHERE email = '$email'";
    $safety_check_result = mysqli_query($con, $safety_check);
    if(mysqli_num_rows($safety_check_result) > 0){
        $error[] = 'User Already Exists';
        header('location:index.php');
        exit();
    }else{
        $currentDate = date("Y-m-d");
        $insert = "INSERT INTO VCFinderLogins(fullname, email, passwords, userType, signUpDate, mostRecentLogin, generatedResponses, generatedFinalList) VALUES ('$name', '$email', '$pass', 'user', '$currentDate', '$currentDate', '0', '0')";
        mysqli_query($con, $insert);
        header('location:index.php');
        }
    }
};

?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale=1.0">
    <title>Registration Form</title>

    <link rel = "stylesheet" href="style.css">
</head>

<body>
    <div class = "form-container">
        <!-- 
            Here we use the POST methodology to send the form back to our PHP for submission.
        -->
        <form action=" " method = "post">
            <h3>Register Now</h3>
            <?php
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class = "error-msg">'.$error.'</span>';
                };
            };
            ?>
            <input type = "text" name = "name" required placeholder="Enter your name">
            <input type = "email" name = "email" required placeholder="Enter your email">
            <input type = "password" name = "password" required placeholder="Enter your password">
            <input type = "password" name = "cpassword" required placeholder="Confirm your passowrd">
            <input type = "submit" name = "submit" value = "Register Now" class = "form_btn">
            <p>Already have an account? <a href ="index.php">Login</a></p>
        </form>
    </div>
</body>