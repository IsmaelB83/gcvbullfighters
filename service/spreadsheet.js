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
                    const flightJson = convertToJson(array.join(''))
                    if (flightJson.report_date) {
                        results.push(flightJson)
                    }
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
        'report_date': flightData[0]?`${aux_report_date[2]}-${aux_report_date[1]}-${aux_report_date[0]}`:undefined,
        'nickname': flightData[1],
        'flight_date': flightData[2]?`${aux_flight_date[2]}-${aux_flight_date[1]}-${aux_flight_date[0]}`:undefined,
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
            return 'PATO'
        case 'F/A-18C':
            return 'F18'
        case 'F-16C':
            return 'F16'
        case 'AV-8B':
            return 'AV8B'
        case 'F-14A/B':
            return 'F14'
        case 'F-14A/B (RIO)':
            return 'RIO'
        case 'AH-64 (piloto)':
            return 'AH64P'
        case 'AH-64 (CPG)':
            return 'AH64C'
        case 'A-10C':
            return 'A10C'
        case 'F-15E (piloto)':
            return 'F15EP'
        case 'ATC / GCI / AWACS':
            return 'CONT'
        case 'F-1':
            return 'F1'
        default:
            return '-'
    }
}

resultToCode = result => {
    switch (result) {
        case 'RTB sin daños / Entrenamiento completado':
            return 'RTB';
        case 'RTB con daños':
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
