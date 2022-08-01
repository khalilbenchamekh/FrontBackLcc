import {Url} from "../../../Env/env";
import {formaDate} from "../../../utils/dateConverter";

export const getCadastraleConsultationService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/cadastralconsultations';
    const parameters = {
        method: 'GET',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer '+payload.token
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

export const addMultiCadastraleConsultationService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/cadastralconsultations';


    const parameters = {
        method: 'POST',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer '+payload.payload.token
        },

        body: JSON.stringify(payload.payload.multiple)

    };

    return fetch(LOGIN_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};
