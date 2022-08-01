import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";
export default function (state = {
    error: '',
    feesBusinees: [],
}, action) {
    const response = action.response;
    switch (action.type) {
        case types.GET_BUSINESS_FEES_SUCCESS:
            return {...state, feesBusinees: response.data};
        case types.GET_BUSINESS_FEES_ERROR:
            return {
                ...state,
                error:  response.error
            };
        case types.ADD_BUSINESS_FEES_SUCCESS:
            return {
                ...state,
                feesBusinees: state.feesBusinees.concat(response.data)
            };
        case types.ADD_BUSINESS_FEES_ERROR:
            return {
                ...state,
                error:  response.error

            };
        case types.UPDATE_BUSINESS_FEES_SUCCESS:
            return {
                ...state,
                feesBusinees: updateObjectInArray(state.feesBusinees, response.data, action.id)
            };
        default:
            return state;
    }
};
