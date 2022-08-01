import * as types from "../../actions";

export default function (state = {
    error: '',
    loading: false,
    content: []
}, action) {
    switch (action.type) {
        case types.SET_LOG_LOADING:
            return {
                ...state,
                loading: action.payload
            };
        case types.SET_LOG_ERROR:
            return { ...state, error: action.payload };
        case types.SET_LOG:
            return { ...state, content: action.payload };
        default:
            return state;
    }
};
