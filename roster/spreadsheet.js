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

    const data = {
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
        'result': resultToCode(flightData[10]),
        'editor': flightData[11] == 'Editor',
        'aparato': aparatoToCode(flightData[13])
    }  

    data.ag = data.ag?data.ag:0;
    data.aa = data.aa?data.aa:0;
    data.naval = data.naval?data.naval:0;
    data.aar = data.aar?data.aar:0;
    data.apontaje = data.apontaje?data.apontaje:0;
    data.bonb = data.bonb?data.bonb:0;

    return data;
}

aparatoToCode = aparato => {
    switch (aparato) {
        case 'Patito de Goma (no se presentó al vuelo a pesar de estar apuntado)':
            return 'PATO';
        case 'F/A-18C':
            return 'F18';
        case 'F-16C':
            return 'F16';
        case 'AV-8B':
            return 'AV8B';
        case 'F-14A/B (piloto)':
            return 'F14P';
        case 'F-14A/B (RIO)':
            return 'F14R';
        case 'AH-64 (piloto)':
            return 'AH64P';
        case 'AH-64 (CPG)':
            return 'AH64C';
        default:
            return '-';
    }
}

resultToCode = result => {
    switch (result) {
        case 'RTB, sin daños / Entrenamiento completado':
            return 'RTB';
        case 'RTB, con daños':
            return 'RTB_DAM';
        case 'Aterrizado en campo alternativo aliado':
            return 'RTB_ALT';
        case 'Recuperado (eyectado en zona aliada o neutral)':
            return 'EYECTADO';
        case 'MIA (aterrizado o eyectado en zona enemiga)':
            return 'MIA';
        case 'KIA (muerto)':
            return 'KIA';
        case 'Entrenamiento no completado y otros (desconectado involuntariamente)':
            return 'DISCONNECT';
        default:
            return '-';
    }
}

module.exports = loadSpreadsheet;