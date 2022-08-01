import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";

export default function (state = {
    error: '',
    intermediates: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_INTERMEDIATES_SUCCESS:
            return {...state, intermediates: response.data};
        case types.GET_INTERMEDIATE_ERROR:
            return {
                ...state,
                response
            };
        case types.ADD_INTERMEDIATE_SUCCESS:
            return {
                ...state,
                intermediates: state.intermediates.concat(response.data)
            };
        case types.ADD_INTERMEDIATE_ERROR:
            return {
                ...state,
                response
            };
        case types.UPDATE_INTERMEDIATE_SUCCESS:
            return {
                ...state,
                intermediates: updateObjectInArray(state.intermediates, response.data, action.id)

            };
        case types.DELETE_INTERMEDIATE_SUCCESS:
            return {
                ...state,
                intermediates : state.intermediates.filter( (item, index) => index !== action.id)
            };

        case types.ADD_MULTIPLE_INTERMEDIATE_SUCCESS:
            return {
                ...state,
                intermediates: state.intermediates.concat(response.data)
            };
        case types.ADD_MULTIPLE_INTERMEDIATE_ERROR:
            return {
                ...state,
                error: response
            };
    
        default:
            return state;
    }
};
