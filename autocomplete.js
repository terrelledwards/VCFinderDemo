//autocomplete.js
var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
var unique_tags_list = ["B2B SaaS","Chemicals","AI/ML","Enterprise","Circular Economy","DTC","InsurTech","Real Estate","Energy","Beverage","Consumer Durables","PaaS","HR","Construction","Analytics","Hardware","AgTech","DeepTech","Nanotechnology","Utilities","IT","Subscription","PoC Founder","ClimateTech","Genomics","IoT","Manufacturing","Mobility","Mining","Media","Sports","Data","Materials","Social Networking","Neuroscience","Supply Chain","Legal Services","Entertainment","Future of Work","Underrepresented Founder","Software","Hospitality","Oncology","Enterprise Software","Finance","3D Printing","Consumer Non-Durables","Consumer","Diagnostics","Life Science","FemTech","Digital Health","HealthTech","B2C Electronics","Textiles","Advertising","Wellness","EdTech","Consulting","Female Founder","Pharmaceuticals","Pet Tech","B2C","Fashion","Wearables","Consumer Services","Water","Fitness","Biotechnology","Mobile","Web 3.0","Frontier Tech","TechBio","B2B Data Platforms","Sustainable Materials","Dental","Sustainability","Transportation","Baby Care","CleanTech","LGBTQ+","SaaS","Marketing","Psychedelics","Consumer Goods","Gaming","Impact","Commerce","SilverTech","Aerospace & Aviation","Healthcare Services","Consumer Software","TMT","Travel","Retail","Defense Tech","MedTech","Marketplace","Cannabis","FoodTech","Government","Consumer Health","Events","Oil & Gas","Smart Cities","Creator Economy","Cloud Computing","Business Services","Agnostic","Machinery","AR/VR","E-Commerce","SynBio","Beauty","Nutrition","ConsciousTech","Alcohol","Autonomous Vehicles","Robotics","B2B","Blockchain & Cryptocurrency","Cybersecurity","Veteran Founder"];
var cities = ["Amsterdam","Cologne","Palo Alto","Las Vegas","Geneva","Redwood City","Scottsdale","Houston","Miami","Austin","Dublin","San Mateo","Salt Lake City","Copenhagen","Dallas","Zurich","Minneapolis","Nashville","Oakland","Toronto","Phoenix","Calgary","Santa Clara","Hong Kong","Brussels","Cambridge","Singapore","Baltimore","Barcelona","Rome","Mountain View","Tel Aviv","Bellevue","Washington D.C.","nan","Princeton","Beverly Hills","Detroit","San Diego","Cincinnati","Paris","Stockholm","Burlingame","Basel","Munich","Istanbul","Tokyo","Athens","Sunnyvale","Warsaw","New York City","Valencia","Oxford","Dubai","Oslo","Luxembourg","Portland","Berkeley","Pittsburgh","Milan","Shanghai","San Francisco","Vancouver","Philadelphia","Edinburgh","Los Gatos","Santa Monica","Los Angeles","Lisbon","Tallinn","Beijing","Mumbai","Shenzhen","Hamburg","Lausanne","Denver","Manchester","Berlin","Madrid","Atlanta","Vienna","Stuttgart","San Jose","Brooklyn","Seattle","Lyon","Charlotte","London","Menlo Park","Boston","Frankfurt","Chicago","Columbus","Boulder","Los Altos","Greenwich","Sydney","Durham","Melbourne","Helsinki", "Quebec","British Columbia","Pennsylvania","Massachusetts","Hawaii","Africa","Wisconsin","Michigan","Scotland","Connecticut","Vermont","South Dakota","Northern Ireland","Alaska","North America/Caribbean","Arizona","New Jersey","Montana","Europe","Oklahoma","South America","Texas","Iowa","Nova Scotia","nan","Middle East","Alberta","New Brunswick","Tennessee","Illinois","Wyoming","North Dakota","Ohio","Georgia","Kentucky","Florida","California","Arkansas","Maryland","North Carolina","Oregon","Puerto Rico","South Carolina","Ontario","New York","Maine","Missouri","Asia","Alabama","Idaho","Louisiana","Kansas","Wales","Washington","New Mexico","Nevada","England","New Hampshire","Minnesota","West Virginia","Virginia","Oceania","Rhode Island","Utah","Delaware","Deleware","Indiana","Mississippi","Nebraska","Colorado"];
var unique_investor_types = ["Venture Capital", "Accelerator", "Angel", "Government Office", "Family Office", "Incubator", "Private Equity Firm", "Micro VC"];
function autocomplete(inp, arr) {
        //the autocomplete function takes two arguments, the text field element and an array of possible autocompleted values:
        var currentFocus;
        //execute a function when someone writes in the text field:
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            var parts = val.split(',').map(function(part) { return part.trim(); });
            var currentPart = parts[parts.length - 1];
            //close any already open lists of autocompleted values
            closeAllLists();
            if (!currentPart) { return false;}
            currentFocus = -1;
            //create a DIV element that will contain the items (values):
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            //append the DIV element as a child of the autocomplete container:
            this.parentNode.appendChild(a);
            //for each item in the array...
            for (i = 0; i < arr.length; i++) {
                
                //check if the item starts with the same letters as the text field value:
                if (arr[i].substr(0, currentPart.length).toUpperCase() == currentPart.toUpperCase()) {
                //create a DIV element for each matching element:
                b = document.createElement("DIV");
                //make the matching letters bold:
                b.innerHTML = "<strong>" + arr[i].substr(0, currentPart.length) + "</strong>";
                b.innerHTML += arr[i].substr(currentPart.length);
                //insert a input field that will hold the current array item's value:
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                //execute a function when someone clicks on the item value (DIV element):
                    b.addEventListener("click", function(e) {
                    //insert the value for the autocomplete text field:
                    var chosenValue = this.getElementsByTagName("input")[0].value;
                    parts[parts.length - 1] = chosenValue;  // Replace the last item with the chosen value
                    inp.value = parts.join(', ');
                    //inp.value = this.getElementsByTagName("input")[0].value;
                    //close the list of autocompleted values,(or any other open lists of autocompleted values:
                    closeAllLists();
                });
                a.appendChild(b);
                }
            }
        });
        //execute a function presses a key on the keyboard:
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                //If the arrow DOWN key is pressed, increase the currentFocus variable:
                currentFocus++;
                //and and make the current item more visible:
                addActive(x);
            } else if (e.keyCode == 38) { //up
                //If the arrow UP key is pressed, decrease the currentFocus variable:
                currentFocus--;
                //and and make the current item more visible:
                addActive(x);
            } else if (e.keyCode == 13) {
                //If the ENTER key is pressed, prevent the form from being submitted,
                e.preventDefault();
                if (currentFocus > -1) {
                //and simulate a click on the "active" item:
                    if (x) x[currentFocus].click();
                }
            }
        });
        function addActive(x) {
            //a function to classify an item as "active":
            if (!x) return false;
            //start by removing the "active" class on all items:
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            //add class "autocomplete-active":
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            //a function to remove the "active" class from all autocomplete items:
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            //close all autocomplete lists in the document, except the one passed as an argument:
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        //execute a function when someone clicks in the document:
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
}

autocomplete(document.getElementById("tags"), unique_tags_list);
autocomplete(document.getElementById("country"), countries);
autocomplete(document.getElementById("city"), cities);
autocomplete(document.getElementById("investorType"),unique_investor_types);