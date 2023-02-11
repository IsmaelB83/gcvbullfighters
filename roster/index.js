// Node imports
// Own imports
const loadSpreadsheet = require('./spreadsheet');

// Constants
const URL = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSrwcVl2vBctc3X5EdoK0CTFx9g4TeTzm9LTEuKnucLs8EIN7qxtgrUxMIgFxFZ3hnGI5YFqqg0JcD0/pub?gid=666879572&single=true&output=tsv';

// Code
loadSpreadsheet(URL)
.then(data => {
    console.log(`Entries received from spreadsheet: ${data.length}`);
    console.log(`-----------------------------------------`);
    data.forEach(flight => console.log(flight))
})