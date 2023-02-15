// Node imports
const axios = require('axios');
const csv = require('csv-parser');

// Load spreadsheet and transform
loadSpreadsheet = URL => {
    return new Promise((resolve, reject) => {
        // results
        const results = [];
        // get method and transform
        try {
            axios({
                method: 'get',
                url: URL,
                responseType: 'stream'
            })
            .then(response => {
                response.data.pipe(csv())
                .on('data', data => {
                    const array = []
                    for (let i = 0; i < Object.entries(data).length; i++) {
                        array.push([Object.entries(data)[i][1]])
                    }
                    results.push(convertToJson(array.join('')))
                })
                .on('end', () => resolve(results))
            })            
        } catch (error) {
            reject(error)        
        }
    })
}

convertToJson = (value) => {
    const flightData = value.split('\t');

    const aux_report_date = flightData[0].split(' ')[0].split('/');
    const aux_flight_date = flightData[2].split(' ')[0].split('/');

    return {
        'report_date': `${aux_report_date[2]}-${aux_report_date[1]}-${aux_report_date[0]}`,
        'nickname': flightData[1],
        'flight_date': `${aux_flight_date[2]}-${aux_flight_date[1]}-${aux_flight_date[0]}`,
        'flight_type': flightData[3],
        'ag': parseInt(flightData[4]?flightData[4]:0),
        'aa': parseInt(flightData[5]?flightData[5]:0), 
        'naval': parseInt(flightData[6]?flightData[6]:0),
        'aar': parseInt(flightData[7]?flightData[7]:0),
        'apontaje': parseInt(flightData[8]?flightData[8]:0),
        'bonb': parseInt(flightData[9]?flightData[9]:0),
        'result': flightData[10],
        'editor': flightData[11] == 'Editor',
        'aparato': flightData[12]
    }  
}

module.exports = loadSpreadsheet;