import {Url} from "../../../Env/env";

export const getgreatConstructionSitesService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/greatconstructionsites';
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
export const addgreatConstructionSitesService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/greatconstructionsites';
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
export const updategreatConstructionSitesService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/greatconstructionsites/'+payload.payload.obj.id;

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
export const getSatitstiquesGreatConstructionSiteService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/g_c_s/dashboard';

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
export const getDatailsGreatConstructionSiteService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/greatconstructionsites/'+payload.payload.id;

    const parameters = {
        method: 'GET',
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
export const deletegreatConstructionSitesService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/greatconstructionsites/'+payload.payload.obj.id;


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

