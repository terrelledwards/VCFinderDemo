/*
 * This function will use the initial three tables above to generate data for the fourth and final table. 
 */
function generateTable() {
    const input = document.getElementById('responseIDInput').value;
    const responseIDs = input.split(',').map(id => id.trim());

    // Reference to the final table
    const finalTable = document.getElementById('final_table');
    while(finalTable.rows.length > 1) { // Assuming the first row is the header
        finalTable.deleteRow(1);
    }
    //finalTable.innerHTML = ''; // Clear previous content

    // Loop through fundTable
    const fundTableRows = document.getElementById('fundTable').rows;
    for (let i = 1; i < fundTableRows.length; i++) {
        const row = fundTableRows[i];
        const responseID = row.cells[1].innerText; // Assuming responseID is in the second column

        if (responseIDs.includes(responseID)) {
            const idNumber = row.cells[0].innerText;
            const listID = row.cells[2].innerText;
            const fundsSet = new Set();

            // Collecting fund IDs
            for (let j = 3; j < row.cells.length; j++) {
                fundsSet.add(row.cells[j].innerText);
            }

            // Loop through dataTable
            const dataTableRows = document.getElementById('dataTable').rows;
            for (let fundId of fundsSet) {
                for (let k = 1; k < dataTableRows.length; k++) {
                    const dataRow = dataTableRows[k];
                    if (dataRow.cells[0].innerText === fundId) {
                        // Create a new row for final_table
                        const newRow = finalTable.insertRow();
                        newRow.innerHTML = `
                            <td>${idNumber}</td>
                            <td>${responseID}</td>
                            <td>${listID}</td>
                            <td>${fundId}</td>
                            ${Array.from(dataRow.cells).map(cell => `<td>${cell.innerText}</td>`).join('')}
                        `;
                        break;
                    }
                }
            }
        }
    }
}