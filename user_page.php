<?php     
    session_start();
    @include 'db.php';
    /**
     * This is the first page of the external use case. It features a form that the client should fill out.
     * When the form is submitted, using POST the responses to the form are saved into a table in a database for later access.
     * In addition, when the form is submitted, the credentials of the user are updated to make it so they can access the next page user_results.php
     */
    if(isset($_POST['submit'])){
        $email =  $_SESSION['email'];
        $name = $_SESSION['user_name'];
        $company = mysqli_real_escape_string($con, $_POST['company']);
        $country = mysqli_real_escape_string($con, $_POST['country']);
        $city = mysqli_real_escape_string($con, $_POST['city']);
        $min = mysqli_real_escape_string($con, $_POST['number']);
        $minTotal = mysqli_real_escape_string($con, $_POST['numberTotal']);
        $roundDescription = mysqli_real_escape_string($con, $_POST['detailed-round-description']);
        $companyDescription = mysqli_real_escape_string($con, $_POST['company-description']);
        $round = mysqli_real_escape_string($con, $_POST['dropdown']);
        $type = mysqli_real_escape_string($con, $_POST['investorType']);
        $lead = mysqli_real_escape_string($con, $_POST['dropdown_3']);
        $tags = mysqli_real_escape_string($con, $_POST['tag']);
        $id_num = $_SESSION['id_num_user'];

        $currentDate = date("Y-m-d");
        $insert = "INSERT INTO VCFinderResponses (userID, username, email, company, countries, cities, minCheck, fundingRound, investorType, submissionDate, tags, needLead, totalRoundRaise, roundDescription, companyDescription) VALUES ('$id_num', '$name', '$email', '$company', '$country','$city', '$min', '$round', '$type', '$currentDate', '$tags', '$lead', '$minTotal', '$roundDescription', '$companyDescription')";
        mysqli_query($con, $insert);
        $generatedResponses = "UPDATE VCFinderLogins SET generatedResponses = '1' WHERE userID = '$id_num'";
        $safe_updates_off = "SET SQL_SAFE_UPDATES = 0";
        $safe_updates_on = "SET SQL_SAFE_UPDATES = 1";
        mysqli_query($con, $safe_updates_off);
        mysqli_query($con, $generatedResponses);
        mysqli_query($con, $safe_updates_on);
        $_SESSION['generatedResponses'] = '1';
        header('location:user_results.php');
        exit();
    }
    if(!isset($_SESSION['user_name'])){
        header('location:index.php');
        exit();
    }
    if($_SESSION['generatedFinalList'] == '1'){
        header('location:user_final_list.php');
        exit();
    }
    if($_SESSION['generatedResponses'] == '1'){
        header('location:user_results.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale=1.0">
    <title>VCFinder</title>
    <link rel = "stylesheet" href="style.css">
</head>
<body>
    <main id="main" class="container">
        <a href = "logout.php" class ="logout-btn">Logout</a>
        <div class="trial-class">
            <h1 id="title">Hello, <span><?php echo $_SESSION['user_name']?></span></h1>
            <p id="description" class="description">Fill out the form below to create a tailored list of VCs</p>
            <form method="post" action="" class = "survey" id="survey-form" name="survey-form" autocomplete="off">
                <fieldset>
                <label for="company" id="company-label">Company Name *</label>
                <input class="labels" type="text" id="company" name="company" placeholder="(required)" required />
                <br>
                <label for ="company-description">Please describe your company.</label>
                <textarea id="company-description" name="company-description" maxlength="495"></textarea>
                </fieldset>
                <fieldset>
                <!--This must be a separate div for each autocomplete to function properly-->
                <div class="autocomplete">
                    <label for="country" id="country-label">Which countries are you seeking investors in? *</label>
                    <input class="labels" type="text" id="country" name="country" placeholder="France, Japan (required)" required />
                </div>
                <div class = "autocomplete">
                    <label for="city" id="city-label">Are there any specific cities or regions you are focused on?</label>
                    <input class="labels" type="text" id="city" name="city" placeholder="London, North America"/>
                </div>
                <div class = "autocomplete">
                    <label for="tags" id="tags-label">Are there any tags which match your company identity?</label>
                    <input class="labels" type="text" id="tags" name="tags" placeholder="B2B SaaS, CleanTech"/>
                </div>
                <div class = "autocomplete">
                    <label for="investorType" id="investorType-label"> Which investor types are you seeking funding from? *</label>
                    <input class="labels" type="text" id="investorType" name="investorType" placeholder="Venture Capital, Angel" required/>
                </div>
                <br>       
                </fieldset>
                <fieldset>
                <label for="number" id="check-label">What is the average check size per investor that you are seeking this round? *</label>
                <input class="labels" type="number" id="number" name="number" placeholder="100000" required />
                <br>
                <label for="numberTotal" id="check-total-label">What is the total amount of funding that you are seeking this round? *</label>
                <input class="labels" type="number" id="numberTotal" name="numberTotal" placeholder="1000000" required />
                <br>
                Please describe the state of the current round and terms if any exist.
                <textarea id="detailed-round-description" name="detailed-round-description" maxlength="495"></textarea>
                </label>
                </fieldset>
                <fieldset>
                <label for="dropdown">
                    Which investment stage are you seeking funding for? *
                    <select id="dropdown" name="dropdown" class="m-t-xs">
                        <option value="Pre-Seed" selected>Pre-Seed</option>
                        <option value="Seed">Seed</option>
                        <option value="Series A">Series A</option>
                        <option value="Series B">Series B</option>
                        <option value="Series C">Series C</option>
                        <option value="Series D">Series D</option>
                        <option value="Pre-IPO">Pre-IPO</option>
                    </select>
                </label>
                <br>
                <label for="dropdown">
                    Are you looking for a lead investor? *
                    <select id="dropdown_3" name="dropdown_3" class="m-t-xs">
                        <option value="No" selected>No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </label>
                </fieldset>
                <button id="submit" name = "submit" type="submit" class="btn">Submit the form</button>
            </form>
        </div>
    </main>
    <script src = "autocomplete.js"></script>
</body>
