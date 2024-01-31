<?php
@include 'db.php';
session_start();
/**
 * This file acts as the default login page for the site. 
 * The client enters their username and unencrypted password (which is then re-encrypted using md5) and it is checked for a match within the database.
 * If a match is found, the user is identified as internal or external and sent to the proper page after. 
 * If the user is external, the page they are sent to is the one furthest into the process that they have not completed.
 */
if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = md5($_POST['password']);

    $currentDate = date("Y-m-d");
    $select = "SELECT * FROM VCFinderLogins WHERE email = '$email' && passwords = '$pass'";
    $result = mysqli_query($con, $select);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        if($row['userType'] == 'admin' || $row['userType'] == 'Joyance'){
            $_SESSION['admin_name'] = $row['fullname'];
            $_SESSION['id_num'] = $row['userID'];
            $id = $row['userID'];
            $updateLoginDate = "UPDATE VCFinderLogins SET mostRecentLogin = '$currentDate' WHERE userID = '$id'";
            $safe_updates_off = "SET SQL_SAFE_UPDATES = 0";
            $safe_updates_on = "SET SQL_SAFE_UPDATES = 1";
            mysqli_query($con, $safe_updates_off);
            mysqli_query($con, $updateLoginDate);
            mysqli_query($con, $safe_updates_on);
            header('location:admin_page.php');
            exit();
        }elseif($row['userType'] == 'user'){
            $_SESSION['user_name'] = $row['fullname'];
            $_SESSION['id_num_user'] = $row['userID'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['generatedResponses'] = $row['generatedResponses'];
            $_SESSION['generatedFinalList'] = $row['generatedFinalList'];
            $id = $row['userID'];
            $updateLoginDate = "UPDATE VCFinderLogins SET mostRecentLogin = '$currentDate' WHERE userID = '$id'";
            $safe_updates_off = "SET SQL_SAFE_UPDATES = 0";
            $safe_updates_on = "SET SQL_SAFE_UPDATES = 1";
            mysqli_query($con, $safe_updates_off);
            mysqli_query($con, $updateLoginDate);
            mysqli_query($con, $safe_updates_on);
            if($row['generatedResponses'] == 1){
                if($row['generatedFinalList'] == 1){
                    header('location:user_final_list.php');
                    exit();
                }else{
                    header('location:user_results.php');
                    exit();
                }
            }else{
                header('location:user_page.php');
                exit();
            }
        }
    }else{
        $error[] = 'Incorrect email or password.'; 
    }
};
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale=1.0">
    <title>VC Finder Login</title>

    <link rel = "stylesheet" href="style.css">
</head>

<body>
    <div class = "form-container">
        <form action=" " method = "post">
            <!-- 
                Here we use the POST methodology to send the form back to our PHP for submission.
            -->
            <h3>Login Now</h3>
            <?php
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class = "error-msg">'.$error.'</span>';
                };
            };
            ?>
            <input type = "email" name = "email" required placeholder="Enter your email">
            <input type = "password" name = "password" required placeholder="Enter your password">
            <input type = "submit" name = "submit" value = "Login Now" class = "form_btn">
            <p>Don't have an account? <a href ="registration_form.php">Register</a></p>
        </form>
    </div>
</body>