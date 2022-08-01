import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";

export default function (state = {
    error: '',
    clients: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_CLIENTS_SUCCESS:
            return {...state, clients: response.data};
        case types.GET_CLIENTS_ERROR:
            return {
                ...state,
                response
            };
        case types.ADD_CLIENT_SUCCESS:
            return {
                ...state,
                clients: state.clients.concat(response.data)
            };
        case types.ADD_CLIENT_ERROR:
            return {
                ...state,
                response
            };
        case types.UPDATE_CLIENT_SUCCESS:
            return {
                ...state,
                clients: updateObjectInArray(state.clients, response.data, action.id)

            };
        case types.DELETE_CLIENT_SUCCESS:
            return {
                ...state,
                clients : state.clients.filter( (item, index) => index !== action.id)
            };

        case types.ADD_MULTIPLE_CLIENT_SUCCESS:
            return {
                ...state,
                clients: state.clients.concat(response.data)
            };
        case types.ADD_MULTIPLE_CLIENT_ERROR:
            return {
                ...state,
                error: response
            };

        default:
            return state;
    }
};
