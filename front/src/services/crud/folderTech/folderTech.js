import {Url} from "../../../Env/env";

export const getFolderTechService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/folderteches';
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

export const addFolderTechService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/folderteches';
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
export const updateFolderTechService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/folderteches/'+payload.payload.obj.id;
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
export const deleteFolderTechService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/folderteches/'+payload.payload.obj.id;


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


