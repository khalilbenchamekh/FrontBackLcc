import { Url } from "../../../Env/env";

export const getLog = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/auth/Admin/res/logs';
    const parameters = {
        method: 'GET',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + payload.payload
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