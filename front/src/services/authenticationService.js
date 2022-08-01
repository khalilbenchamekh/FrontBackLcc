import { Url } from "../Env/env";
import { convertBlobToBase64 } from "../utils/profile/blobTobase64";

export const registerUserService = (request) => {
    const REGISTER_API_ENDPOINT = 'http://localhost:3000/api/v1/register';

    const parameters = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(request.user)
    };

    return fetch(REGISTER_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};


export const refreshUserService = (request) => {
    const REFRESH_API_ENDPOINT = Url + 'api/auth/refresh';

    const parameters = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Bearer': request
        },
    };

    return fetch(REFRESH_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};

export const loginUserService = (request) => {
    const LOGIN_API_ENDPOINT = Url + 'api/auth/login';

    const parameters = {
        method: 'POST',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(request.user)
    };

    return fetch(LOGIN_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};
export const fetchAsBlob = (url, parameters) => fetch(url, parameters)
    .then(response => response.blob());
export const getProfilInfoServices = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/profile';
    const parameters = {
        method: 'GET',
        responseType: 'blob',
        headers: {
            "Accept": "application/json",
            'Access-Control-Allow-Origin': '*',
            "X-Requested-With": 'XMLHttpRequest',
            'Authorization': 'Bearer ' + payload.payload.token
        },
    };
    return fetchAsBlob(LOGIN_API_ENDPOINT, parameters)
        .then(convertBlobToBase64).catch((error) => {
            console.log(error)
        });


};
export const setProfileInfoServices = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/profile';
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
