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
    
    // Load roster flights
    const data = await loadSpreadsheet(URL)
    console.log(`Entries in spreadsheet: ${data.length}`);
    data.forEach(flight => {
        flight.flight_type = 0
        flight.ag = flight.ag ? flight.ag : 0;
        flight.aa = flight.aa ? flight.aa : 0;
        flight.naval = flight.naval ? flight.naval : 0;
        flight.aar = flight.aar ? flight.aar : 0;
        flight.apontaje = flight.apontaje ? flight.apontaje : 0;
        flight.bonb = flight.bonb ? flight.bonb : 0;
        flight.result = 0
        flight.editor = false
        flight.aparato = 0
    });
    
    // Save into database
    const db = new Database();
    
    try {
        // Connect to the MySQL server
        await db.connect();       
        // Execute a SQL query
        let contInserts = 0
        for (let i = 0; i < data.length; i++) {
            const flight = data[i];
            const result = await db.query(`SELECT * FROM roster WHERE nickname = '${flight.nickname}' AND flight_date = '${flight.flight_date}'`)
            if (!result.length) {
                const result2 = await db.query(`
                    INSERT INTO roster (report_date, nickname, flight_date, flight_type, ag, aa, naval, aar, apontaje, bonb, result, editor, aparato) 
                    VALUES ('${flight.report_date}', '${flight.nickname}', '${flight.flight_date}', ${flight.flight_type}, ${flight.ag}, ${flight.aa}, ${flight.naval}, ${flight.aar}, ${flight.apontaje}, ${flight.bonb}, ${flight.result}, ${flight.editor}, ${flight.aparato})`
                );
                if (result2) contInserts += 1
            }
        }
        console.log(`Entries added to database: ${contInserts}`);
        // Close the connection to the MySQL server
        await db.close();
    } catch (error) {
        console.log(error);
    } finally {
        await db.close();
    }
}

main();
