import {Url} from "../../../Env/env";

export const getFolderTechNaturesService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/foldertechnatures ';
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

export const addFolderTechNaturesService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/foldertechnatures';
    let temp={
        Name:payload.payload.Name
    };
    const parameters = {
        method: 'POST',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer '+payload.payload.token
        },

        body: JSON.stringify(temp)

    };
    return fetch(LOGIN_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};
export const updateFolderTechNaturesService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/foldertechnatures/'+payload.payload.obj.id;

    let temp={
        Name:payload.payload.obj.Name
    };
    const parameters = {
        method: 'PUT',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer '+payload.payload.token
        },
        body: JSON.stringify(temp)

    };
    return fetch(LOGIN_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};
export const deleteFolderTechNaturesService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/foldertechnatures/'+payload.payload.obj.id;


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

export const addMultiFolderTechNaturesService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/foldertechnatures/multi';
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
