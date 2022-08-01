import {Url} from "../../../Env/env";

export const getLoadsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/FolderTechFees';
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
export const addLoadsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/FolderTechFees';
    let formData =  payload.payload.obj;
    const parameters = {
        method: 'POST',
        body : formData,
        headers: {
            "Accept": "application/json",
            'Access-Control-Allow-Origin': '*',
            "X-Requested-With" : 'XMLHttpRequest',
            'Authorization': 'Bearer '+payload.payload.token
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
export const updateLoadsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/FolderTechFees/'+payload.payload.id;
    let formData =  payload.payload.obj;
    const parameters = {
        method: 'POST',
        body : formData,
        headers: {
            "Accept": "application/json",
            'Access-Control-Allow-Origin': '*',
            "X-Requested-With" : 'XMLHttpRequest',
            'Authorization': 'Bearer '+payload.payload.token
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
export const getSatitstiquesLoadService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/FolderTechFees/statistics';

    const parameters = {
        method: 'POST',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer '+payload.payload.token
        },
        body: JSON.stringify(payload.payload.obj)
    };
    return fetch(LOGIN_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};
export const deleteLoadsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/FolderTechFees/'+payload.payload.obj.id;


    const parameters = {
        method: 'DELETE',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer '+payload.payload.token
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

