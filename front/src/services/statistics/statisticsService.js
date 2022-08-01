import { Url } from "../../Env/env";

export const getStatistics = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/accounting';
    const parameters = {
        method: 'POST',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + payload.payload.token
        },
        body: JSON.stringify(payload.payload.searchParams)
    };
    return fetch(LOGIN_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};
