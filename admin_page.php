<?php  
    session_start();
    //@include 'config.php';
    /**
     * This acts as the base page for internal usage. Unlike the external portion of the site, passing back and forth between pages is fine.
     * There are four possible destinations from this page. Three further into the admin pages and returning to the login page. 
     */
    if(!isset($_SESSION['admin_name'])){
        header('location:index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale=1.0">
    <title>VCFinder Joyance Homepage</title>

    <link rel = "stylesheet" href="style.css">
</head>
<body>
    <button><a href = "logout.php" class ="logout-btn">Logout</a></button>
    <div class = "two-btn-container">
        <button><a href = "internal_full_view.php" class="two-btn">View Full List</a></button>
        <button><a href = "internal_list_view.php" class="two-btn">View Responses</a></button>
        <button><a href = "gpt_request_trial_front.html" class ="two-btn">Chat with GPT</a></button>
    </div>
</body>
