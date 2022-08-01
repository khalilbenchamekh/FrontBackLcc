import {Url} from "../../../Env/env";

export const getInvoiceService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/invoicestatuses';
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

export const addInvoiceService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/invoicestatuses';

    let temp={
        name:payload.payload.obj
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
export const updateInvoiceService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/invoicestatuses/'+payload.payload.obj.id;

    let temp={
        name:payload.payload.obj.name
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
export const deleteInvoiceService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/invoicestatuses/'+payload.payload.obj.id;


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

export const addMultiInvoiceService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/invoicestatuses/multi';
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
