import {Url} from "../../Env/env";

export const getAutoCompleteService = (payload) => {
    if(payload.payload){
        if(payload.payload.obj && payload.payload.route){
            let obj =payload.payload.obj;
            let route =payload.payload.route;

            const LOGIN_API_ENDPOINT = Url+'api/'+route;
            const parameters = {
                method: 'POST',
                headers: {
                    'Access-Control-Allow-Origin': '*',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer '+payload.payload.token
                },
                body: JSON.stringify(obj)

            };

            return fetch(LOGIN_API_ENDPOINT, parameters)
                .then(response => {
                    return response.json();
                })
                .then(json => {
                    return json;
                });
        }
    }


};
