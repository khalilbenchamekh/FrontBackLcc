import { Url } from "../../Env/env";
import { call } from 'redux-saga/effects'
import { downloadManager } from "../../utils/downloadManager";

export const loadConversationsService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/conversations';

    const parameters = {
        method: 'GET',
        credentials: 'same-origin',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + payload.payload.token
        }

    };

    return fetch(LOGIN_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};
export const loadMessagesService = (payload) => {
    let id = payload.payload.conversationId;
    const LOGIN_API_ENDPOINT = Url + 'api/conversations/' + id;
    const parameters = {
        method: 'GET',
        credentials: 'same-origin',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + payload.payload.token
        }
    };
    return fetch(LOGIN_API_ENDPOINT, parameters)
        .then(response => {
            return response.json();
        })
        .then(json => {
            return json;
        });
};

export const sendMessageService = (payload) => {

    let userId = payload.payload.userId;
    const LOGIN_API_ENDPOINT = Url + 'api/conversations/' + userId;
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

export function* loadPreviousMessagesService(payload, url) {
    const apiCall = async () => {
        const LOGIN_API_ENDPOINT = Url + url;
        const parameters = {
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + payload.payload.token
            },
        };
        let apiRes = await fetch(LOGIN_API_ENDPOINT, parameters);
        if (apiRes.status === 200) {
            let json = await apiRes.json();
            return json;
        } else {
            return null;
        }
    };
    try {
        return yield call(apiCall);
    } catch (error) {
        console.log('error:', error);
    }
}

//
// export const loadPreviousMessagesService = (payload,url) => {
//     const LOGIN_API_ENDPOINT = Url + url;
//     const parameters = {
//         method: 'GET',
//         credentials: 'same-origin',
//         headers: {
//             'X-Requested-With': 'XMLHttpRequest',
//             'Accept': 'application/json',
//             'Access-Control-Allow-Origin': '*',
//             'Content-Type': 'application/json',
//             'Authorization': 'Bearer ' + payload.payload.token
//         },
//     };
//
//     return fetch(LOGIN_API_ENDPOINT, parameters)
//         .then(response => {
//             return response.json();
//         })
//         .then(json => {
//             return json;
//         });
// };
export const markAsReadService = (payload) => {
    let id = payload.payload.message.id;
    const LOGIN_API_ENDPOINT = Url + 'api/messages/' + id;
    const parameters = {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
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

export const downloadFileFromService = (payload) => {
    const LOGIN_API_ENDPOINT = Url + 'api/FileManager';
    let method = 'POST';
    let token = payload.payload.token;
    let body = JSON.stringify(payload.payload.obj);

    if (payload.payload.obj.filename) {
        let filename = payload.payload.obj.filename;
        return downloadManager(LOGIN_API_ENDPOINT, body, method, token, filename, true);
    }
};
