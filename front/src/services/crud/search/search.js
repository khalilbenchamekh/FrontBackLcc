import { Url } from "../../../Env/env";

export const getSearchResultsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/getSearch';
    const parameters = {
        method: 'POST',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + payload.payload.token
        },
        body: JSON.stringify(payload.payload.params.searchParams)
    };
    return fetch(LOGIN_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};

export const getSearchResultDetailsService = (payload ) => {
    const LOGIN_API_ENDPOINT = Url + 'api/getSearchWithDetails';
    const parameters = {
        method: 'POST',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + payload.payload.token
        },
        body: JSON.stringify(payload.payload.params.searchParams)
    };
    return fetch(LOGIN_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};
