<?php     
    session_start();
    @include 'db.php';
    /**
     * This is the final page on the external use case side. At this point, the client should have:
     * 1) Filled out the form AND 2) Logged which recommended companies they most would like to connect with.
     */
    $id_num = $_SESSION['id_num_user'];
    $get_variables = "SELECT * FROM VCFinderLists WHERE userID = '$id_num'";
    $result_session = mysqli_query($con, $get_variables);
    if(mysqli_num_rows($result_session) > 0){
        $row_session = mysqli_fetch_array($result_session);
        $_SESSION['recordID_one'] = $row_session['entryOne'];
        $_SESSION['recordID_two'] = $row_session['entryTwo'];
        $_SESSION['recordID_three'] = $row_session['entryThree'];
        $_SESSION['recordID_four'] = $row_session['entryFour'];
        $_SESSION['recordID_five'] = $row_session['entryFive'];
        $_SESSION['recordID_six'] = $row_session['entrySix'];
        $_SESSION['recordID_seven'] = $row_session['entrySeven'];
        $_SESSION['recordID_eight'] = $row_session['entryEight'];
        $_SESSION['recordID_nine'] = $row_session['entryNine'];
        $_SESSION['recordID_ten'] = $row_session['entryTen'];      
    }else{
        header('location:user_results.php');
        exit();   
    }

    if(!isset($_SESSION['user_name'])){
        header('location:index.php');
        exit();
    }
    if($_SESSION['generatedResponses'] == 0){
        header('location:user_page.php');
        exit();
    }
    if($_SESSION['generatedFinalList'] == 0){
        header('location:user_results.php');
        exit();
    }

    require_once('db.php');
    $query = "SELECT * FROM defaultdb.VCFinderFunds WHERE Country is NOT NULL AND FirstCheckMin is NOT NULL AND StageofInvestment is NOT NULL";
    $result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale=1.0">
    <title>VCFinder Final Results</title>
    <link rel = "stylesheet" href="style.css">
</head>
<body>
    <a href = "logout.php" class ="logout-btn">Logout</a>
    <!--
        The hidden session variables allow for guaranteed access to the session variables that represent the choices made by the client on user_results.php
        Because the user generated these responses themselves, there is no need to further hide them. 
        By placing them here hidden, the js has guaranteed access.
    -->
    <div class = "container_stuff" style="overflow-x:auto;" id ="user_table_content">
        <div class = "hidden_session_variables" style="display:none;" id="sessionDisplay">
            <p id = "one_session"><?php echo $_SESSION['recordID_one']?></p>
            <p id = "two_session"><?php echo $_SESSION['recordID_two']?></p>
            <p id = "three_session"><?php echo $_SESSION['recordID_three']?></p>
            <p id = "four_session"><?php echo $_SESSION['recordID_four']?></p>
            <p id = "five_session"><?php echo $_SESSION['recordID_five']?></p>
            <p id = "six_session"><?php echo $_SESSION['recordID_six']?></p>
            <p id = "seven_session"><?php echo $_SESSION['recordID_seven']?></p>
            <p id = "eight_session"><?php echo $_SESSION['recordID_eight']?></p>
            <p id = "nine_session"><?php echo $_SESSION['recordID_nine']?></p>
            <p id = "ten_session"><?php echo $_SESSION['recordID_ten']?></p>
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
                </tr>
            <?php
                }
            ?>
        </table>  
    </div>
    <script src = "final_list_display.js"></script>
</body>