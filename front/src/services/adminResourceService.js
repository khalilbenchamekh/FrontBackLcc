import {Url} from "../Env/env";

export const getRouteToProtectService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/auth/Admin/res/routes';

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

export const getUsersWithPermissionsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/auth/Admin/res/users';
    let temp={
        route_name:payload.route_name
    };
    const parameters = {
        method: 'POST',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer '+payload.token
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
export const getSatitstiquesService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/auth/Admin/res/analytics';

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

export const setUsersWithPermissionsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url+'api/auth/Admin/res/setUser';
    let temp={
        permission:payload.route_name+'_'+payload.action,
        user:payload.id,
        attach_or_detach: payload.checked
    };
    const parameters = {
        method: 'POST',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer '+payload.token
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
