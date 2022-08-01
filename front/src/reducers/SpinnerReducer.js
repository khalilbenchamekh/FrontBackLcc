import * as types from '../actions';

export default function (state = {
    loading: false
}, action) {

    switch (action.type) {
        case types.SET_LOADING:
            return {
                ...state,
                loading: action.payload
            };
        default:
            return state;
    }
};
