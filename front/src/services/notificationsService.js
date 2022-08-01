import { Url } from "../Env/env";

export const getNotifications = (payload) => {
    let start =payload.payload.start;
    const LOGIN_API_ENDPOINT = Url + 'api/getNotifications/?page='+start;
    const parameters = {
        method: 'GET',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + payload.payload.token
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

