<?php
    /**
     * This file 
     */
    session_start();
    @include 'db.php';
    if(!isset($_SESSION['admin_name'])){
        header('location:index.php');
        exit();
    }
    $query = "SELECT * FROM defaultdb.VCFinderFunds";
    $result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale=1.0">
    <title>VCFinder List View</title>
    <link rel = "stylesheet" href="style.css">
</head>
<body>
    <button><a href = "logout.php" class ="logout-btn">Logout</a></button>
    <button><a href = "admin_page.php" class = "switch-view-btn">Return to Base Page</a></button>
    <br>
    <br>
    <div id="responseForm" class ="listQueryDiv"> 
        <div class ="label-input-pair-autocomplete">
            <label for="city" class="responseFormLabels">City or Region:</label>
            <input type="text" class ="responseFormInputs" id="city" placeholder="Chicago">
        </div>
        <div class ="label-input-pair-autocomplete">
            <label for="country" class="responseFormLabels">Country:</label>
            <input type="text" class ="responseFormInputs" id="country" placeholder="United States">
        </div>
        <div class ="label-input-pair">
            <label for="firstCheckMin" class="responseFormLabels">First Check:</label>
            <input type="number" class ="responseFormInputs" id="firstCheckMin" placeholder="500000">
        </div>
        <div class ="label-select-pair">
            <label for="investmentStage" class="responseFormLabels">Investment Stage:</label>
            <select id="investmentStage" class="responseFormSelects">
                <option value=""> </option>
                <option value="Pre-Seed">Pre-Seed</option>
                <option value="Seed">Seed</option>
                <option value="Series A">Series A</option>
                <option value="Series B">Series B</option>
                <option value="Series C">Series C</option>
                <option value="Series D">Series D</option>
                <option value="Series D">Series D</option>
                <option value="Pre-IPO">Pre-IPO</option>
            </select>
        </div>
        <div class ="label-select-pair">
            <label for="investorType" class="responseFormLabels">Investor Type:</label>
            <select id="investorType"  class="responseFormSelects">
                <option value=""> </option>
                <option value="Venture Capital">Venture Capital</option>
                <option value="Accelerator">Accelerator</option>
                <option value="Angel">Angel</option>
                <option value="Government Office">Government Office</option>
                <option value="Family Office">Family Office</option>
                <option value="Incubator">Incubator</option>
                <option value="Private Equity Firm">Private Equity Firm</option>
                <option value="Micro VC">Micro VC</option>
            </select>
        </div>
        <div class ="label-input-pair-autocomplete">
            <label for="tags" class="responseFormLabels">Tags:</label>
            <input type="text" class ="responseFormInputs" id="tags" placeholder="TMT, Software">
        </div>
        <div class ="label-input-pair">
            <label for="fund-name" class="responseFormLabels">Fund Name:</label>
            <input type="text" class ="responseFormInputs" id="fund-name" placeholder="Grove Ventures">
        </div>
        <div class ="label-input-pair">
            <label for="contact-name" class="responseFormLabels">Contact Name:</label>
            <input type="text" class ="responseFormInputs" id="contact-name" placeholder="Sanjay Mehta">
        </div>
        <div class ="label-select-pair">
            <label for="willLead" class="responseFormLabels">Need Lead:</label>
            <select id = "willLead" class="responseFormSelects">
                <option value = ""> </option>
                <option value = "Yes">Yes</option> 
            </select>
        </div>
        <div class ="label-select-pair">
            <label for="coinvest" class="responseFormLabels">Co-Investments:</label>
            <select id = "coinvest" class="responseFormSelects">
                <option value = ""> </option>
                <option value = "Yes">Yes</option> 
            </select>
        </div>
        <div class ="label-select-pair">
            <label for="queryStyle" class="responseFormLabels">Query Style:</label>
            <select id = "queryStyle"  class="responseFormSelects">
                <option value = "AND">AND</option>
                <option value = "OR">OR</option> 
            </select>
        </div>
        <button class ="ResponseFormButtons" onclick="submitResponse()">Submit</button>
        <button class ="ResponseFormButtons" onclick="clearResponse()">Reset</button>
    </div>
    <!--
    The div below will display a sentence with the number of search results after a submitResponse has been clicked.
    !-->
    <div>
        <p id = "numResults"> </p> 
    </div>
    <!--
    The div and table below display the (near) full table of VCFinder data. 
    NOT DISPLAYED CrunchBase data, Primary Connection, Job, Operating Status, Human Review, Similar Funds, and Notes 
    The entire table is loaded and then paired back by user queries. 
    !-->
    <div class = "container_table" id ="table_content">
        <table class = "table_one" id = "dataTable" style = "display: none;">                  
            <tr class = "bg-dark text-white">
                <th>ID Number</th>
                <th>Fund Name</th>
                <th>Contact Name</th>
                <th>Contact Email</th>
                <th>Contact LinkedIn</th>
                <th>City</th>
                <th>State or Region</th>
                <th>Country</th>
                <th>Stage of Investment</th>
                <th>Investor Type</th>
                <th>First Check Minimum</th>
                <th>First Check Maximum</th>
                <th>Will Lead</th>
                <th>Tags</th>
                <th>Investment Thesis</th>
                <th>Fund LinkedIn</th>  
                <th>Co-Investments</th>
            </tr> 
            <tr>
            <?php
                while($row = mysqli_fetch_assoc($result)){
            ?>
                <td><?php echo $row['recordID']?></td>
                <td><?php echo $row['InvestorsName']?></td>             
                <td><?php echo $row['ContactName']?></td>
                <td><?php echo $row['Email']?></td>
                <td><a href = "<?php echo $row['LinkedIn']?>"target = "_blank"><img src ="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHwAAAB8CAMAAACcwCSMAAAAYFBMVEUAd7f///8AdbYAcLQAcrX1+Ps+h756qtGNtdZqo80mf7vu9Pnp8fcjeriTt9cAbLLI2upTlMW0zuTV5PAAZ7Ciw97c6fOqyOBgmcg8g71jnspLisCArtIAZK+60+ZQj8O2zNQ0AAADh0lEQVRoge2bbZeqIBCAZcA31BArV6ut//8vV2vbTR3EuAuccw/zoS9gjwwwb0hEHlJnkkdOhMus/oZG99+GUwbgBg7AKG9+4HEuHIF/XkDk8QMeS+oWPQqV8R2ee2AP9HyEN8IHO4pEM8C54/l+CnAS1V6UPgqto4z5grMskp60PuhdRr6mfJx0X+R1gcEMDibXh16AQi9PJ3muXFveYRfw3T6+2/62uTGneBBH8iI1d2gKaFKSqaTOLPDd38xk54gOSbFgD2N3o3nRImxCEherjl1QNnHifz6XE/4QBz6AnRRscrW/5mijgpeR9aHDXgWPb7bhUKmmfIgzrUcdlZJNUttw8AqPMPP2kJN1tTP1grNv4+iHCt7aj3IhUcGPDhzbAfcrhPQOPAtIxcCd+FSBGtiycsEeQmZswSeOkiqoltPurnwAc9dWJg7DVxDyRfVl5jhvYEx+7MsiLtprDu5zaEYZ7/seKPVVuAD70cv/JGNqzYZZY4YJJqNTmfwLzBon65EJESWnPL1kl/QkORXvrlbG091ELueXfU5lNm1N+RMAgnfHtvgNA4u2yflbGxXO8ySVkMsPnR4XjeV3XEv7j+WTpLi+k+ALzLY/H4cz0rgfX40xZRxy3ZzgQ49Fz8/okWZIY8GHVz6pg+5Bc4eN8MQEftitoMnmZMsIfliuhDl9k6U0gUepjr0xFDKAl4rQayqXDXQDeIzsMKTXhkKrAXyj7PVL3h6cdNqhW4TX2v1mEa4/UbEJ1243m/BS52JswrWlRKvwTKP3f4CXx7y7dTnm1b9FV8c0hhfpEDSNhyOCpqriSlut690UXsPvqJiieqytrRjC64nLBKpQfbceUJrBi5n9YDe8n8a1mcEXhwHiivbTmBkjePG5+Bvcx2vCKSP4cv8CoGtubwGOeAy8tmMB3iJhAkPjuvbv5xwrEKLpBSnXD2dN4FhBGnoUvp7xmwSQ6CEEx/6nXD8zN4FjRhMqzMhpiolm6dJm+J+P/A042jXAAzzAAzzAAzzAAzzAAzzAAzzAA1wlaFLvCn6okYeexU30wy387IRiZUBt2blfHCMXvx/iIUNv8Wou8GUlrtV+3gUg84l0/UvBh57zWauqjA3Qzbtu+ADk8dXDi0xbZ43qc5NFT7ef6evE61USr5dovF4f8npxyuuVMb+X5bxeE/R7QdLr1VDi9VLs3df5uA78BVMoP2PF0QCpAAAAAElFTkSuQmCC" height = "30" width = "30"></a></td>
                <td><?php echo $row['City']?></td>
                <td><?php echo $row['StateOrRegion']?></td>
                <td><?php echo $row['Country']?></td>
                <td><?php echo $row['StageofInvestment']?></td>
                <td><?php echo $row['InvestorType']?></td>
                <td><?php echo $row['FirstCheckMin']?></td>
                <td><?php echo $row['FirstCheckMax']?></td>
                <td><?php echo $row['WillLead']?></td>
                <td><?php echo $row['UpdatedTags']?></td>
                <td><?php echo $row['InvestmentThesis']?></td>
                <td><a href = "<?php echo $row['CompanyLinkedin']?>"target = "_blank"><img src ="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHwAAAB8CAMAAACcwCSMAAAAYFBMVEUAd7f///8AdbYAcLQAcrX1+Ps+h756qtGNtdZqo80mf7vu9Pnp8fcjeriTt9cAbLLI2upTlMW0zuTV5PAAZ7Ciw97c6fOqyOBgmcg8g71jnspLisCArtIAZK+60+ZQj8O2zNQ0AAADh0lEQVRoge2bbZeqIBCAZcA31BArV6ut//8vV2vbTR3EuAuccw/zoS9gjwwwb0hEHlJnkkdOhMus/oZG99+GUwbgBg7AKG9+4HEuHIF/XkDk8QMeS+oWPQqV8R2ee2AP9HyEN8IHO4pEM8C54/l+CnAS1V6UPgqto4z5grMskp60PuhdRr6mfJx0X+R1gcEMDibXh16AQi9PJ3muXFveYRfw3T6+2/62uTGneBBH8iI1d2gKaFKSqaTOLPDd38xk54gOSbFgD2N3o3nRImxCEherjl1QNnHifz6XE/4QBz6AnRRscrW/5mijgpeR9aHDXgWPb7bhUKmmfIgzrUcdlZJNUttw8AqPMPP2kJN1tTP1grNv4+iHCt7aj3IhUcGPDhzbAfcrhPQOPAtIxcCd+FSBGtiycsEeQmZswSeOkiqoltPurnwAc9dWJg7DVxDyRfVl5jhvYEx+7MsiLtprDu5zaEYZ7/seKPVVuAD70cv/JGNqzYZZY4YJJqNTmfwLzBon65EJESWnPL1kl/QkORXvrlbG091ELueXfU5lNm1N+RMAgnfHtvgNA4u2yflbGxXO8ySVkMsPnR4XjeV3XEv7j+WTpLi+k+ALzLY/H4cz0rgfX40xZRxy3ZzgQ49Fz8/okWZIY8GHVz6pg+5Bc4eN8MQEftitoMnmZMsIfliuhDl9k6U0gUepjr0xFDKAl4rQayqXDXQDeIzsMKTXhkKrAXyj7PVL3h6cdNqhW4TX2v1mEa4/UbEJ1243m/BS52JswrWlRKvwTKP3f4CXx7y7dTnm1b9FV8c0hhfpEDSNhyOCpqriSlut690UXsPvqJiieqytrRjC64nLBKpQfbceUJrBi5n9YDe8n8a1mcEXhwHiivbTmBkjePG5+Bvcx2vCKSP4cv8CoGtubwGOeAy8tmMB3iJhAkPjuvbv5xwrEKLpBSnXD2dN4FhBGnoUvp7xmwSQ6CEEx/6nXD8zN4FjRhMqzMhpiolm6dJm+J+P/A042jXAAzzAAzzAAzzAAzzAAzzAAzzAA1wlaFLvCn6okYeexU30wy387IRiZUBt2blfHCMXvx/iIUNv8Wou8GUlrtV+3gUg84l0/UvBh57zWauqjA3Qzbtu+ADk8dXDi0xbZ43qc5NFT7ef6evE61USr5dovF4f8npxyuuVMb+X5bxeE/R7QdLr1VDi9VLs3df5uA78BVMoP2PF0QCpAAAAAElFTkSuQmCC" height = "30" width = "30"></a></td>
                <td><?php echo $row['CoInvestments']?></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>
    <script src = "autocomplete.js"></script>
    <script src = "internal_list_query.js"></script>
</body>