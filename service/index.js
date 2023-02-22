// Node imports
const dotenv = require('dotenv');
dotenv.config();
// Own imports
const loadSpreadsheet = require('./spreadsheet');
const Database = require('./database');

// Constants
const URL = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSrwcVl2vBctc3X5EdoK0CTFx9g4TeTzm9LTEuKnucLs8EIN7qxtgrUxMIgFxFZ3hnGI5YFqqg0JcD0/pub?gid=666879572&single=true&output=tsv';

// Main
async function main() {

    // Entries added
    let inserts = 0;
    // Load roster flights
    const data = await loadSpreadsheet(URL)
    console.log(`Entries in spreadsheet: ${data.length}`);

    // Save into database
    const db = new Database();

    try {
        // Connect to the MySQL server
        await db.connect();
        // Execute a SQL query
        for (let i = 0; i < data.length; i++) {
            const flight = data[i];
            const result = await db.query(`SELECT * FROM roster WHERE nickname = '${flight.nickname}' AND flight_date = '${flight.flight_date}'`)
            if (!result.length) {
                try {
                        const result2 = await db.query(`
                                INSERT INTO roster (report_date, nickname, flight_date, flight_type, ag, aa, naval, aar, apontaje, bonb, result, editor, aparato) 
                                VALUES ('${flight.report_date}', '${flight.nickname}', '${flight.flight_date}', '${flight.flight_type}', ${flight.ag}, ${flight.aa}, ${flight.naval}, ${flight.aar}, ${flight.apontaje}, ${flight.bonb}, '${flight.result}', ${flight.editor}, '${flight.aparato}')`
                        );
                        inserts += 1
                } catch (error) {
                        console.log(error)
                }
            }
        }
        console.log(`Entries added to database: ${inserts}`);
        // Close the connection to the MySQL server
        await db.close();
    } catch (error) {
        console.log(error);
    } finally {
        await db.close();
    }
}

main();