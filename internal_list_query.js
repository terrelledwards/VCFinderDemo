/*
 * This function happens after the submitResponse button is pressed.
 * All the response values are stored. 
 * The table with the VCFinder Data is iterated over and rows which DO NOT fulfill the search criteria have their display set to "none"
 */
function submitResponse(){
    const city_response = document.getElementById("city").value.trim().toLowerCase();
    const country_response = document.getElementById("country").value.trim().toLowerCase();
    const investmentstage_response = document.getElementById("investmentStage").value.trim().toLowerCase();
    const firstcheckmin_response = document.getElementById("firstCheckMin").value;
    const willlead_response = document.getElementById("willLead").value;
    const investorType_response = document.getElementById("investorType").value.trim().toLowerCase();
    const tags_response = document.getElementById("tags").value.trim().toLowerCase();
    const fund_response = document.getElementById("fund-name").value.trim().toLowerCase();
    const contact_response = document.getElementById("contact-name").value.trim().toLowerCase();
    const queryStyle = document.getElementById("queryStyle").value.trim().toLowerCase();
    const coinvestments_response = document.getElementById("coinvest").value.trim().toLowerCase();

    table = document.getElementById("dataTable");
    rows = table.rows;
    table.style.display = "table";
    displayed_row_count = 0;

    for(i = 1; i < rows.length; i++){
        const fund_row = rows[i].cells[1].textContent.trim().toLowerCase();
        const contact_row = rows[i].cells[2].textContent.trim().toLowerCase();
        const city_row = rows[i].cells[5].textContent.trim().toLowerCase();
        const region_row = rows[i].cells[6].textContent.trim().toLowerCase();
        const country_row = rows[i].cells[7].textContent.trim().toLowerCase();
        const investmentStage_row = rows[i].cells[8].textContent.trim().toLowerCase();
        const investorType_row = rows[i].cells[9].textContent.trim().toLowerCase();
        const firstCheckMin_row = Number(rows[i].cells[10].textContent.replace(/[^0-9.-]+/g,""));
        const willLead_row = rows[i].cells[12].textContent;
        const tags_row = rows[i].cells[13].textContent.trim().toLowerCase();
        const coinvestments_row = row[i].cells[16].textContent.trim().toLowerCase();
                    
        if(queryStyle == "and"){
            fund_match = fund_response === "" || (fund_row.includes(fund_response) && fund_row != "");
            contact_match = contact_response === "" || (contact_row.includes(contact_response) && contact_row != "");
            city_match = city_response === "" || (city_response.includes(city_row) && city_row !== "") || (city_response.includes(region_row) && region_row != "");
            country_match = country_response === "" || (country_response.includes(country_row) && country_row != "");
            investmentStage_match = investmentstage_response === "" || investmentStage_row.includes(investmentstage_response);
            firstcheckin_match = firstcheckmin_response === "" || firstCheckMin_row >= (firstcheckmin_response);
            willLead_match = willlead_response === "" || (!(willLead_row === "") && !(willLead_row === "No"));
            investorType_match = investorType_response === "" || investorType_row.includes(investorType_response);
            tags_match = tags_response === "" || compareStrings(tags_response, tags_row);
            coinvest_match = coinvestments_response === "" || !(coinvestments_row === "");     
            if (fund_match && contact_match && city_match && country_match && investmentStage_match && firstcheckin_match && willLead_match  && investorType_match && tags_match && coinvest_match){
                rows[i].style.display = "";
                displayed_row_count = displayed_row_count + 1;
            }
            else{
                rows[i].style.display = "none";
            }
        }else{
            fund_match =  (fund_row.includes(fund_response) && fund_row != "" && fund_response != "");
            contact_match = (contact_row.includes(contact_response) && contact_row != "" && contact_response != "");
            city_match = (city_response.includes(city_row) && city_row !== "" && city_response != "") || (city_response.includes(region_row) && region_row != "");
            country_match = (country_response.includes(country_row) && country_row != "" && country_response != "");
            investmentStage_match = investmentStage_row.includes(investmentstage_response) && investmentstage_response != "";
            firstcheckin_match = firstCheckMin_row >= (firstcheckmin_response) && firstcheckmin_response != "";
            willLead_match = (!(willLead_row === "") && !(willLead_row === "No")) && willlead_response != "";
            investorType_match = investorType_row.includes(investorType_response) && investorType_response != "";
            tags_match = compareStrings(tags_response, tags_row) && tags_response != "";
            coinvest_match = !(coinvestments_row === "") || coinvestments_response === "";
            if (fund_match || contact_match || city_match || country_match || investmentStage_match || firstcheckin_match || willLead_match  || investorType_match || tags_match || coinvest_match){
                rows[i].style.display = "";
                displayed_row_count = displayed_row_count + 1;
            }
            else{
                rows[i].style.display = "none";
            }
        }
    }
    //This displays the row count in the aforementioned HTML section.
    display_sentence = "This query produced " + String(displayed_row_count) + " result(s)";
    document.getElementById("numResults").innerHTML = display_sentence;
}
/*
    * This function clears the HTML values for all query options. 
    */
function clearResponse(){
    document.getElementById("fund-name").value = "";
    document.getElementById("contact-name").value = "";
    document.getElementById("city").value = "";
    document.getElementById("country").value = "";
    document.getElementById("investmentStage").value = "";
    document.getElementById("investorType").value ="";
    document.getElementById("firstCheckMin").value = "";
    document.getElementById("willLead").value = "";
    document.getElementById("tags").value = "";
    document.getElementById('dataTable').style.display = "none";
    document.getElementById("coinvest").value = "";
    document.getElementById('numResults').innerHTML = "";
    //submitResponse();
}
function compareStrings(string1,string2){
    const array1 = string1.split(',').map(word=>word.trim());
    const array2 = string2.split(',').map(word=>word.trim());
    const commonWords = [];
    for(const word of array1){
        if(array2.includes(word)){
            return true;
        }
    }
    return false;
}