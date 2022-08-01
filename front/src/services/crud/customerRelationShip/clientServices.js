import {Url} from "../../../Env/env";

export const getClientsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/clients';
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

export const addClientsForSelectService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/getClient';
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

export const addClientService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/clients/business';


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
export const updateClientService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/clients/'+payload.payload.obj.id;
    const parameters = {
        method: 'PUT',
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
export const deleteClientService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/clients/'+payload.payload.obj.id;


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

export const addMultiClientService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/clients/multi';
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
