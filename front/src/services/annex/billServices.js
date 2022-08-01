import { Url } from "../../Env/env";
import FileSaver from 'file-saver';
import download from 'downloadjs';
import { downloadManager } from "../../utils/downloadManager";

let fnGetFileNameFromContentDispostionHeader = function (header) {
    let contentDispostion = header.split(';');
    const fileNameToken = `filename*=UTF-8''`;

    let fileName = 'downloaded.pdf';
    for (let thisValue of contentDispostion) {
        if (thisValue.trim().indexOf(fileNameToken) === 0) {
            fileName = decodeURIComponent(thisValue.trim().replace(fileNameToken, ''));
            break;
        }
    }

    return fileName;
};


export const getBillService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/generatePDF';
    let method = 'POST';
    let token = payload.payload.token;
    let body = payload.payload.obj;


    return downloadManager(LOGIN_API_ENDPOINT, body, method, token);
};


export const getClientToSelectInBillService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/clients';
    const parameters = {
        method: 'GET',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + payload.token
        },

    };

    return fetch(LOGIN_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};
