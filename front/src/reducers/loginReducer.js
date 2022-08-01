import * as types from '../actions';

export default function (state = {
    token: '',
    data: {}
}, action) {
    const response = action.response;
    console.log(response);
    switch (action.type) {
        case types.SET_TOKEN_SUCCESS:
            return {
                ...state,
                token: response.token
            };
        case types.GET_PROFILE_SUCCESS:
            return {
                ...state,
                data: response
            };

        case types.SET_PROFILE_SUCCESS:
            return {
                ...state,
                data: response
            };
        case types.LOGIN_USER_SUCCESS:
            return { ...state, response };
        case types.LOGIN_USER_ERROR:
            return { ...state, response };
        default:
            return state;
    }
};


