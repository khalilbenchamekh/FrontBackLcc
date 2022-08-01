import {Url} from "../../../Env/env";

export const getBusinessService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/affaires';
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

export const addBusinessService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/affaires';
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
export const updateBusinessService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/affaires/'+payload.payload.obj.id;
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
export const deleteBusinessService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/affaires/'+payload.payload.obj.id;


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

export const addMultiBusinessService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/affaires/multi';
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
