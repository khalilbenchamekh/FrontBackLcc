import * as types from '../actions';

export default function (state = {
    token: ''
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.REFRESH_TOKEN_SUCCESS:
            return {
                ...state,
                token: response
            };
        case types.REFRESH_TOKEN_ERROR:
            return {...state, response};
        default:
            return state;
    }
};
