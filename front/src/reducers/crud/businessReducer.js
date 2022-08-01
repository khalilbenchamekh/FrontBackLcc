import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";

export default function (state = {
    error: '',
    business: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_BUSINESS_SUCCESS:
            return {...state, business: response.data};
        case types.GET_BUSINESS_ERROR:
            return {
                ...state,
                response
            };
        case types.ADD_BUSINESS_SUCCESS:
            return {
                ...state,
                business: state.business.concat(response.data)
            };
        case types.ADD_BUSINESS_ERROR:
            return {
                ...state,
                response
            };
        case types.UPDATE_BUSINESS_SUCCESS:
            return {
                ...state,
                business: updateObjectInArray(state.business, response.data, action.id)

            };
        case types.DELETE_BUSINESS_SUCCESS:

            // let newState = [...state];
            // newState.splice(action.index, 1);
            // return newState;
            return {
                ...state,
                business : state.business.filter( (item, index) => index !== action.id)
            };

        case types.ADD_MULTIPLE_BUSINESS_SUCCESS:
            return {
                ...state,
                business: state.business.concat(response.data)
                // business: {...state.business.push(...response.data) }
            };
        case types.ADD_MULTIPLE_BUSINESS_ERROR:
            return {
                ...state,
                error: response
            };
        default:
            return state;
    }
};
