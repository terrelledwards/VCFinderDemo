table = document.getElementById("user_dataTable");
rows = table.rows;
value_ids = new Set();
const entryOne = document.getElementById('one_session').textContent;
const entryTwo = document.getElementById('two_session').textContent;
const entryThree = document.getElementById('three_session').textContent;
const entryFour = document.getElementById('four_session').textContent;
const entryFive = document.getElementById('five_session').textContent;
const entrySix = document.getElementById('six_session').textContent;
const entrySeven = document.getElementById('seven_session').textContent;
const entryEight = document.getElementById('eight_session').textContent;
const entryNine = document.getElementById('nine_session').textContent;
const entryTen = document.getElementById('ten_session').textContent;
value_ids.add(entryOne).add(entryTwo).add(entryThree).add(entryFour).add(entryFive).add(entrySix).add(entrySeven).add(entryEight).add(entryNine).add(entryTen);    
for(i = 1; i < rows.length; i++){
    row_id = Number(rows[i].cells[0].textContent.replace(/[^0-9.-]+/g,""));
    if(row_id == entryOne || row_id == entryTwo || row_id == entryThree || row_id == entryFour || row_id == entryFive || row_id == entrySix || row_id == entrySeven || row_id == entryEight || row_id == entryNine || row_id == entryTen){
        rows[i].style.display = "";
    }else{
        rows[i].style.display = "none";
    }
}