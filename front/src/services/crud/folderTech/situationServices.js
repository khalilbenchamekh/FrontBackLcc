import {Url} from "../../../Env/env";

export const getFolderTechSituationsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/foldertechsituations';
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

export const addFolderTechSituationsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/foldertechsituations';


    let temp=payload.payload.obj
    ;
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
export const updateFolderTechSituationsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/foldertechsituations/'+payload.payload.obj.id;

    let temp={
        Name:payload.payload.obj.Name,
        orderChr:payload.payload.obj.orderChr,
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
export const deleteFolderTechSituationsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/foldertechsituations/'+payload.payload.obj.id;


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

export const addMultiFolderTechSituationsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/foldertechsituations/multi';
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
