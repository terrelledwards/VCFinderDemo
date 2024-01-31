<?php
    /**
     * Session start is to ensure that all session variablees remain active.
     * Requires access to config.php / db.php for credentials to the database on DigitalOcean
     * Without admin_name set on successful login, clients should be autodirected to login page (index.php)
     */  
    session_start();
    //@include 'config.php';
    if(!isset($_SESSION['admin_name'])){
        header('location:index.php');
        exit();
    }
    require_once('db.php');
    /**
     * The purpose of this page is to display the final lists generated by founders who filled out the form and selected the funds that best fit their raise.
     * Information about the responses by founders to the form is stored in VCFinderResponses (rows are generated in user_page.php).
     * Information about the founders account, including which step in the process they are in, is stored in VCFinderLogins. 
     * Using the SQL query puts the information regarding a founders status on generating a Final List alongside their responses using the common ForeignKey to both lists, userID.
     */
    $query = "SELECT defaultdb.VCFinderResponses.*, defaultdb.VCFinderLogins.generatedFinalList 
    FROM defaultdb.VCFinderResponses 
    JOIN defaultdb.VCFinderLogins 
    ON defaultdb.VCFinderResponses.userID = defaultdb.VCFinderLogins.userID";
    $result = mysqli_query($con, $query);

    //VCFinderLists stores the final funds that a user selected by storing the fundIDs
    $query_two = "SELECT * FROM defaultdb.VCFinderLists";
    $result_two = mysqli_query($con, $query_two);

    //VCFinderFunds stores the complete list of funds. 
    $query_three = "SELECT * FROM defaultdb.VCFinderFunds";
    $result_three = mysqli_query($con, $query_three);
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale=1.0">
    <title>VCFinder Response View</title>

    <link rel = "stylesheet" href="style.css">
</head>
<body>
    <button><a href = "logout.php" class ="logout-btn">Logout</a></button>
    <button><a href = "admin_page.php" class = "switch-view-btn">Return to Base Page</a></button>
    <br>
    <!--
    Above is the HTML for two buttons. 
    Logout returns the user to the login page and destroys their session variables.
    Return to Base Page returns the user to the admin_page from which they can enter the other admin pages.

    Below is the HTML code for the table made using the SQL Join Clause. 
    The table is the VCFinderResponse table with an added column (generatedFinalList) from VCFinderLogins joined using matching ID numbers.
    -->
    <br>
    <div class = "container_table" id ="table_content"> 
        <table class = "table_one" id = "responseTable">                  
            <tr class = "bg-dark text-white">
                <th>ID Number</th>
                <th>Response ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Countries</th>
                <th>Cities</th>
                <th>Stage of Investment</th>
                <th>Investor Type</th>
                <th>First Check Minimum</th>
                <th>Need Lead</th>
                <th>Tags</th>
                <th>Submission Date</th>
                <th>Generated Final List?</th>
            </tr> 
            <tr>
            <?php
                while($row = mysqli_fetch_assoc($result)){
            ?>
                <td><?php echo $row['userID']?></td>
                <td><?php echo $row['responseID']?></td>             
                <td><?php echo $row['username']?></td>
                <td><?php echo $row['email']?></td>
                <td><?php echo $row['company']?></td>
                <td><?php echo $row['countries']?></td>
                <td><?php echo $row['cities']?></td>
                <td><?php echo $row['fundingRound']?></td>
                <td><?php echo $row['investorType']?></td>
                <td><?php echo $row['minCheck']?></td>
                <td><?php echo $row['needLead']?></td>
                <td><?php echo $row['tags']?></td>
                <td><?php echo $row['submissionDate']?></td>
                <td><?php echo $row['generatedFinalList']?></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>

    <input type="text" id="responseIDInput" placeholder="Enter response IDs, comma separated" class ="responseFormInputs">
    <button class="responseFormButtons" onclick="generateTable()">Generate Table</button>
    
    <!--
    The next two tables are hidden because we only want their information for a script function. 
    The first is a table containing the actual lists created by founders by completing the form and selecting companies.
    The second is a table containing the data on the funds in VCFinderFunds. 
    -->
    <div class = "container_table" id ="table_content" style = "display: none;">
        <table class = "table_one" id = "fundTable">                  
            <tr class = "bg-dark text-white">
                <th>ID Number</th>
                <th>Response ID</th>
                <th>List ID</th>
                <th>Fund</th>
                <th>Fund</th>
                <th>Fund</th>
                <th>Fund</th>
                <th>Fund</th>
                <th>Fund</th>
                <th>Fund</th>
                <th>Fund</th>
                <th>Fund</th>
                <th>Fund</th>
            </tr> 
            <tr>
            <?php
                while($row = mysqli_fetch_assoc($result_two)){
            ?>
                <td><?php echo $row['userID']?></td>
                <td><?php echo $row['responseID']?></td>             
                <td><?php echo $row['listID']?></td>
                <td><?php echo $row['entryOne']?></td>
                <td><?php echo $row['entryTwo']?></td>
                <td><?php echo $row['entryThree']?></td>
                <td><?php echo $row['entryFour']?></td>
                <td><?php echo $row['entryFive']?></td>
                <td><?php echo $row['entrySix']?></td>
                <td><?php echo $row['entrySeven']?></td>
                <td><?php echo $row['entryEight']?></td>
                <td><?php echo $row['entryNine']?></td>
                <td><?php echo $row['entryTen']?></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>
    <div class = "container_table" id ="table_content" style = "display: none;">
        <table class = "table_one" id = "dataTable">                  
            <tr class = "bg-dark text-white">
                <th>ID Number</th>
                <th>Fund Name</th>
                <th>City</th>
                <th>Country</th>
                <th>Stage of Investment</th>
                <th>Investor Type</th>
                <th>First Check Minimum</th>
                <th>First Check Maximum</th>
                <th>Will Lead</th>
                <th>Tags</th>
                <th>Investment Thesis</th>
                <th>Fund LinkedIn</th>  
            </tr> 
            <tr>
            <?php
                while($row = mysqli_fetch_assoc($result_three)){
            ?>
                <td><?php echo $row['recordID']?></td>
                <td><?php echo $row['InvestorsName']?></td>
                <td><?php echo $row['City']?></td>
                <td><?php echo $row['Country']?></td>
                <td><?php echo $row['StageofInvestment']?></td>
                <td><?php echo $row['InvestorType']?></td>
                <td><?php echo $row['FirstCheckMin']?></td>
                <td><?php echo $row['FirstCheckMax']?></td>
                <td><?php echo $row['WillLead']?></td>
                <td><?php echo $row['UpdatedTags']?></td>
                <td><?php echo $row['InvestmentThesis']?></td>
                <td><a href = "<?php echo $row['CompanyLinkedin']?>"target = "_blank"><img src ="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHwAAAB8CAMAAACcwCSMAAAAYFBMVEUAd7f///8AdbYAcLQAcrX1+Ps+h756qtGNtdZqo80mf7vu9Pnp8fcjeriTt9cAbLLI2upTlMW0zuTV5PAAZ7Ciw97c6fOqyOBgmcg8g71jnspLisCArtIAZK+60+ZQj8O2zNQ0AAADh0lEQVRoge2bbZeqIBCAZcA31BArV6ut//8vV2vbTR3EuAuccw/zoS9gjwwwb0hEHlJnkkdOhMus/oZG99+GUwbgBg7AKG9+4HEuHIF/XkDk8QMeS+oWPQqV8R2ee2AP9HyEN8IHO4pEM8C54/l+CnAS1V6UPgqto4z5grMskp60PuhdRr6mfJx0X+R1gcEMDibXh16AQi9PJ3muXFveYRfw3T6+2/62uTGneBBH8iI1d2gKaFKSqaTOLPDd38xk54gOSbFgD2N3o3nRImxCEherjl1QNnHifz6XE/4QBz6AnRRscrW/5mijgpeR9aHDXgWPb7bhUKmmfIgzrUcdlZJNUttw8AqPMPP2kJN1tTP1grNv4+iHCt7aj3IhUcGPDhzbAfcrhPQOPAtIxcCd+FSBGtiycsEeQmZswSeOkiqoltPurnwAc9dWJg7DVxDyRfVl5jhvYEx+7MsiLtprDu5zaEYZ7/seKPVVuAD70cv/JGNqzYZZY4YJJqNTmfwLzBon65EJESWnPL1kl/QkORXvrlbG091ELueXfU5lNm1N+RMAgnfHtvgNA4u2yflbGxXO8ySVkMsPnR4XjeV3XEv7j+WTpLi+k+ALzLY/H4cz0rgfX40xZRxy3ZzgQ49Fz8/okWZIY8GHVz6pg+5Bc4eN8MQEftitoMnmZMsIfliuhDl9k6U0gUepjr0xFDKAl4rQayqXDXQDeIzsMKTXhkKrAXyj7PVL3h6cdNqhW4TX2v1mEa4/UbEJ1243m/BS52JswrWlRKvwTKP3f4CXx7y7dTnm1b9FV8c0hhfpEDSNhyOCpqriSlut690UXsPvqJiieqytrRjC64nLBKpQfbceUJrBi5n9YDe8n8a1mcEXhwHiivbTmBkjePG5+Bvcx2vCKSP4cv8CoGtubwGOeAy8tmMB3iJhAkPjuvbv5xwrEKLpBSnXD2dN4FhBGnoUvp7xmwSQ6CEEx/6nXD8zN4FjRhMqzMhpiolm6dJm+J+P/A042jXAAzzAAzzAAzzAAzzAAzzAAzzAA1wlaFLvCn6okYeexU30wy387IRiZUBt2blfHCMXvx/iIUNv8Wou8GUlrtV+3gUg84l0/UvBh57zWauqjA3Qzbtu+ADk8dXDi0xbZ43qc5NFT7ef6evE61USr5dovF4f8npxyuuVMb+X5bxeE/R7QdLr1VDi9VLs3df5uA78BVMoP2PF0QCpAAAAAElFTkSuQmCC" height = "30" width = "30"></a></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>
    <!--
    This is shell for the final table. Initially this table is empty.
    After a list id is searched for, the funds in the listID will be displayed with information about them.  
    !-->
    <div class = "container_table" id ="table_content"> <!--style = "display: none;"-->
        <table class = "table_one" id = "final_table">       
        <tr class = "bg-dark text-white">
            <th>ID Number</th>
            <th>Response ID</th>
            <th>List ID</th>
            <th>Fund ID</th>
            <th>Fund Name</th>
            <th>Stage of Investment</th>
            <th>Investor Type</th>
            <th>First Check Minimum</th>
            <th>First Check Maximum</th>
            <th>Will Lead</th>
            <th>Tags</th>
            <th>Investment Thesis</th>
            <th>Fund LinkedIn</th>
        </tr>
    <script src = "internal_list_view.js"></script> 
</body>