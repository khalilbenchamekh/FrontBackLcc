import {Url} from "../../../Env/env";
import {downloadManager} from "../../../utils/downloadManager";


export const downloadEmployeeDocumentService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/employees/docs';
    let method = 'POST';
    let token = payload.payload.token;
    let data = payload.payload.obj;
    let body = JSON.stringify(data);
    return downloadManager(LOGIN_API_ENDPOINT, body, method, token, data.filename, true);
};


export const getEmployeeService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/employees';
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

export const addEmployeeService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/employees/employee';
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
export const updateEmployeeService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/employees/' + payload.payload.id;
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
export const deleteEmployeeService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/employees/' + payload.payload.obj.id;


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

