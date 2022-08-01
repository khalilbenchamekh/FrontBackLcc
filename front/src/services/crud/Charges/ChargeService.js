import {Url} from "../../../Env/env";

export const getChargeService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/charges';
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
export const addChargeService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/charges';
    let formData = payload.payload.obj;
    const parameters = {
        method: 'POST',
        body: formData,
        headers: {
            "Accept": "application/json",
            'Access-Control-Allow-Origin': '*',
            "X-Requested-With": 'XMLHttpRequest',
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
export const updateChargeService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/charges/' + payload.payload.id;
    let formData = payload.payload.obj;
    const parameters = {
        method: 'POST',
        body: formData,
        headers: {
            "Accept": "application/json",
            'Access-Control-Allow-Origin': '*',
            "X-Requested-With": 'XMLHttpRequest',
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
export const deleteChargeService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/charges/' + payload.payload.obj.id;
    const parameters = {
        method: 'DELETE',
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

