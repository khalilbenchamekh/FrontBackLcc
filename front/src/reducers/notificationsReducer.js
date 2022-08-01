import * as types from '../actions';

export default function (state = {
    content: [],
    unread: 0,
    loading: false
}, action) {
    const response = action.response;

    switch (action.type) {

        case types.SET_NOTIFICATIONS:
            return {
                ...state,
                content: response.data ? response.data : [],
                unread: state.content.length,
            };
        case types.SET_NOTIFICATIONS_LOADING:
            return {
                ...state,
                loading: action.payload
            };
        case types.INCREMENT_UNRREAD_NOTIFICATIONS_TO_DOCUMENT:
            return {
                ...state,
                content: state.content.concat(response.data),
                unread:  response.unread,
            };
        default:
            return state;
    }
};
