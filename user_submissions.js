var recordIDs = new Set();
var list_as_string = "";

function submitResponse(){
    if(document.getElementById('city').value != ''){document.getElementById("city_session").innerHTML = document.getElementById("city").value;}
    if(document.getElementById('country').value != ''){document.getElementById("country_session").innerHTML = document.getElementById("country").value;}
    if(document.getElementById('firstCheckMin').value != ''){document.getElementById("amount_session").innerHTML = document.getElementById("firstCheckMin").value;}
    if(document.getElementById('tags').value != ''){document.getElementById("tags_session").innerHTML = document.getElementById("tags").value;}
    displaying_original_ten();
    //document.getElementById("demo").innerHTML = document.getElementById('type_session').textContent;
}
function restoreOriginalResults(){
    document.getElementById("city_session").innerHTML = sessionStorage.getItem('city');
    document.getElementById("country_session").innerHTML = sessionStorage.getItem('country');
    document.getElementById("amount_session").innerHTML = sessionStorage.getItem('min');
    document.getElementById("tags_session").innerHTML = sessionStorage.getItem('tags');
    document.getElementById('city').value = "";
    document.getElementById('country').value = "";
    document.getElementById('firstCheckMin').value = "";
    document.getElementById('tags').value = "";
    displaying_original_ten();
}
function addToFinalList(){
    const input = document.getElementById('final-list').value;
    const idList = input.split(',').map(id => id.trim());
    for(const id of idList){
        if(recordIDs.size <= 10){
            recordIDs.add(id);
            list_as_string = list_as_string.concat(" ", id);
        }
    }
    //recordIDs.add(...idList);
    document.getElementById('final_list_loc').innerHTML =list_as_string;
}
function submitFinalList(){
    if(recordIDs.size >= 10){
        id_array =[];
        for(const id of recordIDs){
            id_array.push(id);
        }
        sendRecordIdsToServer(id_array);
    }else{
        console.warn('You do not have ten funds in your final list.');
    }
}
function sendRecordIdsToServer(recordID) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);  // POSTing to the same page
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Handle response from server
            console.log(this.responseText);
        }
    }
    // Send record IDs to the PHP script
    xhr.send("action=process&recordIDs=" + JSON.stringify(recordID));
}