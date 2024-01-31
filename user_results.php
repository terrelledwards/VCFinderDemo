<?php     
    session_start();
    @include 'db.php';
    /**
     * This file is the midway point for the external use case. 
     * To be on this page, one must have completed the form AND NOT have generated a final list. 
     * Once again the POST framework is used to process a submission by the user and insert into a table in our database. 
     */
    $id_num = $_SESSION['id_num_user'];
    $get_variables = "SELECT * FROM VCFinderResponses WHERE userID = '$id_num'";
    $result_session = mysqli_query($con, $get_variables);
    if(mysqli_num_rows($result_session) > 0){
        $row_session = mysqli_fetch_array($result_session);
        $_SESSION['responseID'] = $row_session['responseID'];
        $_SESSION['email'] = $row_session['email'];
        $_SESSION['name'] = $row_session['username'];
        $_SESSION['company'] = $row_session['company'];
        $_SESSION['country'] = $row_session['countries'];
        $_SESSION['city'] = $row_session['cities'];
        $_SESSION['min'] = $row_session['minCheck'];
        $_SESSION['minTotal'] = $row_session['totalRoundRaise'];
        $_SESSION['roundDescription'] = $row_session['roundDescription'];
        $_SESSION['companyDescription'] = $row_session['companyDescription'];
        $_SESSION['round'] = $row_session['fundingRound'];
        $_SESSION['type'] = $row_session['investorType'];
        $_SESSION['tags'] = $row_session['tags'];
        $_SESSION['leadType'] = $row_session['needLead'];
    }
    if(!isset($_SESSION['user_name'])){
        header('location:index.php');
        exit();
    }
  
    if($_SESSION['generatedResponses'] == '0'){
        header('location:user_page.php');
        exit();
    }
    
    if($_SESSION['generatedFinalList'] == '1'){
        header('location:user_final_list.php');
        exit();
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'process') {
        if (isset($_POST['recordIDs'])) {

            $recordIDs = json_decode($_POST['recordIDs'], true);
            $id_num = $_SESSION['id_num_user'];
            $response_num = $_SESSION['responseID'];
            $entryOne = mysqli_real_escape_string($con, $recordIDs[0]);
            $entryTwo = mysqli_real_escape_string($con, $recordIDs[1]);
            $entryThree = mysqli_real_escape_string($con, $recordIDs[2]);
            $entryFour = mysqli_real_escape_string($con, $recordIDs[3]);
            $entryFive = mysqli_real_escape_string($con, $recordIDs[4]);
            $entrySix = mysqli_real_escape_string($con, $recordIDs[5]);
            $entrySeven = mysqli_real_escape_string($con, $recordIDs[6]);
            $entryEight = mysqli_real_escape_string($con, $recordIDs[7]);
            $entryNine = mysqli_real_escape_string($con, $recordIDs[8]);
            $entryTen = mysqli_real_escape_string($con, $recordIDs[9]);

            $insertList = "INSERT INTO VCFinderLists (userID, responseID, entryOne, entryTwo, entryThree, entryFour, entryFive, entrySix, entrySeven, entryEight, entryNine, entryTen) VALUES ('$id_num', '$response_num', '$entryOne', '$entryTwo', '$entryThree','$entryFour', '$entryFive', '$entrySix', '$entrySeven', '$entryEight', '$entryNine', '$entryTen')";
            mysqli_query($con, $insertList);
            $generatedFinalListQuery = "UPDATE VCFinderLogins SET generatedFinalList = '1' WHERE userID = '$id_num'";
            $safe_updates_off = "SET SQL_SAFE_UPDATES = 0";
            $safe_updates_on = "SET SQL_SAFE_UPDATES = 1";
            mysqli_query($con, $safe_updates_off);
            mysqli_query($con, $generatedFinalListQuery);
            mysqli_query($con, $safe_updates_on);
            $_SESSION['generatedFinalList'] = '1';
            header('location:user_final_list.php');
            exit();
        } else {
            echo "No data received.";
            exit();
        }
    }
    $query = "SELECT * FROM defaultdb.VCFinderFunds WHERE Country is NOT NULL AND FirstCheckMin is NOT NULL AND StageofInvestment is NOT NULL";
    $result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale=1.0">
    <title>VCFinder Results</title>
    <link rel = "stylesheet" href="style.css">
</head>
<body>
    <a href = "logout.php" class ="logout-btn">Logout</a>
    <br>
    <button class ="ResponseFormButtons" onclick="displaying_next_ten()" id ="nextTenButton">Display Twenty Results</button>
    <button class ="ResponseFormButtons" onclick="displaying_original_ten()" id ="originalTenButton" style = "display:none;">Display Ten Results</button>
    <button class ="ResponseFormButtons" onclick="displaying_thirty()" id="thirtyButton">Display Thirty Results</button>
    <button class ="ResponseFormButtons" onclick="restoreOriginalResults()" id ="restoreButton">Restore Original Results</button>
    <div id="responseForm" class ="listQueryDiv"> 
        <div class ="label-input-pair-autocomplete">
            <label for="city" class="responseFormLabels">City or Region:</label>
            <input type="text" class ="responseFormInputs" id="city" placeholder="Chicago, Middle East">
        </div>
        <div class ="label-input-pair-autocomplete">
            <label for="country" class="responseFormLabels">Country:</label>
            <input type="text" class ="responseFormInputs" id="country" placeholder="United States, United Kingdom">
        </div>
        <div class ="label-input-pair">
            <label for="firstCheckMin" class="responseFormLabels">Individual Check Size:</label>
            <input type="number" class ="responseFormInputs" id="firstCheckMin" placeholder="500000">
        </div>
        <div class ="label-input-pair-autocomplete">
            <label for="tags" class="responseFormLabels">Tags:</label>
            <input type="text" class ="responseFormInputs" id="tags" placeholder="TMT, Software">
        </div>
        <button class ="ResponseFormButtons" onclick="submitResponse()">Submit</button>
        <div class = "label-input-pair">
            <label for ="final-list" class="responseFormLabels">ID Numbers of funds for final list (10 max)</label>
            <input type="text" class ="responseFormInputs" id="final-list" placeholder ="75, 16597, 4370">
        </div>
        <button class ="ResponseFormButtons" onclick = "addToFinalList()">Add to Final List</button>
        <form action=" " method = "post" style = "display:none;" id = "final_values_form" name = "final_values_form">
            <input type = "number" name = "entryOne" id = "entryOne">
            <input type = "number" name = "entryTwo" id = "entryTwo">
            <input type = "number" name = "entryThree" id = "entryThree">
            <input type = "number" name = "entryFour" id = "entryFour">
            <input type = "number" name = "entryFive" id = "entryFive">
            <input type = "number" name = "entrySix" id = "entrySix">
            <input type = "number" name = "entrySeven" id = "entrySeven">
            <input type = "number" name = "entryEight" id = "entryEight">
            <input type = "number" name = "entryNine" id = "entryNine">
            <input type = "number" name = "entryTen" id = "entryTen">
        </form>
        <button class ="ResponseFormButtons" form = "submissionButton" type = "submit" onclick = "submitFinalList()">Submit Final List</button>
    </div>
    <div class = "container_stuff" style="overflow-x:auto;" id ="user_table_content">
        <div class = "hidden_session_variables" style="display:none;" id="sessionDisplay">
            <p id = "city_session"><?php echo $_SESSION['city']?></p>
            <p id = "country_session"><?php echo $_SESSION['country']?></p>
            <p id = "round_session"><?php echo $_SESSION['round']?></p>
            <p id = "type_session"><?php echo $_SESSION['type']?></p>
            <p id = "amount_session"><?php echo $_SESSION['min']?></p>
            <p id = "lead_session"><?php echo $_SESSION['leadType']?></p>
            <p id = "tags_session"><?php echo $_SESSION['tags']?></p>
            <p id = "round_total_session"><?php echo $_SESSION['minTotal']?></p>
        </div>
        <div class = "hidden_list_variables" id ="listDisplay">
            <p id = "final_list_loc"></p>
        </div>
        <table class = "table_two" id = "user_dataTable">                  
            <tr class = "bg-dark text-white">
                <th>ID Number</th>
                <th>Fund Name</th>
                <th>Investment Thesis</th>
                <th>Website</th>
                <th>Fund LinkedIn</th>
                <th style = "display:none">City</th>
                <th style = "display:none">Country</th>
                <th style = "display:none">Stage of Investment</th>
                <th style = "display:none">Investor Type</th>
                <th style = "display:none">First Check Minimum</th>
                <th style = "display:none">First Check Maximum</th>
                <th style = "display:none">Will Lead</th>
                <th style = "display:none">Tags</th>
                <th style = "display:none">State or Region</th>
                <th style = "display:none">Continent</th>
                <th style = "display:none">CoInvestments</th>
                </tr> 
            <tr>
            <?php
                while($row = mysqli_fetch_assoc($result)){
            ?>
                <td><?php echo $row['recordID']?></td>
                <td><?php echo $row['InvestorsName']?></td>
                <td><?php echo $row['InvestmentThesis']?></td>
                <td><a href = "<?php echo $row['Website']?>"target = "_blank"><?php echo $row['Website']?></a></td>
                <td><a href = "<?php echo $row['CompanyLinkedin']?>"target = "_blank"><img src = "linkedin_icon.png" height = "30" width = "30" alt = "LinkedIn Logo Icon"></a></td>
                <td style = "display:none"><?php echo $row['City']?></td>
                <td style = "display:none"><?php echo $row['Country']?></td>
                <td style = "display:none"><?php echo $row['StageofInvestment']?></td>
                <td style = "display:none"><?php echo $row['InvestorType']?></td>
                <td style = "display:none"><?php echo $row['FirstCheckMin']?></td>
                <td style = "display:none"><?php echo $row['FirstCheckMax']?></td>
                <td style = "display:none"><?php echo $row['WillLead']?></td>
                <td style = "display:none"><?php echo $row['UpdatedTags']?></td>
                <td style = "display:none"><?php echo $row['StateOrRegion']?></td>
                <td style = "display:none"><?php echo $row['Continent']?></td>
                <td style = "display:none"><?php echo $row['CoInvestments']?></td>
                </tr>
            <?php
                }
            ?>
        </table>  
    </div>
    <script src = "autocomplete.js"></script>
    <script src = "user_submissions.js"></script>
    <script src = "display_results.js"></script>
</body>
